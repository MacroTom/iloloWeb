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

class HandlePusher
{
    use WriteError, HandleResponse;

    public function webhookHandler(Request $request)
    {
        $app_secret = env('PUSHER_APP_SECRET');

        $app_key = $request->header('X-PUSHER-KEY');
        $webhook_signature = $request->header('X-PUSHER-SIGNATURE');

        $body = $request->getContent();

        $expected_signature = hash_hmac('sha256', $body, $app_secret, false);

        if ($webhook_signature === $expected_signature) {
            $payload = json_decode($body, true);

            foreach ($payload['events'] as $event) {
                if($event['channel'] === 'presence-onlineStatus'){
                    $user = User::find($event['user_id']);
                    if ($user) {
                        if ($event['name'] === 'member_added') {
                            $user->update([
                                'presence' => 'online'
                            ]);
                        }
                        else{
                            $user->update([
                                'presence' => "offline"
                            ]);
                        }
                    }
                    $this->log($event, 'pusher-events');
                }
            }

            return response('OK', 200);
        } else {
            return response('Not authenticated', 401);
        }
    }
}
