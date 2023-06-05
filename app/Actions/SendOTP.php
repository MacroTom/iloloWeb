<?php

namespace App\Actions;

use App\Models\Otp;
use App\Models\User;
use App\Mail\PasswordReset;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\SendOtpRequest;
use App\Traits\HandleResponse;
use App\Traits\WriteError;

class SendOTP
{
    use WriteError, HandleResponse;
    public function handle(SendOtpRequest $request){
        // Verify if account exists with such email
        $exist = User::where('email', $request->email)->count();

        if(!$exist)
        return $this->error($request, 'No account with such email!');

        $otp = mt_rand(1273,9726);

        $data = [
            'otp' => $otp
        ];

        // send email
        try{
            Mail::to($request->email)->send(new PasswordReset($data));
        }
        catch(\Throwable $th){
            $this->log($th, 'email');
            return $this->error($request, 'Could not send OTP!');
        }

        Otp::where('otp', $otp)->delete();
        Otp::where('email', $request->email)->delete();

        Otp::create([
            'otp' => $otp,
            'email' => $request->email,
            'expires_after' => 10,
        ]);

        return $this->success($request, 'OTP has been sent!');
    }
}
