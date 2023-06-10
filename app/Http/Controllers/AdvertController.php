<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Property;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AdvertController extends Controller
{
    public function index(){
        $properties = Property::latest()->with('categories')->get();
        $states = getStates();
        return Inertia::render('Adpost',[
            'properties' => $properties,
            'categories' => Category::orderBy('title', 'asc')->with('subcategories')->get(),
            'states' => $states
        ]);
    }
}
