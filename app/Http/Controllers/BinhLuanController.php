<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class BinhLuanController extends Controller
{
    
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
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
            'id_product' => 'required|integer', // ID sản phẩm mà bình luận đang đánh giá
        ]);

        // Lưu dữ liệu vào database
        DB::table('binh_luan')->insert([
            'danh_gia' => $validated['rating'],
            'noi_dung_binh_luan' => $validated['comment'],
            'id_san_pham' => $validated['id_product'], // Nếu cần gắn với sản phẩm đã tồn tại
            'id_user' => auth()->id(),
            'ngay_binh_luan' => now(),
        ]);

        return response()->json([
            'success' => true,
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
            'date' => now()->format('Y-m-d H:i:s'),
            'user_name' => auth()->user()->ten,
            'user_image' => auth()->user()->anh
                ? asset(auth()->user()->anh)
                : 'https://img.lovepik.com/free-png/20211130/lovepik-cartoon-avatar-png-image_401205251_wh1200.png',
        ]);
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