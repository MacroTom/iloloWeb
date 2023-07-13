<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Message;
use App\Events\NewMessage as NewMessageEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Notifications\NewMessage as NewMessageNotification;
use App\Services\PusherService;

class MessagesController extends Controller
{
    /**
     * Get users list from Message model
     *
     * @param Request $request
     * @return response
     */

    public function getUsers(Request $request){
        // get all users that received/sent message from/to [Auth user]
        $users = Message::join('users',  function ($join) {
            $join->on('messages.from_id', '=', 'users.id')
                ->orOn('messages.to_id', '=', 'users.id');
        })
        ->where(function ($q) {
            $q->where('messages.from_id', Auth::user()->id)
            ->orWhere('messages.to_id', Auth::user()->id);
        })
        ->where('users.id','!=',Auth::user()->id)
        ->select('users.*',DB::raw('MAX(messages.created_at) max_created_at'))
        ->orderBy('max_created_at', 'desc')
        ->groupBy('users.id')
        ->get();

        return response([
            'users' => $users->map(function($user){
                $user->last_message = $this->getLastMessageQuery($user->id);
                $user->unseen_messages = $this->countUnseenMessages($user->id);
                return $user->only(
                    ['id','firstname','lastname','phone','avatar','presence','last_message','unseen_messages'
                ]);
            })
        ]);
    }

    /**
     * Default fetch messages query between a Sender and Receiver.
     *
     * @param int $user_id
     * @return Message|\Illuminate\Database\Eloquent\Builder
     */
    public function fetchMessagesQuery($user_id)
    {
        return Message::where('from_id', Auth::user()->id)->where('to_id', $user_id)
                    ->orWhere('from_id', $user_id)->where('to_id', Auth::user()->id);
    }

    /**
     * Get last message for a specific user
     *
     * @param int $user_id
     * @return Message|Collection|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object|null
     */
    public function getLastMessageQuery($user_id)
    {
        return $this->fetchMessagesQuery($user_id)->latest()->first();
    }

    /**
     * Count Unseen messages
     *
     * @param int $user_id
     * @return Collection
     */
    public function countUnseenMessages($user_id)
    {
        return Message::where('from_id', $user_id)->where('to_id', Auth::user()->id)->where('seen', false)->count();
    }

    public function sendMessage(Request $request, PusherService $pusherService){
        // validate request
        $request->validate([
            'message' => 'required|string',
            'to_id' => 'required|integer'
        ]);

        // create new message
        $message = Message::create([
            'from_id' => Auth::user()->id,
            'to_id' => $request->to_id,
            'message' => $request->message,
            'advert_id' => $request->advert_id
        ]);

        // Notify user of new message
        $user = User::find($request->to_id);
        $user->notify(new NewMessageNotification(Auth::user()->id));

        $payload = [
            'message' => [
                'id' => $message->id,
                'message' => $message->message,
                'advert' => $message->advert()?->only(['id','title','price','images']),
                'seen' => $message->seen,
                'created_at' => $message->created_at,
                'from' => $message->from()->only(['id','firstname','lastname','avatar']),
                'to' => $message->to()->only(['id','firstname','lastname','avatar']),
            ]
        ];

        // broadcast new message
        $pusherService->trigger(env('PUSHER_CHAT_CHANNEL').".".$request->to_id, 'new-message', $payload);

        // return response
        return redirect()->back()->with('data', $payload);
    }

    // Get messages between two users
    public function getMessages(Request $request){
        // get messages between two users
        $messages = $this->fetchMessagesQuery($request->query('user_id'))->get();

        // return response
        return response([
            'messages' => $messages->map(function($message){
                $message->from = $message->from()->only(['id','firstname','lastname','avatar']);
                $message->to = $message->to()->only(['id','firstname','lastname','avatar']);
                $message->advert = $message->advert()?->only(['id','title','price','images']);
                return $message->only(['id','message','advert','seen','created_at','from','to']);
            })
        ]);
    }

    // Mark messages as seen
    public function markAsSeen(Request $request){
        $request->validate([
            'user_id' => 'required|integer'
        ]);
        // mark messages as seen
        $messages = Message::Where('from_id', $request->user_id)
                ->where('to_id', Auth::user()->id)
                ->where('seen', false);

        if($messages) $messages->update(['seen' => true]);

        // return response
        return response([
            'seen' => true
        ]);
    }

    // get Notifications
    public function getNotifications(){
        // get notifications
        $notifications = User::find(Auth::user()->id)->notifications;

        // return response
        return response([
            'notifications' => $notifications->map(function($notification){
                $notification->from = $notification->data['from_id'];
                $notification->from = User::find($notification->from)?->only(['id','firstname','lastname','avatar']);
                return $notification->only(['id','data','read_at','from']);
            })
        ]);
    }
}
