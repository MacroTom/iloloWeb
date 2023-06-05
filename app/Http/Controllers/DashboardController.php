<?php

namespace App\Http\Controllers;

use App\Models\Advert;
use App\Models\Property;
use App\Models\User;
use Inertia\Inertia;
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
                'adverts' => Advert::where('state', $request->query('q'))
                    ->orWhere('lga', 'like', '%'. $this->search .'%')
                    ->orWhere('title', 'like', '%'. $this->search .'%')
                    ->orWhere('brand', 'like', '%'. $this->search .'%')->get()
            ]);
        }
        $adverts = Advert::where('role', 1)->paginate(6);
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
        $properties = Property::latest()->get();
        return Inertia::render('Sections/Properties',[
            'properties' => $properties
        ]);
    }

    public function addProperty(Request $request){
        $request->validate([
            'title' => 'required|string|unique:properties',
            'propertyValues' => 'required',
        ]);

        Property::create([
            'title' => strtolower($request->title),
            'label' => strtolower($request?->label),
            'values' => strtolower(implode(",",$request?->propertyValues))
        ]);

        return redirect()->back()->with('message', 'Property created!');
    }

    public function updateProperty(Request $request, $id){
        $property = Property::find($id);

        if(!$property) return redirect()->back()->withErrors([
            'message' => 'Property not found!.',
        ]);

        $property->update([
            'title' => strtolower($request->title),
            'label' => strtolower($request?->label),
            'values' => strtolower(implode(",",$request?->propertyValues))
        ]);

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
}
