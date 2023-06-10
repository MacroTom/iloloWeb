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
                    'adverts' => $category->adverts->count(),
                    'subcategories' => $category->subcategories->map(function($subcategory){
                        return [
                            'id' => $subcategory->id,
                            'title' => $subcategory->title,
                            'adverts' => $subcategory->adverts->count(),
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
        return $this->success('Adverts Retrieved!', [
            'adverts' => Advert::latest()->paginate(16)
        ]);
    }
}
