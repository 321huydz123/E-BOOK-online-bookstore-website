<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TacGia;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class TacGiaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tacGias = TacGia::all();
        return view(
            'admin.TacGia.index',
            [
                'data' => $tacGias
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
            'ten_tac_gia' => 'required',
            'trang_thai' => 'required',
        ]);
         // Kiểm tra trùng tên tác giả
         $exists = TacGia::where('ten_tac_gia', $request->ten_tac_gia)->exists();
         if ($exists) {
        return redirect()->back()->with('alert', [
        'type' => 'danger',
        'message' => 'Tác giả đã tồn tại !'
        ]);
         }
        TacGia::create($request->all());
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
        $TacGiaOld = TacGia::find($id);
        $TacGias = TacGia::all();
        return view('admin.TacGia.index', [
            'dataOld' => $TacGiaOld,
            'data' => $TacGias
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'ten_tac_gia' => 'required',
            'trang_thai' => 'required',
        ]);
        $TacGia = TacGia::find($id);
        $TacGia->update($request->all());
        return redirect()->route('tac-gia')->with('alert', [
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
            $tacGia = TacGia::findOrFail($id);
            $tacGia->delete();

            return redirect()->route('tac-gia')->with('alert', [
                'type' => 'success',
                'message' => 'Xóa tác giả thành công!'
            ]);
        } catch (ModelNotFoundException $e) {
            // Nếu không tìm thấy tác giả hoặc lỗi xóa
            return redirect()->route('tac-gia')->with('alert', [
                'type' => 'danger',
                'message' => 'Không tìm thấy tác giả hoặc xóa thất bại.'
            ]);
        } catch (\Exception $e) {
            // Nếu có lỗi khác
            return redirect()->route('tac-gia')->with('alert', [
                'type' => 'danger',
                'message' => 'Đã xảy ra lỗi, không thể xóa tác giả.'
            ]);
        }
    }
}
