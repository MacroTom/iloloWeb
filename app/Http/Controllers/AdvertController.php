<?php

namespace App\Http\Controllers;

use App\Models\Advert;
use App\Models\User;
use Inertia\Inertia;
use App\Models\Category;
use App\Models\Property;
use App\Traits\ApiResponse;
use App\Traits\WriteError;
use Illuminate\Http\Request;

class AdvertController extends Controller
{
    use WriteError;

    public function index(){
        $properties = Property::latest()->with('categories')->get();
        $states = getStates();
        return Inertia::render('Adpost',[
            'properties' => $properties,
            'categories' => Category::orderBy('title', 'asc')->with('subcategories')->get(),
            'states' => $states
        ]);
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

        $photos = [];

        foreach ($request->file('photos') as $image) {
            try {
                $path = cloudinary()->upload($image->getRealPath())->getSecurePath();
                array_push($photos, $path);
            } catch (\Throwable $th) {
                $this->log($th, 'cloudinary_photo_upload');
                return redirect()->back()->withErrors([
                    'message' => 'Could not upload photos!.',
                ]);
            }
        }

        $user = User::find($request->user()->id);

        if($user->role === 'admin') {
            $adType = ['type' => 'special'];
        }
        else{
            $adType = [];
        }

        $advert = $user->adverts()->create(array_merge([
            'title' => $request->title,
            'category_id' => $request->category,
            'subcategory_id' => $request->subcategory,
            'state' => $request->state,
            'lga' => $request->lga,
            'price' => $request->price,
            'negotiable' => $request->negotiable,
            'description' => $request->description,
            'properties' => json_encode($request->properties)
        ],$adType));

        $advert->images()->createMany(array_map(function($photo){
            return [
                'source' => $photo
            ];
        },array_reverse($photos)));

        return redirect()->back()->with('message', 'Advert has been created!');
    }

    public function advert($id){
        $advert = Advert::where('id', $id)->with('images','user')->first();
        return Inertia::render('Product', [
            'advert' => $advert
        ]);
    }

    public function adverts(){
        $adverts = Advert::where('type', '!=', 'special')->where('status','active')->latest()->with('images')->take(16)->get();
        $special = Advert::where('type', 'special')->latest()->with('images')->take(16)->get();
        $categories = Category::latest()->get();
        return Inertia::render('Home',[
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
}
