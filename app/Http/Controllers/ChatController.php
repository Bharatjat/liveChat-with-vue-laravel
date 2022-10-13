<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

// models
use App\Models\Chat;

// events
use App\Events\sendMessage;

class ChatController extends Controller
{
    public function allChat(){
        return [
            'status' => 200,
            'data'  => Chat::with('user')->get()
        ];
    }

    public function messageStore(Request $request){
        $user = Auth::user();
        ini_set('max_execution_time', 400); 
        try {
            $data = $user->chat()->create([
                'message' => $request->message,
            ]);
            $status = 200;
            $message = 'update successfully';
            broadcast(new SendMessage($data))->toOthers();
        } catch (\Throwable $th) {
            $status = 401;
            $message = $th->getMessage();
            $data = null;
        }

        return [
            'status' => $status,
            'message' => $message,
            'data'  => $data,
            'broadCastData' => $broadCastData
        ];
    }

}
