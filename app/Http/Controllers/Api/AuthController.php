<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    use ApiResponse;

    public function index(Request $request){
        return $this->success('User retrieved!', [
            'profile' => $request->user()
        ]);
    }

    public function store(Request $request){
        $request->validate([
            'firstname' => 'required|string',
            'lastname' => 'required|string',
            'email' => 'required|email|unique:users',
            'phone' => 'required',
            'password' => 'required',
            'password_confirm' => ['required', 'same:password']
        ]);

        $user = User::create([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password)
        ]);

        Auth::attempt($request->only(['email','password']));
        $token = $user->createToken('userToken')->plainTextToken;

        return $this->success('Account created!', [
            'token' => $token
        ]);
    }

    public function login(Request $request){
        $request->validate([
            'emailorphone' => 'required',
            'password' => 'required'
        ]);

        $key = str_contains($request->emailorphone, '@') ? 'email' : 'phone';

        // log in user
        if(!Auth::attempt([$key => $request->emailorphone, 'password' => $request->password])){
            return $this->unauthenticated('Incorrect login details');
        }

        $user = User::find(Auth::user()->id);

        $token = $user->createToken('userToken')->plainTextToken;

        return $this->success('Login successful!', [
            'token' => $token
        ]);
    }

    public function logout(Request $request){
        $request->user()->currentAccessToken()->delete();

        return $this->success('Login successful!');
    }
}
