<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Advert;
use App\Models\Category;
use App\Models\Subcategory;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
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

    public function index(Request $request){
        if($request->query('q')){
            return $this->success('Adverts Retrieved!', [
                'adverts' => Advert::where('title', $request->query('q'))
                ->orWhere('description', 'like', '%'. $request->query('q') .'%')->get()
            ]);
        }
        else if($request->query('lga')){
            return $this->success('Adverts Retrieved!', [
                'adverts' => Advert::where('lga', 'like', '%'. $request->query('lga') .'%')->get()
            ]);
        }
        else{
            if($request->query('state')){
                return $this->success('Adverts Retrieved!', [
                    'adverts' => Advert::where('state', 'like', '%'. $request->query('state') .'%')->get()
                ]);
            }
        }

        return $this->success('Adverts Retrieved!', [
            'adverts' => Advert::latest()->paginate(16)
        ]);
    }
}
