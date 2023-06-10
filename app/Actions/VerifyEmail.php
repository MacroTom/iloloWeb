<?php

namespace App\Actions;

use Carbon\Carbon;
use App\Models\Otp;
use App\Models\User;
use App\Traits\WriteError;
use Illuminate\Http\Request;
use App\Traits\HandleResponse;
use Illuminate\Support\Facades\Hash;

class VerifyEmail
{
    use WriteError, HandleResponse;
    public function handle(Request $request){
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required'
        ]);

        $otp = $request->otp;

        if(Otp::where('otp', $otp)->value('email') != $request->email){
            return $this->error($request, 'Invalid OTP!');
        }

        $now = strtotime(Carbon::now());

        $record = Otp::where('otp', $otp)->value('created_at');

        if(!$record){
            return $this->error($request, 'Invalid OTP!');
        }

        $created_at = strtotime($record);

        // check if token has expired
        $difference = ($now - $created_at)/60;
        if($difference >= 10){
            Otp::where('otp', $otp)->delete();
            return $this->error($request, 'OTP has expired!');
        }
        Otp::where('otp', $otp)->delete();

        return $this->success($request, 'Email verification successful!');
    }
}
