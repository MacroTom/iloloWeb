<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Advert;
use App\Models\Review;
use App\Models\Category;
use App\Models\Subcategory;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Database\Eloquent\Builder;

class AdvertController extends Controller
{
    use ApiResponse;

    public function categories(){
        $categories = Category::latest()->get();

        return $this->success('Categories Retrieved!',
            $categories->map(function($category){
                return [
                    'id' => $category->id,
                    'title' => $category->title,
                    'adverts' => $category->advertsCount() > 1 ? $category->advertsCount() ." ads" : $category->advertsCount() ." ad",
                    'subcategories' => $category->subcategories->map(function($subcategory){
                        return [
                            'id' => $subcategory->id,
                            'title' => $subcategory->title,
                            'adverts' => $subcategory->advertsCount() > 1 ? $subcategory->advertsCount() ." ads" : $subcategory->advertsCount()." ad",
                        ];
                    })
                ];
            })->toArray()
        );
    }

    public function index(){
        $advert = Advert::latest()->with('images','views')->paginate(16);

        return $this->success('Adverts Retrieved!', [
            'adverts' => $advert
        ]);
    }

    public function categoriesWithProperties(){
        $categories = Category::with('subcategories','properties')->get();

        return $this->success('Data retrieved!', [
            'formdata' => $categories
        ]);
    }

    public function postAd(Request $request){
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
        $category = Category::find($request->category);

        $subscription = $user->getSubsciptionInCategory($category->category_type);

        // gets active ads in category
        $ads = $user->getActiveAdsInCategory($category->id);

        if($user->role === 'admin') {
            $adType = ['type' => 'special', 'status' => 'active'];
        }
        else{
            // if user has no subscription
            if(!$subscription){
                if($ads->count() >= 1){
                    return $this->error('You have reached your limit for this category. Please upgrade your subscription to post more ads.');
                }
            }
            else{
                if($subscription->plan->max_ads() <= $ads->count()){
                    return $this->error('You have reached your limit for this category. Please upgrade your subscription to post more ads.');
                }
            }
            $adType = [];
        }

        if($request->query('edit')){
            $advert = Advert::find($request->query('edit'));
            if(!$advert) return $this->error('Advert not found!.', []);

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

        return $this->success('Advert has been created!', []);
    }

    public function advert($id, Request $request){
        $temp = Advert::where('id', $id)->with('images','category','subcategory','properties')->first();

        // add user relationship to advert
        $advert = $temp->toArray();

        // if users can show links
        if($temp->user->canShowLinks()){
            $advert['user'] = $advert->user->makeVisible([
                'facebook_link',
                'twitter_link',
                'instagram_link',
                'website_link'
            ]);
        }
        else{
            $advert['user'] = $temp->user
            ->makeHidden(['role']);
        }

        return $this->success('Advert Retrieved!', [
            'advert' => $advert
        ]);
    }

    public function reviews(Request $request){
        if($request->query('user')){
            $reviews = Review::where('user_id', $request->query('user'))->latest()->with('user')->paginate(10);
            return $this->success('Reviews Retrieved!', [
                'reviews' => $reviews
            ]);
        }

        $reviews = Review::latest()->with('user')->paginate(10);
        return $this->success('Reviews Retrieved!', [
            'reviews' => $reviews
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

        return $this->success('Review added!', []);
    }
}
