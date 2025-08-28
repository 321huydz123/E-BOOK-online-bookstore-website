<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\LoaiSanPham;

class LoaiSanPhamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $loaiSanPhams = LoaiSanPham::withCount('sanPham')->get();
        return view('admin.LoaiSach.index', ['data' => $loaiSanPhams]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $loaiSanPhams = LoaiSanPham::withCount('sanPham')->get();
        return view('admin.LoaiSach.index', ['data' => $loaiSanPhams]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'ten_loai_san_pham' => 'required',
            'trang_thai' => 'required',
        ]);
         // Kiểm tra trùng tên loại sản phẩm
            $exists = LoaiSanPham::where('ten_loai_san_pham', $request->ten_loai_san_pham)->exists();
             if ($exists) {
        return redirect()->back()->with('alert', [
            'type' => 'danger',
            'message' => 'Loại sản phẩm đã tồn tại !'
        ]);
             }
        LoaiSanPham::create($request->all());
        return redirect()->back()->with('alert', [
            'type' => 'success',
            'message' => 'Thành Công !'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id) {}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $loaiSanPhamOld = LoaiSanPham::withCount('sanPham')->find($id);
        $loaiSanPhams = LoaiSanPham::withCount('sanPham')->get();
        return view('admin.LoaiSach.index', [
            'dataOld' => $loaiSanPhamOld,
            'data' => $loaiSanPhams
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'ten_loai_san_pham' => 'required',
            'trang_thai' => 'required',
        ]);
        $loaiSanPham = LoaiSanPham::find($id);
        $loaiSanPham->update($request->all());
        return redirect()->route('loai-san-pham')->with('alert', [
            'type' => 'success',
            'message' => 'Thành Công!'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        LoaiSanPham::destroy($id);
        return redirect()->route('loai-san-pham')->with('alert', [
            'type' => 'success',
            'message' => 'Thành Công!'
        ]);
    }
}
