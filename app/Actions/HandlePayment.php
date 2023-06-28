<?php

namespace App\Actions;

use Carbon\Carbon;
use App\Models\Otp;
use App\Models\User;
use App\Traits\WriteError;
use Illuminate\Http\Request;
use App\Traits\HandleResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;

class HandlePayment
{
    use WriteError, HandleResponse;

    public function handleCallback(Request $request){

    }

    public function handleWebhook(Request $request){
        $paystackSecretKey = env('PAYSTACK_SECRET_KEY');

        try {
            //code...
            if($request->header('x-paystack-signature') === hash_hmac('sha512', $request->getContent(), $paystackSecretKey)){
                if($request->event === 'charge.success'){
                    dd($request->getContent());
                }
            }
            else{
                return response([],400);
            }
        } catch (\Throwable $th) {
            Log::build([
              'driver' => 'single',
              'path' => storage_path('logs/webhook.log'),
            ])->error($th);
        }

        return response([],200);
    }
}
