<?php

namespace App\Http\Controllers;

use App\Models\CuocTroChuyen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CuocTroChuyenController extends Controller
{



    public function loadConversations()
    {


        $user_id =
            Auth::id();



        $conversations = DB::table('cuoc_tro_chuyen')
            ->where('user1_id', $user_id)
            ->orWhere('user2_id', $user_id)
            ->get();

        $userIds = $conversations->map(function ($conversation) use ($user_id) {
            return $conversation->user1_id == $user_id ? $conversation->user2_id : $conversation->user1_id;
        })->unique();

        $users = DB::table('users')->whereIn('id', $userIds)->get();

        $data = $conversations->map(function ($conversation) use ($users, $user_id) {
            return [
                'conversation' => $conversation,
                'user' => $users->firstWhere('user_id', $conversation->user1_id == $user_id ? $conversation->user2_id : $conversation->user1_id)
            ];
        });

        return view('message.message', ['data' => $data]);
    }

    public function CheckConversation(Request $request)
    {
        $recipientId = $request->recipientId;
        $loggedInUserId
            = Auth::id();

        // $Conversation = CuocTroChuyen::where(function ($query) use ($recipientId, $loggedInUserId) {
        //     $query->where('user1_id', $loggedInUserId)
        //         ->where('user2_id', $recipientId);
        // })->orWhere(function ($query) use ($recipientId, $loggedInUserId) {
        //     $query->where('user1_id', $recipientId)
        //         ->where('user2_id', $loggedInUserId);
        // })->first();
        $Conversation = CuocTroChuyen::where('id', $recipientId)->first();

        if ($Conversation) {
            return response()->json([
                'channelExists' => true,
                'channelName' => $Conversation->ten_cuoc_tro_chuyen,
            ]);
        } else {
            return response()->json([
                'channelExists' => false,
            ]);
        }
    }
    public function CheckConversationUser(Request $request)
    {
        $recipientId = $request->recipientId;
        $loggedInUserId
            = Auth::id();

        $Conversation = CuocTroChuyen::where(function ($query) use ($recipientId, $loggedInUserId) {
            $query->where('user1_id', $loggedInUserId)
                ->where('user2_id', $recipientId);
        })->orWhere(function ($query) use ($recipientId, $loggedInUserId) {
            $query->where('user1_id', $recipientId)
                ->where('user2_id', $loggedInUserId);
        })->first();
        // $Conversation = CuocTroChuyen::where('id', $recipientId)->first();

        if ($Conversation) {
            return response()->json([
                'channelExists' => true,
                'channelName' => $Conversation->ten_cuoc_tro_chuyen,
            ]);
        } else {
            return response()->json([
                'channelExists' => false,
            ]);
        }
    }



    public function CreateConversation(Request $request)
    {
        $recipientId = $request->recipientId;
        $loggedInUserId =  Auth::id();
        try {
            // Generate the channel name
            $channelName = min($recipientId, $loggedInUserId) . '-' . max($recipientId, $loggedInUserId);


            // Create the channel in the database
            $channel = CuocTroChuyen::create([
                'user1_id' => $loggedInUserId,
                'user2_id' => $recipientId,
                'ten_cuoc_tro_chuyen' => $channelName,
            ]);


            return response()->json([
                'success' => true,
                'channelName' => $channelName,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
            ]);
        }
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
