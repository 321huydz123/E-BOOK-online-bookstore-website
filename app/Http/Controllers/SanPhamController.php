<?php

namespace App\Http\Controllers;

use App\Models\SanPham;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Models\LoaiSanPham;
use App\Models\BinhLuan;
use Illuminate\Validation\Rule;
class SanPhamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sanpham = SanPham::with('loaiSanPham', 'tacGia', 'nhaSanXuat', 'nhaPhatHanh', 'hinhAnh', 'hinhAnhs')->get();
        return view('admin.SanPham.index', [
            'data' => $sanpham
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $loaisanpham = DB::table('loai_san_pham')->where('trang_thai', 1)->get();
        $tacgia = DB::table('tac_gia')->where('trang_thai', 1)->get();
        $nhasanxuat = DB::table('nha_san_xuat')->where('trang_thai', 1)->get();
        $nhaphathanh = DB::table('nha_phat_hanh')->where('trang_thai', 1)->get();
        return view('admin.SanPham.create', [
            'loaiSanPham' => $loaisanpham,
            'tacGia' => $tacgia,
            'nhaSanXuat' => $nhasanxuat,
            'nhaPhatHanh' => $nhaphathanh
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->file('hinhanh.*')); // Kiểm tra dữ liệu
        // die('123');
        // Validate dữ liệu từ form
        $validatedData = $request->validate([
            'ten_san_pham' => [
    'required',
    'string',
    'max:255',
    Rule::unique('san_pham', 'ten_san_pham'),
],
            'id_loai_san_pham' => 'required|integer',
            'mo_ta' => 'required|string',
            'hinhanh' => 'required',
            'hinhanh.*' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'so_luong' => 'required|integer|min:1',
            'gia_ban' => 'required|integer|min:0',
            'gia_goc' => 'required|integer|min:0',
            // 'so_luong' => 'required|integer|min:1',
            'so_trang' => 'required|integer|min:1',
            'kich_thuoc' => 'required|string|max:255',
            // 'so_luong' => 'required|integer|min:1',
            'trong_luong' => 'required|integer|min:0',
            'ngay_nhap' => 'required|date',
            'nam_xb' => 'required|date|before:ngay_nhap',
            'id_nha_san_xuat' => 'required|integer',
            'id_nha_phat_hanh' => 'required|integer',
            'id_tac_gia' => 'required|integer',
            'trang_thai' => 'required',
        ]);

        // Kiểm tra tên sản phẩm đã tồn tại (thủ công)
    $existingProduct = DB::table('san_pham')
    ->where('ten_san_pham', $request->input('ten_san_pham'))
    ->first();

    if ($existingProduct) {
        return redirect()->route('san-pham.create')->with('alert', [
            'type' => 'danger',
            'message' => 'Thêm sản phẩm thất bại! Tên sản phẩm đã tồn tại.',
        ]);
    }
        if (!$request->hasFile('hinhanh')) {
            return redirect()->back()->with('alert', [
                'type' => 'error',
                'message' => 'Vui lòng tải lên ít nhất một hình ảnh.',
            ]);
        }
        // dd($validatedData);
        // Tạo mới sản phẩm
        $insertSaleNews = DB::table('san_pham')->insertGetId([
            'ten_san_pham' => $validatedData['ten_san_pham'],
            'id_loai_san_pham' => $validatedData['id_loai_san_pham'],
            'mo_ta' => $validatedData['mo_ta'],
            'gia_ban' => $validatedData['gia_ban'],
            'gia_goc' => $validatedData['gia_goc'],
            'so_luong' => $validatedData['so_luong'],
            'so_trang' => $validatedData['so_trang'],
            'kich_thuoc' => $validatedData['kich_thuoc'],
            'trong_luong' => $validatedData['trong_luong'],
            'ngay_nhap' => $validatedData['ngay_nhap'],
            'nam_xb' => $validatedData['nam_xb'],
            'id_nha_san_xuat' => $validatedData['id_nha_san_xuat'],
            'id_nha_phat_hanh' => $validatedData['id_nha_phat_hanh'],
            'id_tac_gia' => $validatedData['id_tac_gia'],
            'trang_thai' => $validatedData['trang_thai'],

        ]);


        $imageRecords = [];
        foreach ($request->file('hinhanh') as $image) {
            $imageName = 'anh_san_pham_' . time() . '_' . uniqid() . '.' . $image->extension();
            $imagePath = 'storage/Hinh_Anh_San_Pham/' . $imageName;
            Storage::disk('public')->putFileAs('Hinh_Anh_San_Pham', $image, $imageName);
            $imageRecords[] = [
                'id_san_pham' => $insertSaleNews,
                'hinh_anh' => $imagePath,
            ];
        }
        if (!empty($imageRecords)) {
            DB::table('anh_san_pham')->insert($imageRecords);
        }

        // Chuyển hướng về trang thêm sản phẩm với thông báo thành công
        return redirect()->route('san-pham.create')->with('alert', [
            'type' => 'success',
            'message' => 'Thêm sản phẩm thành công!',
        ]);
    }



    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Lấy tất cả bình luận cho sản phẩm với id $id
        $datacmt = BinhLuan::with('user')->where('id_san_pham', $id)->get();

        // Tổng số điểm đánh giá
        $sum = BinhLuan::where('id_san_pham', $id)->sum('danh_gia');

        // Tổng số đánh giá
        $count = BinhLuan::where('id_san_pham', $id)->count();

        // Mảng lưu số lượng đánh giá cho từng sao (1 sao đến 5 sao)
        $starCounts = [
            5 => BinhLuan::where('id_san_pham', $id)->where('danh_gia', 5)->count(),
            4 => BinhLuan::where('id_san_pham', $id)->where('danh_gia', 4)->count(),
            3 => BinhLuan::where('id_san_pham', $id)->where('danh_gia', 3)->count(),
            2 => BinhLuan::where('id_san_pham', $id)->where('danh_gia', 2)->count(),
            1 => BinhLuan::where('id_san_pham', $id)->where('danh_gia', 1)->count(),
        ];

        // Tính điểm trung bình
        $avg = $count > 0 ? $sum / $count : 0;

        // Tính tỷ lệ phần trăm của điểm trung bình (từ 0 đến 100%)
        $avgPercentage = $avg * 20; // Vì điểm trung bình từ 1 đến 5, nhân với 20 để ra tỷ lệ phần trăm

        // Lấy danh mục sản phẩm
        $danhmucs = LoaiSanPham::all();

        // Lấy thông tin sản phẩm
        $sanpham = SanPham::with('loaiSanPham', 'tacGia', 'nhaSanXuat', 'nhaPhatHanh', 'hinhAnh', 'hinhAnhs')->find($id);

        // Trả về view với dữ liệu
        return view('web.SanPham.productdetail', [
            'danhmucs' => $danhmucs,
            'data' => $sanpham,
            'avg' => number_format($avg, 1), // Định dạng điểm trung bình với 1 chữ số thập phân
            'avgPercentage' => $avgPercentage,
            'sum' => $sum,
            'count' => $count,
            'starCounts' => $starCounts, // Truyền số lượng đánh giá sao
            'datacmt' => $datacmt,
        ]);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $sanpham = SanPham::with('loaiSanPham', 'tacGia', 'nhaSanXuat', 'nhaPhatHanh', 'hinhAnh', 'hinhAnhs')->find($id);
        $loaisanpham = DB::table('loai_san_pham')->where('trang_thai', 1)->get();
        $tacgia = DB::table('tac_gia')->where('trang_thai', 1)->get();
        $nhasanxuat = DB::table('nha_san_xuat')->where('trang_thai', 1)->get();
        $nhaphathanh = DB::table('nha_phat_hanh')->where('trang_thai', 1)->get();
        // dd($sanpham);
        return view('admin.SanPham.edit', [
            'data' => $sanpham,
            'loaiSanPham' => $loaisanpham,
            'tacGia' => $tacgia,
            'nhaSanXuat' => $nhasanxuat,
            'nhaPhatHanh' => $nhaphathanh
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Tìm sản phẩm theo ID
        $product = DB::table('san_pham')->where('id', $id)->first();
        if (!$product) {
            return redirect()->back()->with('alert', [
                'type' => 'error',
                'message' => 'Sản phẩm không tồn tại!',
            ]);
        }

        // Validate dữ liệu từ form
        $validatedData = $request->validate([
            'ten_san_pham' => 'required|string|max:255',
            'id_loai_san_pham' => 'required|integer',
            'mo_ta' => 'required|string',
            'hinhanh' => 'required',
            'hinhanh.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'so_luong' => 'required|integer|min:1',
            'gia_ban' => 'required|integer|min:0',
            'gia_goc' => 'required|integer|min:0',
            'so_trang' => 'required|integer|min:1',
            'kich_thuoc' => 'required|string|max:255',
            'trong_luong' => 'required|integer|min:0',
            'ngay_nhap' => 'required|date',
            'nam_xb' => 'required|date|before:ngay_nhap',
            'id_nha_san_xuat' => 'required|integer',
            'id_nha_phat_hanh' => 'required|integer',
            'id_tac_gia' => 'required|integer',
            'trang_thai' => 'required',
        ]);

        // Cập nhật thông tin sản phẩm
        DB::table('san_pham')->where('id', $id)->update([
            'ten_san_pham' => $validatedData['ten_san_pham'],
            'id_loai_san_pham' => $validatedData['id_loai_san_pham'],
            'mo_ta' => $validatedData['mo_ta'],
            'gia_ban' => $validatedData['gia_ban'],
            'gia_goc' => $validatedData['gia_goc'],
            'so_luong' => $validatedData['so_luong'],
            'so_trang' => $validatedData['so_trang'],
            'kich_thuoc' => $validatedData['kich_thuoc'],
            'trong_luong' => $validatedData['trong_luong'],
            'ngay_nhap' => $validatedData['ngay_nhap'],
            'nam_xb' => $validatedData['nam_xb'],
            'id_nha_san_xuat' => $validatedData['id_nha_san_xuat'],
            'id_nha_phat_hanh' => $validatedData['id_nha_phat_hanh'],
            'id_tac_gia' => $validatedData['id_tac_gia'],
            'trang_thai' => $validatedData['trang_thai'],
        ]);

        // Xử lý cập nhật hình ảnh
        if ($request->hasFile('hinhanh')) {
            // Xóa hình ảnh cũ
            $oldImages = DB::table('anh_san_pham')->where('id_san_pham', $id)->get();
            foreach ($oldImages as $oldImage) {
                if (Storage::disk('public')->exists(str_replace('storage/', '', $oldImage->hinh_anh))) {
                    Storage::disk('public')->delete(str_replace('storage/', '', $oldImage->hinh_anh));
                }
            }
            DB::table('anh_san_pham')->where('id_san_pham', $id)->delete();

            // Thêm hình ảnh mới
            $imageRecords = [];
            foreach ($request->file('hinhanh') as $image) {
                $imageName = 'anh_san_pham_' . time() . '_' . uniqid() . '.' . $image->extension();
                $imagePath = 'storage/Hinh_Anh_San_Pham/' . $imageName;
                Storage::disk('public')->putFileAs('Hinh_Anh_San_Pham', $image, $imageName);
                $imageRecords[] = [
                    'id_san_pham' => $id,
                    'hinh_anh' => $imagePath,
                ];
            }
            DB::table('anh_san_pham')->insert($imageRecords);
        }

        // Chuyển hướng với thông báo thành công
        return redirect()->route('san-pham', $id)->with('alert', [
            'type' => 'success',
            'message' => 'Cập nhật sản phẩm thành công!',
        ]);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Tìm sản phẩm theo ID
        $product = DB::table('san_pham')->where('id', $id)->first();
        if (!$product) {
            return redirect()->back()->with('alert', [
                'type' => 'error',
                'message' => 'Sản phẩm không tồn tại!',
            ]);
        }

        // Lấy danh sách hình ảnh liên quan đến sản phẩm
        $images = DB::table('anh_san_pham')->where('id_san_pham', $id)->get();

        // Xóa các hình ảnh khỏi thư mục lưu trữ
        foreach ($images as $image) {
            $imagePath = str_replace('storage/', '', $image->hinh_anh);
            if (Storage::disk('public')->exists($imagePath)) {
                Storage::disk('public')->delete($imagePath);
            }
        }

        // Xóa các hình ảnh khỏi cơ sở dữ liệu
        DB::table('anh_san_pham')->where('id_san_pham', $id)->delete();

        // Xóa sản phẩm khỏi cơ sở dữ liệu
        DB::table('san_pham')->where('id', $id)->delete();

        // Chuyển hướng với thông báo thành công
        return redirect()->route('san-pham')->with('alert', [
            'type' => 'success',
            'message' => 'Xóa sản phẩm thành công!',
        ]);
    }
}