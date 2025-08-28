<?php

namespace App\Http\Controllers;

use App\Models\DonHang;
use Illuminate\Http\Request;
use App\Models\LoaiSanPham;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Models\User;



class TaiKhoanController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $danhmucs = LoaiSanPham::all();
        $donHang = DonHang::with('chiTietSanPham')
            ->where('id_user', $user->id)
            ->whereBetween('trang_thai_don_hang', [1, 5]) // Trạng thái từ 1 đến 5
            ->whereNotIn('trang_thai_don_hang', [4])     // Loại trừ trạng thái 4
            ->get();
        $lichsumuahang = DonHang::with('chiTietSanPham')
            ->where('id_user', $user->id)
            ->where('trang_thai_don_hang', 4)
            ->get();
        $diachi = DB::table('dia_chi')->where('id_user', $user->id)->get();
        // dd($donHang);

        return view(
            'web.TaiKhoan.index',
            [
                'user' => $request->user(),
                'danhmucs' => $danhmucs,
                'donhang' => $donHang,
                'lichsumuahang' => $lichsumuahang,
                'diachi' => $diachi,
            ]
        );
    }


    public function update(Request $request)
    {
        $user = Auth::user();

        // Kiểm tra và validate các trường dữ liệu
        $validatedData = $request->validate([
            'ten' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'sdt' => 'nullable|numeric',
            'anh' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validate hình ảnh
        ]);


        $data = [
            'ten' => $request->input('ten'),
            'email' => $request->input('email'),
            'sdt' => $request->input('sdt'),
        ];


        if ($request->hasFile('anh')) {
            if ($user->anh) {
                Storage::delete($user->anh);
            }
            $image = $request->file('anh');
            $imageName = 'anh_san_pham_' . time() . '_' . uniqid() . '.' . $image->extension();
            $imagePath = 'storage/Hinh_Dai_Dien/' . $imageName;
            Storage::disk('public')->putFileAs('Hinh_Dai_Dien', $image, $imageName);
            $data['anh'] = $imagePath;
        }

        // Cập nhật thông tin người dùng
        DB::table('users')->where('id', $user->id)->update($data);

        // Quay về trang profile với thông báo cập nhật thành công
        return redirect()->back()->with('alert', [
            'type' => 'success',
            'message' => 'Thông tin được thay đổi !',
        ]);
    }
    public function getAllUser()
    {
        // Sử dụng where và kết thúc bằng get()
        $users = User::where('quyen', '!=', 2)->withCount('donHang')->get();

        // Truyền danh sách users đến view
        return view('admin.TaiKhoan.index', ['users' => $users]);
    }

    public function updateStatus(Request $request)
    {
        // Validate dữ liệu
        $validatedData = $request->validate([
            'id' => 'required|integer|exists:users,id',
            'status' => 'required|integer|in:0,1', // Chỉ chấp nhận 0 hoặc 1
        ]);

        // Lấy dữ liệu sau khi validate
        $id = $validatedData['id'];
        $status = $validatedData['status'];

        // Tìm và cập nhật trạng thái
        $item = User::find($id);
        if ($item) {
            $item->trang_thai = $status;
            $item->save();

            return response()->json(['success' => true, 'message' => 'Cập nhật trạng thái thành công']);
            // return redirect()->route('tai-khoan.update')  // Chỉnh sửa tên route phù hợp
            //     ->with('alert', [
            //         'type' => 'success',
            //         'message' => 'Cập nhật trạng thái thành công!'
            //     ]);
        }

        return response()->json(['success' => false, 'message' => 'Không tìm thấy đối tượng']);
        // return redirect()->route('tai-khoan.update')  // Chỉnh sửa tên route phù hợp
        //     ->with('alert', [
        //         'type' => 'danger',
        //         'message' => 'Không tìm thấy đối tượng'
        //     ]);
    }
    // public function Order()
    // {
    //     $user = Auth::user();
    //     $donHang = DB::table('don_hangs')->where('user_id', $user->id)->orderBy('id', 'desc')->get();

    //     return view('web.TaiKhoan.order', ['donHang' => $donHang]);
    // }
}
