<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Otp;
use App\Models\Plan;
use App\Models\User;
use Inertia\Inertia;
use App\Models\Advert;
use App\Models\Bookmark;
use App\Mail\PasswordReset;
use Illuminate\Http\Request;
use App\Traits\HandleResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\SendOtpRequest;
use Illuminate\Validation\ValidationException;

class AccountController extends Controller
{
    use HandleResponse;
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
            'user' => User::find(Auth::user()->id)->makeVisible([
                'facebook_link',
                'twitter_link',
                'instagram_link',
                'website_link'
            ]),
            'states' => getStates()
        ]);
    }
    public function active(){
        $user = User::find(Auth::user()->id);
        $adverts = $user->adverts()->where('status', 'active')->with('images')->latest()->get();
        return Inertia::render('Active',[
            'adverts' => $adverts
        ]);
    }
    public function review(){
        $user = User::find(Auth::user()->id);
        $adverts = $user->adverts()->where('status', 'review')->with('images')->latest()->get();
        return Inertia::render('Review',[
            'adverts' => $adverts
        ]);
    }
    public function closed(){
        $user = User::find(Auth::user()->id);
        $adverts = $user->adverts()->where('status', 'closed')->with('images')->latest()->get();
        return Inertia::render('Closed',[
            'adverts' => $adverts
        ]);
    }

    public function bookmarks(){
        $user = User::find(Auth::user()->id);

        if($user->bookmarks){
            $bookmarks = $user->bookmarks->map(function($bookmark){
                return [
                    'id' => $bookmark->advert->id,
                    'images' => $bookmark->advert->images,
                    'title' => $bookmark->advert->title,
                    'price' => $bookmark->advert->price,
                    'location' => $bookmark->advert->state .", ".$bookmark->advert->lga,
                    'created_at' => $bookmark->created_at,
                ];
            });
        }
        else{
            $bookmarks = [];
        }
        return Inertia::render('Bookmarks',[
            'bookmarks' => $bookmarks
        ]);
    }

    public function addBookmark($id){
        Bookmark::create([
            'advert_id' => $id,
            'user_id' => Auth::user()->id,
        ]);
        return redirect()->back()->with('message', 'Bookmark added!');
    }

    public function removeBookmark($id){
        $user = User::find(Auth::user()->id);
        $bookmark = $user->bookmarks()->where('advert_id', $id)->first();

        if(!$bookmark) return redirect()->back()->withErrors([
            'message' => 'Bookmark not found!.',
        ]);

        $bookmark->delete();
        return redirect()->back()->with('message', 'Bookmark removed!');
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
            'plancategories' => [
                [
                    'title' => 'Cars',
                    'icon' => 'bx-car',
                    'plans' => Plan::where('category_type', 'C')->get(),
                ],
                [
                    'title' => 'Land & Property',
                    'icon' => 'bx-home',
                    'plans' => Plan::where('category_type', 'L')->get(),
                ],
                [
                    'title' => 'Others',
                    'icon' => 'bx-category',
                    'plans' => Plan::where('category_type', 'O')->get(),
                ],
            ]
        ]);
    }

    public function logout(Request $request){
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('home')->with('message', 'Logout successful');
    }
}
