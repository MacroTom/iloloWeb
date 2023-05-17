<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Otp;
use App\Models\User;
use Inertia\Inertia;
use App\Mail\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;

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

    public function sendOtp(Request $request){
        $request->validate( [
            'email' => 'required|email'
        ]);


        // Verify if account exists with such email
        $record = User::where('email', $request->email)->get();

        if(!$record->count())
        return redirect()->back()->withErrors(['email'=>'No account with such email!']);

        $otp = mt_rand(1273,9726);

        $data = [
            'otp' => $otp
        ];

        // send email
        Mail::to($request->email)->send(new PasswordReset($data));

        Otp::where('otp', $otp)->delete();
        Otp::where('email', $request->email)->delete();

        $added = Otp::create([
            'otp' => $otp,
            'email' => $request->email,
            'expires_after' => 10,
        ]);

        if (!$added) {
            return redirect()->back()->withErrors(['email'=>'Could not send OTP!']);
        }
        return redirect()->back()->with('message', 'OTP has been sent!');
    }

    public function resetPassword(Request $request){
         $this->validate($request,[
             'otp' => 'required|numeric',
             'email' => 'required|email',
             'new_password' => 'required',
             'password_confirm' => ['required', 'same:new_password'],
         ]);

         $otp = $request->otp;

         if(Otp::where('otp', $otp)->value('email') != $request->email){
            return redirect()->back()->withErrors(['message'=>'Invalid OTP!']);
         }

         $now = strtotime(Carbon::now());

         $record = Otp::where('otp', $otp)->value('created_at');

         if(!$record){
            return redirect()->back()->withErrors(['message'=>'Invalid OTP!']);
         }

         $created_at = strtotime($record);

         // check if token has expired
         $difference = ($now - $created_at)/60;
         if($difference >= 10){
             Otp::where('otp', $otp)->delete();
             return redirect()->back()->withErrors(['message'=>'OTP has expired!']);
         }
         Otp::where('otp', $otp)->delete();

         $user = User::where('email', $request->email);

         $user->update(['password' => Hash::make($request->new_password)]);

         return redirect()->back()->with('message', 'Password has been reset!');
    }

    public function logout(Request $request){
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('home')->with('message', 'Logout successful');
    }
}
