<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\User;
use Inertia\Inertia;
use App\Models\Advert;
use App\Models\Category;
use App\Models\Property;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class DashboardController extends Controller
{
    protected $search;
    public function index(){
        return Inertia::render('Dashboard',[]);
    }

    public function login(){
        return Inertia::render('Login',[]);
    }

    public function signin(Request $request){
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        // log in user
        if(!Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            return redirect()->back()->withErrors([
                'message' => 'These credentials do not match our records.',
            ]);
        }

        $role = User::where('email', $request->email)->first()->role;

        $request->session()->regenerate();

        if($role === 'admin' || $role === 1){
            return to_route('admin.dashboard');
        }
        else{
            return to_route('home');
        }
    }

    public function promote($id){
        $user = User::find($id);

        if(!$user) return redirect()->back()->withErrors([
            'message' => 'User not found!.',
        ]);

        $user->role = 1;
        $user->save();
        return redirect()->back()->with('message', 'User is now an admin!');
    }

    public function demote($id){
        $user = User::find($id);

        if(!$user) return redirect()->back()->withErrors([
            'message' => 'User not found!.',
        ]);

        $user->role = 0;
        $user->save();
        return redirect()->back()->with('message', 'Admin is now a user!');
    }

    public function enable($id){
        $user = User::find($id);

        if(!$user) return redirect()->back()->withErrors([
            'message' => 'User not found!.',
        ]);

        $user->status = 'active';
        $user->save();
        return redirect()->back()->with('message', 'User has been enabled!');
    }

    public function disable($id){
        $user = User::find($id);

        if(!$user) return redirect()->back()->withErrors([
            'message' => 'User not found!.',
        ]);

        $user->status = 'disabled';
        $user->save();
        return redirect()->back()->with('message', 'User has been disabled!');
    }

    public function users(Request $request){
        if($request->query('q')){
            $this->search = $request->query('q');
            return Inertia::render('Sections/Users', [
                'users' => User::where('role', 0)->where(function($query){
                    $query->where('firstname', 'like', '%'. $this->search .'%')
                    ->orWhere('lastname', 'like', '%'. $this->search .'%')
                    ->orWhere('email', 'like', '%'. $this->search .'%');
                })->get()
            ]);
        }
        $users = User::where('role', 0)->paginate(6);
        return Inertia::render('Sections/Users',[
            'users' => $users
        ]);
    }

    public function user($id){
        $user = User::find($id);

        if(!$user) return redirect()->back()->withErrors([
            'message' => 'User not found!.',
        ]);

        return Inertia::render('Sections/User',[
            'user' => $user
        ]);
    }

    public function admins(Request $request){
        if($request->query('q')){
            $this->search = $request->query('q');
            return Inertia::render('Sections/Admins', [
                'admins' => User::where('role', 1)->where(function($query){
                    $query->where('firstname', 'like', '%'. $this->search .'%')
                    ->orWhere('lastname', 'like', '%'. $this->search .'%')
                    ->orWhere('email', 'like', '%'. $this->search .'%');
                })->get()
            ]);
        }
        $admins = User::where('role', 1)->paginate(6);
        return Inertia::render('Sections/Admins',[
            'admins' => $admins
        ]);
    }

    public function adverts(Request $request){
        if($request->query('q')){
            $this->search = $request->query('q');
            return Inertia::render('Sections/Adverts', [
                'adverts' => Advert::where('state', 'like', '%'. $this->search .'%')
                    ->orWhere('lga', 'like', '%'. $this->search .'%')
                    ->orWhere('title', 'like', '%'. $this->search .'%')->with('images')->get()
            ]);
        }
        $adverts = Advert::latest()->with('images')->paginate(6);
        return Inertia::render('Sections/Adverts',[
            'adverts' => $adverts
        ]);
    }

    public function properties(Request $request){
        if($request->query('q')){
            $this->search = $request->query('q');
            return Inertia::render('Sections/Properties', [
                'properties' => Property::where('title', $request->query('q'))->get()
            ]);
        }
        $properties = Property::latest()->with('categories')->get();
        $categories = Category::latest()->get();
        return Inertia::render('Sections/Properties',[
            'properties' => $properties,
            'categories' => $categories
        ]);
    }

    public function addProperty(Request $request){
        $request->validate([
            'title' => 'required|string|unique:properties',
            'propertyValues' => 'required',
            'categories' => 'required'
        ]);

        $property = Property::create([
            'title' => $request->title,
            'label' => strtolower($request?->label),
            'values' => implode(",",$request?->propertyValues)
        ]);

        $property->categories()->attach(array_map(fn($category) => $category['id'],$request->categories));

        return redirect()->back()->with('message', 'Property created!');
    }

    public function updateProperty(Request $request, $id){
        $property = Property::find($id);

        if(!$property) return redirect()->back()->withErrors([
            'message' => 'Property not found!.',
        ]);

        $property->update([
            'title' => $request->title,
            'label' => strtolower($request?->label),
            'values' => implode(",",$request?->propertyValues)
        ]);

        $property->categories()->sync(array_map(fn($category) => $category['id'],$request->categories));

        return redirect()->back()->with('message', 'Property updated!');
    }

    public function deleteProperty($id){
        $property = Property::find($id);

        if(!$property) return redirect()->back()->withErrors([
            'message' => 'Property not found!.',
        ]);

        $property->delete();

        return redirect()->back()->with('message', 'Property deleted!');
    }

    public function categories(Request $request){
        if($request->query('q')){
            $this->search = $request->query('q');
            return Inertia::render('Sections/Categories', [
                'categories' => Category::where('title', $request->query('q'))->get()
            ]);
        }
        $categories = Category::latest()->get();
        return Inertia::render('Sections/Categories',[
            'categories' => $categories
        ]);
    }

    public function addCategory(Request $request){
        $request->validate([
            'title' => 'required|string|unique:categories',
        ]);

        Category::create([
            'title' => $request->title
        ]);

        return redirect()->back()->with('message', 'Category created!');
    }

    public function updateCategory(Request $request, $id){
        $category = Category::find($id);

        if(!$category) return redirect()->back()->withErrors([
            'message' => 'Category not found!.',
        ]);

        $category->update([
            'title' => $request->title
        ]);

        return redirect()->back()->with('message', 'Category updated!');
    }

    public function deleteCategory($id){
        $category = Category::find($id);

        if(!$category) return redirect()->back()->withErrors([
            'message' => 'Category not found!.',
        ]);

        $category->delete();

        return redirect()->back()->with('message', 'Category deleted!');
    }

    public function subcategories(Request $request){
        if($request->query('q')){
            $this->search = $request->query('q');
            $categories = Category::latest()->get();
            return Inertia::render('Sections/Subcategories', [
                'categories' => $categories,
                'subcategories' => Subcategory::where('title', $request->query('q'))->with('category')->get()
            ]);
        }
        $subcategories = Subcategory::latest()->with('category')->get();
        $categories = Category::latest()->get();
        return Inertia::render('Sections/Subcategories',[
            'categories' => $categories,
            'subcategories' => $subcategories
        ]);
    }

    public function addSubcategory(Request $request){
        $request->validate([
            'title' => 'required|string|unique:subcategories',
            'category' => 'required',
        ]);

        $category = Category::find($request->category['id']);

        $category->subcategories()->create([
            'title' => $request->title
        ]);

        return redirect()->back()->with('message', 'Subcategory created!');
    }

    public function updateSubcategory(Request $request, $id){
        $subcategory = Subcategory::find($id);

        if(!$subcategory) return redirect()->back()->withErrors([
            'message' => 'Subcategory not found!.',
        ]);

        $subcategory->update([
            'title' => $request->title,
            'category_id' => $request->category['id']
        ]);

        return redirect()->back()->with('message', 'Subcategory updated!');
    }

    public function deleteSubcategory($id){
        $subcategory = Subcategory::find($id);

        if(!$subcategory) return redirect()->back()->withErrors([
            'message' => 'Subcategory not found!.',
        ]);

        $subcategory->delete();

        return redirect()->back()->with('message', 'Subcategory deleted!');
    }

    public function plans(Request $request){
        $categories = Category::latest()->get();
        if($request->query('q')){
            $this->search = $request->query('q');
            return Inertia::render('Sections/Plans', [
                'plans' => Plan::where('title', 'like', '%'. $this->search .'%')->with('categories')->get(),
                'categories' => $categories
            ]);
        }
        $plans = Plan::latest()->with('categories')->paginate(6);
        return Inertia::render('Sections/Plans',[
            'plans' => $plans,
            'categories' => $categories
        ]);
    }

    public function addPlan(Request $request){
        $request->validate([
            'title' => 'required|string|unique:properties',
            'price' => 'required',
            'discount' => 'required',
            'categories' => 'required',
            'properties' => 'required'
        ]);

        $plan = Plan::create([
            'title' => $request->title,
            'price' => $request->price,
            'discount' => $request->discount,
            'properties' => json_encode($request->properties)
        ]);

        $plan->categories()->attach(array_map(fn($category) => $category['id'],$request->categories));

        return redirect()->back()->with('message', 'Plan created!');
    }

    public function updatePlan(Request $request, $id){
        $plan = Plan::find($id);

        if(!$plan) return redirect()->back()->withErrors([
            'message' => 'Plan not found!.',
        ]);

        $plan->update([
            'title' => $request->title,
            'price' => $request->price,
            'discount' => $request->discount,
            'properties' => json_encode($request->properties)
        ]);

        $plan->categories()->sync(array_map(fn($category) => $category['id'],$request->categories));

        return redirect()->back()->with('message', 'Plan updated!');
    }

    public function deletePlan($id){
        $plan = Plan::find($id);

        if(!$plan) return redirect()->back()->withErrors([
            'message' => 'Plan not found!.',
        ]);

        $plan->delete();

        return redirect()->back()->with('message', 'Plan deleted!');
    }
}
