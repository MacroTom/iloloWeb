<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class DashboardController extends Controller
{
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
}
