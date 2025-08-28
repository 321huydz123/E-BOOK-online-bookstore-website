<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NhaSanXuat;
use Illuminate\Database\Eloquent\ModelNotFoundException;
class NhaSanXuatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $nhaSanXuats = NhaSanXuat::all();
        return view(
            'admin.NhaSanXuat.index',
            [
                'data' => $nhaSanXuats
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'ten_nha_san_xuat' => 'required',
            'trang_thai' => 'required',
        ]);
        // Kiểm tra trùng tên nhà sản xuất
        $exists = NhaSanXuat::whereRaw('LOWER(ten_nha_san_xuat) = ?', [strtolower($request->ten_nha_san_xuat)])->exists();
        if ($exists) {
        return redirect()->back()->with('alert', [
            'type' => 'danger', // dùng 'danger' cho thông báo lỗi (Bootstrap)
            'message' => 'Nhà sản xuất đã tồn tại !'
        ]);
        }
        NhaSanXuat::create($request->all());
        return redirect()->back()->with('alert', [
            'type' => 'success',
            'message' => 'Thành Công !'
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
        $NhaSanXuatOld = NhaSanXuat::find($id);
        $nhaSanXuats = NhaSanXuat::all();
        return view('admin.NhaSanXuat.index', [
            'dataOld' => $NhaSanXuatOld,
            'data' => $nhaSanXuats
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'ten_nha_san_xuat' => 'required',
            'trang_thai' => 'required',
        ]);
        $NhaSanXuat = NhaSanXuat::find($id);
        $NhaSanXuat->update($request->all());
        return redirect()->route('nha-san-xuat')->with('alert', [
            'type' => 'success',
            'message' => 'Thành Công!'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            // Thực hiện xóa tác giả
            $NhaSanXuat = NhaSanXuat::findOrFail($id);
            $NhaSanXuat->delete();

            return redirect()->route('nha-san-xuat')->with('alert', [
                'type' => 'success',
                'message' => 'Xóa nhà sản xuất thành công!'
            ]);
        } catch (ModelNotFoundException $e) {
            // Nếu không tìm thấy tác giả hoặc lỗi xóa
            return redirect()->route('nha-san-xuat')->with('alert', [
                'type' => 'danger',
                'message' => 'Không tìm thấy nhà sản xuất hoặc xóa thất bại.'
            ]);
        } catch (\Exception $e) {
            // Nếu có lỗi khác
            return redirect()->route('nha-san-xuat')->with('alert', [
                'type' => 'danger',
                'message' => 'Đã xảy ra lỗi, không thể xóa nhà sản xuất.'
            ]);
        }
    }
}
