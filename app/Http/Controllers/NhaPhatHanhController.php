<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NhaPhatHanh;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class NhaPhatHanhController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $nhaPhatHanhs = NhaPhatHanh::all();
        return view(
            'admin.NhaPhatHanh.index',
            [
                'data' => $nhaPhatHanhs
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
            'ten_nha_phat_hanh' => 'required',
            'trang_thai' => 'required',
        ]);
        // Kiểm tra trùng tên nhà phát hành
        $exists = NhaPhatHanh::whereRaw('LOWER(ten_nha_phat_hanh) = ?', [strtolower($request->ten_nha_phat_hanh)])->exists();
        if ($exists) {
        return redirect()->back()->with('alert', [
            'type' => 'danger', // dùng 'danger' để đúng với class Bootstrap
            'message' => 'Nhà phát hành đã tồn tại !'
        ]);
        }
        NhaPhatHanh::create($request->all());
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
        $NhaPhatHanhOld = NhaPhatHanh::find($id);
        $nhaPhatHanhs = NhaPhatHanh::all();
        return view('admin.NhaPhatHanh.index', [
            'dataOld' => $NhaPhatHanhOld,
            'data' => $nhaPhatHanhs
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'ten_nha_phat_hanh' => 'required',
            'trang_thai' => 'required',
        ]);
        $NhaPhatHanh = NhaPhatHanh::find($id);
        $NhaPhatHanh->update($request->all());
        return redirect()->route('nha-phat-hanh')->with('alert', [
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
            $NhaPhatHanh = NhaPhatHanh::findOrFail($id);
            $NhaPhatHanh->delete();

            return redirect()->route('nha-phat-hanh')->with('alert', [
                'type' => 'success',
                'message' => 'Xóa nhà phát hành thành công!'
            ]);
        } catch (ModelNotFoundException $e) {
            // Nếu không tìm thấy tác giả hoặc lỗi xóa
            return redirect()->route('nha-phat-hanh')->with('alert', [
                'type' => 'danger',
                'message' => 'Không tìm thấy nhà phát hành hoặc xóa thất bại.'
            ]);
        } catch (\Exception $e) {
            // Nếu có lỗi khác
            return redirect()->route('nha-phat-hanh')->with('alert', [
                'type' => 'danger',
                'message' => 'Đã xảy ra lỗi, không thể xóa nhà phát hành.'
            ]);
        }
    }
}
