<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\Message;
use App\Models\Product;
use App\Models\Seller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $userType = 'user';
        $user = auth()->user();
        if(strpos(request()->getPathInfo(), 'seller') !== false){
            $userType = 'seller';
            $user = seller();
        }
        if($user == null){
            return redirect('/');
        }

        // if isset product
        if($request->get('p')) {
            $product = Product::where("id", $request->get('p'))->firstOrFail();
            if($product and $userType == 'user'){
                $productSeller = $product->seller;
                if($productSeller->email == $user->email){
                    abort(404);
                }

                // check if seller and user have chat;
                $hasChat = $this->haveChat($user->email, $productSeller->email);
                // dd($hasChat);
                if(!$hasChat){
                    $hasChat = Chat::create([
                        'user_1' => $user->email,
                        'user_2' => $productSeller  ->email,
                        'user_1_type' => $userType,
                        'user_2_type' => 'seller',
                        'hash' => \Illuminate\Support\Str::random(20)
                    ]);
                }

                return redirect("/".$userType."/live-chat/".$hasChat->hash);
            }
        }

        if($request->get('chat-with')){
            $chatWith = $request->get('chat-with');
            $isChatWithValidUser = Seller::where('email', $chatWith)->first();
            $chatWithType = 'seller';
            if(!$isChatWithValidUser){
                $chatWithType = 'user';
                $isChatWithValidUser = User::where('email', $chatWith)->first();
                if(!$isChatWithValidUser) abort(404);
            }

            $hasChat = $this->havaChat($chatWith, $user->email);
            if(!$hasChat){
                $hasChat = Chat::create([
                    'user_1' => $user->email,
                    'user_2' => $chatWith,
                    'user_1_type' => $userType,
                    'user_2_type' => $chatWithType
                ]);
            }

            return redirect("/".$userType."/live-chat/".$hasChat->hash);
        }
      

        // all chats
        return view("chat.ui", [
            "user" => $user, "user_type" => $userType, "now" => Carbon::now(1)
        ]);
    }
    public function Chat($hash){
        $userType = 'user';
        $user = auth()->user();
        if(strpos(request()->getPathInfo(), 'seller') !== false){
            $userType = 'seller';
            $user = seller();
        }
        if($user == null){
            return redirect('/');
        }

         // get chats
         $chat = Chat::where("hash", $hash)->first();
         return view("chat.ui", [
            "user" => $user, "user_type" => $userType, "current" => $chat, "now" => Carbon::now(1)
        ]);
    }
    public function getChat($current){
        $userType = 'user';
        $user = auth()->user();
        if(strpos(request()->getPathInfo(), 'seller') !== false){
            $userType = 'seller';
            $user = seller();
        }

        $chat_ = Chat::where('hash', $current)->select('id')->first();
        // update all unread
        Message::where('chat_id', $chat_->id)->where("user", '!=', $user->email)->where('status', Message::$unread)->update(["status" => Message::$read]);

        $chat = Chat::with(['Messages' => function($query){
            $query->orderBy('id', 'ASC');
        }])->where('hash', $current)->first();
        $user_1 = $chat->user_1_type == 'user' ? User::where("email", $chat->user_1)->first() : Seller::where('email', $chat->user_1)->first();
        $user_2 = $chat->user_2_type == 'user' ? User::where("email", $chat->user_2)->first() : Seller::where('email', $chat->user_2)->first();
        $user_1->store_ = $user_1->Store();
        $user_2->store_ = $user_2->Store();
        $chat->user1 = $user_1;
        $chat->user2 = $user_2;


        return response()->json($chat);
    }
    public function haveChat($user, $seller){
        $hasChat = Chat::where('user_1', $user)->where('user_2', $seller)->first();
        if($hasChat){
            return $hasChat;
        }

        $hasChat = Chat::where('user_1', $seller)->where('user_2', $user)->first();
        if($hasChat)return $hasChat;

        return null;
    }
    public function loadChats(){
        $userType = 'user';
        $user = auth()->user();
        if(strpos(request()->getPathInfo(), 'seller') !== false){
            $userType = 'seller';
            $user = seller();
        }
        $chats = Chat::with(['Messages' => function($query){
            $query->orderBy('id', 'ASC');
        }, 'Unread' => function($query) use($user){
            $query->where("user", '!=', $user->email)->where('status', Message::$unread)->get();
        }])->where("user_1", $user->email)->orWhere("user_2", $user->email)->get();
        foreach ($chats as $chat) {
            $user_1 = $chat->user_1_type == 'user' ? User::where("email", $chat->user_1)->first() : Seller::where('email', $chat->user_1)->first();
            $user_2 = $chat->user_2_type == 'user' ? User::where("email", $chat->user_2)->first() : Seller::where('email', $chat->user_2)->first();
            $user_1->store_ = $user_1->Store();
            $user_2->store_ = $user_2->Store();
            $chat->user1 = $user_1;
            $chat->user2 = $user_2;
        }
        return response()->json([
            'status' => true,
            'chats' => $chats,
        ]);
    }
    public function sendMsg(Request $request, $current){
        $userType = 'user';
        $this->validate($request, ["msg" => 'required']);
        $user = auth()->user();
        if(strpos(request()->getPathInfo(), 'seller') !== false){
            $userType = 'seller';
            $user = seller();
        }
        $chat = Chat::where("user_1", $user->email)->orWhere("user_2", $user->email)->where('hash', $current)->first();
        if(!$chat){
            return response()->json("failed", 404);
        }

        Message::create([
            "chat_id" => $chat->id,
            "user" => $user->email,
            "message" => $request->msg,
            "created_at" => Carbon::now("1")->timezone(1),
        ]);

        return response('success', 200);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
