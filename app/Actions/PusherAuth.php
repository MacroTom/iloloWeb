<?php

namespace App\Actions;

use Carbon\Carbon;
use Pusher\Pusher;
use App\Models\Otp;
use App\Models\User;
use App\Services\PusherService;
use App\Traits\WriteError;
use Illuminate\Http\Request;
use App\Traits\HandleResponse;
use Illuminate\Support\Facades\Auth;

class PusherAuth
{
    use WriteError, HandleResponse;

    public function handlePrivateChannelAuth(Request $request, PusherService $pusherService)
    {
        // check if user authenticated
        if (Auth::check()) {
            // Auth data
            $authData = json_encode([
                'user_id' => Auth::user()->id,
                'user_info' => [
                    'name' => Auth::user()->firstname . " " . Auth::user()->lastname,
                ]
            ]);
            $this->log($authData, 'pusher-auth');
            if($request->user()->id == Auth::user()->id){
                return $pusherService->authorizeChannel(
                    $request['channel_name'],
                    $request['socket_id'],
                    $authData
                );
            }
            // if not authorized
            return response()->json(['message'=>'Unauthorized'], 401);
        }
        // if not authenticated
        return response()->json(['message'=>'Not authenticated'], 403);
    }
}
