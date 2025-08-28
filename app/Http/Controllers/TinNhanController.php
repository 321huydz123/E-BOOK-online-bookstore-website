<?php

namespace App\Http\Controllers;

use App\Models\CuocTroChuyen;
use App\Models\TinNhan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\LoaiSanPham;

class TinNhanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $datalistuser = DB::table('users')->get();
        $currentUserId = Auth::id(); // Lấy ID người dùng đang đăng nhập

        $datalistuser = CuocTroChuyen::with([
            'messages' => function ($query) {
                $query->latest()->limit(1); // Lấy tin nhắn cuối cùng
            },
            'userOne' => function ($query) use ($currentUserId) {
                $query->where('id', '!=', $currentUserId); // Lọc user1_id khác user đang đăng nhập
            },
            'userTwo' => function ($query) use ($currentUserId) {
                $query->where('id', '!=', $currentUserId); // Lọc user2_id khác user đang đăng nhập
            }
        ])
            ->where(function ($query) use ($currentUserId) {
                $query->where('user1_id', $currentUserId)
                    ->orWhere('user2_id', $currentUserId); // Chỉ lấy các cuộc trò chuyện liên quan đến user đang đăng nhập
            })
            ->get();
        // dd($datalistuser);

        return view('admin.TroChuyen.index', [
            'datalistuser' => $datalistuser
        ]);
    }

    public function showChat(Request $request)
    {
        $name = $request->name;
        $id_cuoc_tro_chuyen = CuocTroChuyen::where('ten_cuoc_tro_chuyen', $name)->first();
        $user_id = Auth::id();
        $messages = TinNhan::where('cuoc_tro_chuyen_id', $id_cuoc_tro_chuyen->id)->get();
        if ($messages) {
            return response()->json([
                'getmessExists' => true,
                'messages' => $messages,
                //  'receiver'=>$users->full_name
            ]);
        } else {
            return response()->json([
                'getmessExists' => false,
            ]);
        }
    }


    /**
     * Show the form for creating a new resource.
     */
    // public function create($id)
    // {
    //     //
    // }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'ten_cuoc_tro_chuyen' => 'required|string',
            'nguoi_gui' => 'required|integer',
            'noi_dung' => 'required|string',
        ]);

        // Tìm cuộc trò chuyện dựa trên tên
        $conversation = CuocTroChuyen::where('ten_cuoc_tro_chuyen', $validatedData['ten_cuoc_tro_chuyen'])->first();

        if (!$conversation) {
            return response()->json(['success' => false, 'message' => 'Conversation not found.'], 404);
        }

        // Tạo tin nhắn mới
        $message = TinNhan::create([
            'cuoc_tro_chuyen_id' => $conversation->id,
            'nguoi_gui' => $validatedData['nguoi_gui'],
            'noi_dung' => $validatedData['noi_dung'],


        ]);

        return response()->json(['success' => true, 'message' => $message]);
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
    public function chat()
    {
        $danhmucs = LoaiSanPham::all();

        return view('web.LienHe.index', [
            'danhmucs' => $danhmucs
        ]);
    }
}
