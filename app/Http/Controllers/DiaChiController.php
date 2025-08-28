<?php

namespace App\Http\Controllers;

use App\Models\DiaChi;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DiaChiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {
        $user = Auth::user();

        // Cập nhật tất cả các địa chỉ của người dùng có trạng thái thành 2
        DB::table('dia_chi')
            ->where('id_user', $user->id)
            ->update(['trang_thai' => 2]);

        // Cập nhật một địa chỉ cụ thể với $id và trạng thái thành 1
        $themDiaChi = DB::table('dia_chi')->where('id', $id)->update([
            'trang_thai' => 1
        ]);

        // Kiểm tra kết quả
        if ($themDiaChi) {
            return redirect()->back()->with('alert', [
                'type' => 'success',
                'message' => 'Cập nhật trạng thái địa chỉ thành công!'
            ]);
        } else {
            return redirect()->back()->with('alert', [
                'type' => 'danger',
                'message' => 'Cập nhật thất bại, vui lòng thử lại!'
            ]);
        }
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
        $user = Auth::user();
        // Thêm địa chỉ vào bảng dia_chi
        $themDiaChi = DB::table('dia_chi')->insert([
            'id_user' => $user->id,
            'dia_chi' => $request->dia_chi,
            'trang_thai' => 2

        ]);

        // Kiểm tra thêm thành công hay không
        if ($themDiaChi) {
            return redirect()->back()->with('alert', [
                'type' => 'success',
                'message' => 'Thêm địa chỉ thành công!'
            ]);
        } else {
            return redirect()->back()->with('alert', [
                'type' => 'danger',
                'message' => 'Thêm địa chỉ thất bại, vui lòng thử lại!'
            ]);
        }
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
}
