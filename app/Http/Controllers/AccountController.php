<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;

class AccountController extends Controller
{
    public function store(Request $request){
        $request->validate([
            'firstname' => 'required|string',
            'lastname' => 'required|string',
            'email' => 'required|email|unique:users',
            'phone' => 'required',
            'password' => 'required',
            'password_confirm' => ['required', 'same:password']
        ]);

        User::create([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password)
        ]);

        Auth::attempt($request->only(['email','password']));

        $request->session()->regenerate();

        return redirect()->route('home')->with('message', 'Account created!');
    }

    public function login(Request $request){
        $request->validate([
            'emailorphone' => 'required',
            'password' => 'required'
        ]);

        $key = str_contains($request->emailorphone, '@') ? 'email' : 'phone';

        // log in user
        if(!Auth::attempt([$key => $request->emailorphone, 'password' => $request->password])){
            throw ValidationException::withMessages([
                $key => trans('auth.failed'),
            ]);
        }
        $request->session()->regenerate();

        return redirect()->back()->with('message', 'Login successful!');
    }

    public function profile(){
        return Inertia::render('Profile',[

        ]);
    }
    public function active(){
        return Inertia::render('Active',[

        ]);
    }
    public function review(){
        return Inertia::render('Review',[

        ]);
    }
    public function closed(){
        return Inertia::render('Closed',[

        ]);
    }
    public function feedback(){
        return Inertia::render('Feedback',[

        ]);
    }
    public function opinions(){
        return Inertia::render('Opinion',[

        ]);
    }
    public function messages(){
        return Inertia::render('Messages',[

        ]);
    }
    public function premium(){
        return Inertia::render('Premium',[

        ]);
    }

    public function logout(Request $request){
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('home')->with('message', 'Logout successful');
    }
}
