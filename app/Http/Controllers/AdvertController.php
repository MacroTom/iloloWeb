<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\User;
use Inertia\Inertia;
use App\Models\Advert;
use App\Models\Review;
use App\Models\Category;
use App\Models\Property;
use App\Traits\WriteError;
use Cloudinary\Cloudinary;
use App\Traits\ApiResponse;
use App\Models\Subscription;
use Illuminate\Http\Request;
use App\Services\PaystackService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AdvertController extends Controller
{
    use WriteError;

    public function index(Request $request){
        $user = User::find(Auth::user()->id);
        if($request->query('edit') && $user->advertBelongsToUser($request->query('edit'))){
            $temp = Advert::find($request->query('edit'));
            $advert = [
                'advert' => [
                    'id' => $temp->id,
                    'title' => $temp->title,
                    'category' => $temp->category,
                    'subcategory' => $temp->subcategory,
                    'state' => $temp->state,
                    'lga' => $temp->lga,
                    'price' => $temp->price,
                    'negotiable' => $temp->negotiable,
                    'description' => $temp->description,
                    'properties' => $temp->properties,
                    'photos' => $temp->images->map(function($image){
                        return $image->source;
                    }),
                ]
            ];
        }
        else{
            $advert = [];
        }
        $properties = Property::latest()->with('categories')->get();
        $states = getStates();
        return Inertia::render('Adpost',array_merge([
            'properties' => $properties,
            'categories' => Category::orderBy('title', 'asc')->with('subcategories')->get(),
            'states' => $states
        ],$advert));
    }

    public function store(Request $request){
        $request->validate([
            'title' => 'required',
            'category' => 'required',
            'subcategory' => 'required',
            'state' => 'required',
            'lga' => 'required',
            'price' => 'required',
            'negotiable' => 'required',
            'description' => 'required',
            'properties' => 'required',
            'photos' => 'required'
        ]);

        $user = User::find($request->user()->id);

        if($user->role === 'admin') {
            $adType = ['type' => 'special', 'status' => 'active'];
        }
        else{
            $adType = [];
        }

        if($request->query('edit')){
            $advert = Advert::find($request->query('edit'));
            if(!$advert) return redirect()->back()->withErrors([
                'message' => 'Advert not found!.',
            ]);

            $advert->update(array_merge([
                'title' => $request->title,
                'category_id' => $request->category,
                'subcategory_id' => $request->subcategory,
                'state' => $request->state,
                'lga' => $request->lga,
                'price' => $request->price,
                'negotiable' => $request->negotiable,
                'description' => $request->description,
            ],$adType));

            foreach ($advert->images as $image) {
                $image->delete();
            }
            foreach ($advert->properties as $property) {
                $property->delete();
            }
        }
        else{
            $advert = $user->adverts()->create(array_merge([
                'title' => $request->title,
                'category_id' => $request->category,
                'subcategory_id' => $request->subcategory,
                'state' => $request->state,
                'lga' => $request->lga,
                'price' => $request->price,
                'negotiable' => $request->negotiable,
                'description' => $request->description,
            ],$adType));

        }

        $advert->images()->createMany(array_map(function($photo){
            return [
                'source' => $photo
            ];
        },$request->photos));

        $advert->properties()->createMany(
            array_map(function($value, $key){
                return [
                    'property' => $key,
                    'value' => $value
                ];
            },$request->properties, array_keys($request->properties))
        );

        return redirect()->back()->with('message', 'Advert has been created!');
    }

    public function deletePhoto(Request $request){
        $request->validate([
            'public_id' => 'required'
        ]);
        $result = cloudinary()->destroy($request->public_id);

        if($result->headers['Status'][0] !== '200 OK')
        return redirect()->back()->withErrors([
            'message' => 'Could not delete photo!',
        ]);
        return redirect()->back()->with('message', 'Photo deleted!');

    }

    public function advert($id){
        if(Advert::find($id)->user->canShowLinks()){
            $advert = Advert::where('id', $id)->with('images','category','subcategory','properties')->get();
            $user = $advert->user->makeVisible([
                'facebook_link',
                'twitter_link',
                'instagram_link',
                'website_link'
            ]);
        }
        else{
            $advert = Advert::where('id', $id)->with('images','category','subcategory','properties')->first();
            $user = $advert->user;
        }

        $advert->reviews = $advert->reviews()->latest()->with('user')->get();

        // check if user is loggedin
        $user->canReview = Auth::check() ? (Review::where('advert_id', $id)->where('user_id', Auth::user()->id)->count() === 0 ? true : false) : false;

        return Inertia::render('Product', [
            'advert' => $advert,
            'user' => $user,
        ]);
    }

    public function adverts(){
        if(!Auth::check()){
            $bookmarks = [];
        }
        else{
            $bookmarks = User::find(Auth::user()->id)->bookmarks->map(function($bookmark){
                return $bookmark->advert_id;
            });
        }

        $adverts = Advert::where('type', '!=', 'special')->where('status','active')->latest()->with('images')->take(16)->get();
        $special = Advert::where('type', 'special')->where('status','active')->latest()->with('images')->take(16)->get();
        $categories = Category::latest()->get();
        return Inertia::render('Home',[
            'bookmarks' => $bookmarks,
            'adverts' => $adverts,
            'special' => $special,
            'categories' => $categories->map(function($category){
                return [
                    'id' => $category->id,
                    'title' => $category->title,
                    'adverts' => $category->advertsCount(),
                    'subcategories' => $category->subcategories->map(function($subcategory){
                        return [
                            'id' => $subcategory->id,
                            'title' => $subcategory->title,
                            'adverts' => $subcategory->advertsCount(),
                        ];
                    })
                ];
            })->toArray(),
            'location' => getStates()
        ]);
    }

    public function buyPlan($id, Request $request, PaystackService $paystackService){
        $plan = Plan::find($id);
        $user = User::find(Auth::user()->id);

        $category_type = $plan->category_type;

        // check for active subscriptions
        $activeSub = $user->activeSubscriptions()->count();

        if($activeSub > 0){
            // check for an active subscription in the selected category
            $result = $user->hasSubscriptionInCategory($category_type);
            if($result) return redirect()->back()->withErrors([
                'message' => 'A Plan already exist for the selected category!'
            ]);
        }

        // Calculate discount if any
        $amount = floor($plan->price - ($plan->price * ($plan->discount/100)));

        // Calculate expiration time
        $expiration = strtotime("+".$plan->duration.($plan->duration > 1 ? " months" : " month"));

        // create the subscription
        $subscription = Subscription::create([
            'plan_id' => $id,
            'user_id' => Auth::user()->id,
            'status' => 'pending',
            'duration' => $plan->duration,
            'expires' => $expiration
        ]);

        // Get checkout URL
        $data = $paystackService->initialize($user->email, $amount, [
            'item_id' => $subscription->id,
            'payment_type' => 'subscription'
        ]);


        if($data->status() !== 200) return redirect()->back()->withErrors([
            'message' => 'Could not completed transaction!',
        ]);

        $checkout_url = $data["data"]["authorization_url"];
        $reference = $data["data"]["reference"];

        // Create Transaction
        $subscription->transactions()->create([
            'reference' => $reference,
            'user_id' => $user->id,
            'amount' => $amount,
            'status' => 'pending',
        ]);

        // Return with Checkout Redirect URL to make payment!
        return redirect()->back()->with('data', [
            'checkout_url' => $checkout_url
        ]);
    }

    // Add Review
    public function addReview(Request $request){
        $request->validate([
            'rating' => 'required',
            'review' => 'required'
        ]);

        $user = User::find(Auth::user()->id);

        $user->reviews()->create([
            'rating' => $request->rating,
            'review' => $request->review
        ]);

        return redirect()->back()->with('message', 'Review added!');
    }
}
