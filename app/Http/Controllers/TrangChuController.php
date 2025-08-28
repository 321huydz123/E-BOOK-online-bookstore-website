<?php

namespace App\Http\Controllers;

use App\Models\LoaiSanPham;
use App\Models\SanPham;
use Illuminate\Http\Request;
use App\Models\BinhLuan;

class TrangChuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $danhmucs = LoaiSanPham::all();
        $sanphammoi = SanPham::with('hinhAnh')->where('so_luong', '>', 0)
            ->where('trang_thai', 1)
            ->orderBy('id', 'asc') // Sắp xếp theo id tăng dần
            ->take(20) // Lấy 20 sản phẩm
            ->get();
        $sanphams = SanPham::with('hinhAnh')->where('so_luong', '>', 0)->where('trang_thai', 1)->get();


        foreach ($sanphams as $sanpham) {
            // Tổng số sao của tất cả đánh giá
            $totalRatings = BinhLuan::where('id_san_pham', $sanpham->id)->sum('danh_gia');

            // Số lượng bình luận
            $ratingsCount = BinhLuan::where('id_san_pham', $sanpham->id)->count();

            // Tính trung bình số sao
            $sanpham->averageRating = $ratingsCount > 0 ? round($totalRatings / $ratingsCount, 1) : 0;


            // Làm tròn đến 1 số thập phân
            // $sanpham->averageRating = round($averageRating, 1);
        }

        foreach ($sanphammoi as $sanpham) {
            $totalRatings = BinhLuan::where('id_san_pham', $sanpham->id)->sum('danh_gia');
            $ratingsCount = BinhLuan::where('id_san_pham', $sanpham->id)->count();
            $sanpham->averageRating = $ratingsCount > 0 ? round($totalRatings / $ratingsCount, 1) : 0;
        }


        return view('web.TrangChu', [
            'danhmucs' => $danhmucs,
            'sanphams' => $sanphams,
            'sanphammoi' => $sanphammoi,
        ]);
    }

    public function getAllProducts()
    {
        $danhmucs = LoaiSanPham::all();
        $sanphams = SanPham::with('hinhAnh')->where('trang_thai', 1)->where('so_luong', '>', 0)->paginate(12);
        $sanphammoi = SanPham::with('hinhAnh')->where('so_luong', '>', 0)
            ->where('trang_thai', 1)
            ->orderBy('id', 'asc') // Sắp xếp theo id tăng dần
            ->take(20) // Lấy 20 sản phẩm
            ->get();


        foreach ($sanphams as $sanpham) {
            // Tổng số sao của tất cả đánh giá
            $totalRatings = BinhLuan::where('id_san_pham', $sanpham->id)->sum('danh_gia');

            // Số lượng bình luận
            $ratingsCount = BinhLuan::where('id_san_pham', $sanpham->id)->count();

            // Tính trung bình số sao
            $sanpham->averageRating = $ratingsCount > 0 ? round($totalRatings / $ratingsCount, 1) : 0;


            // Làm tròn đến 1 số thập phân
            // $sanpham->averageRating = round($averageRating, 1);
        }

        foreach ($sanphammoi as $sanpham) {
            $totalRatings = BinhLuan::where('id_san_pham', $sanpham->id)->sum('danh_gia');
            $ratingsCount = BinhLuan::where('id_san_pham', $sanpham->id)->count();
            $sanpham->averageRating = $ratingsCount > 0 ? round($totalRatings / $ratingsCount, 1) : 0;
        }

        return view('web.SanPham.index', [
            'danhmucs' => $danhmucs,
            'sanphams' => $sanphams,
            'sanphammoi' => $sanphammoi,
        ]);
    }
    public function showByCategory($id)
    {
        // Lấy danh mục đang chọn
        $danhmucs = LoaiSanPham::all();
        $id_danhmuc = LoaiSanPham::findOrFail($id);
        // Lấy tất cả sản phẩm thuộc danh mục đó
        $sanphams = SanPham::with('hinhAnh')->where('trang_thai', 1)->where('so_luong', '>', 0)->where('id_loai_san_pham', $id)->paginate(12);
        $sanphammoi = SanPham::with('hinhAnh')->where('so_luong', '>', 0)
            ->where('trang_thai', 1)
            ->orderBy('id', 'asc') // Sắp xếp theo id tăng dần
            ->take(20) // Lấy 20 sản phẩm
            ->get();
        foreach ($sanphams as $sanpham) {
            // Tổng số sao của tất cả đánh giá
            $totalRatings = BinhLuan::where('id_san_pham', $sanpham->id)->sum('danh_gia');

            // Số lượng bình luận
            $ratingsCount = BinhLuan::where('id_san_pham', $sanpham->id)->count();

            // Tính trung bình số sao
            $sanpham->averageRating = $ratingsCount > 0 ? round($totalRatings / $ratingsCount, 1) : 0;


            // Làm tròn đến 1 số thập phân
            // $sanpham->averageRating = round($averageRating, 1);
        }

        foreach ($sanphammoi as $sanpham) {
            $totalRatings = BinhLuan::where('id_san_pham', $sanpham->id)->sum('danh_gia');
            $ratingsCount = BinhLuan::where('id_san_pham', $sanpham->id)->count();
            $sanpham->averageRating = $ratingsCount > 0 ? round($totalRatings / $ratingsCount, 1) : 0;
        }


        return view('web.SanPham.index', [
            'danhmucs' => $danhmucs,
            'sanphams' => $sanphams,
            'sanphammoi' => $sanphammoi,
            'danhmuc_selected' => $id_danhmuc,
        ]);
    }
    public function search($keyword)
    {
        $danhmucs = LoaiSanPham::all();
        $sanphammoi = SanPham::with('hinhAnh')
            ->where('trang_thai', 1)
            ->where('so_luong', '>', 0)
            ->orderBy('id', 'asc') // Sắp xếp theo id tăng dần
            ->take(20) // Lấy 20 sản phẩm
            ->get();
        // $keyword = $request->input('search');
        // Kiểm tra nếu có từ khóa tìm kiếm
        $keyword = trim($keyword);
        $keywords = explode(' ', $keyword);

        $sanphams = SanPham::with('hinhAnh')->where('trang_thai', 1)->where('so_luong', '>', 0)
            ->where(function ($query) use ($keywords) {
                foreach ($keywords as $word) {
                    $query->where('ten_san_pham', 'like', "%$word%");
                }
            })
            ->paginate(12);
        if ($sanphams->isEmpty()) {
            $sanphams = null;
        }
        // dd($keyword);
        foreach ($sanphams as $sanpham) {
            // Tổng số sao của tất cả đánh giá
            $totalRatings = BinhLuan::where('id_san_pham', $sanpham->id)->sum('danh_gia');

            // Số lượng bình luận
            $ratingsCount = BinhLuan::where('id_san_pham', $sanpham->id)->count();

            // Tính trung bình số sao
            $sanpham->averageRating = $ratingsCount > 0 ? round($totalRatings / $ratingsCount, 1) : 0;


            // Làm tròn đến 1 số thập phân
            // $sanpham->averageRating = round($averageRating, 1);
        }

        foreach ($sanphammoi as $sanpham) {
            $totalRatings = BinhLuan::where('id_san_pham', $sanpham->id)->sum('danh_gia');
            $ratingsCount = BinhLuan::where('id_san_pham', $sanpham->id)->count();
            $sanpham->averageRating = $ratingsCount > 0 ? round($totalRatings / $ratingsCount, 1) : 0;
        }

        return view('web.SanPham.index', [
            'danhmucs' => $danhmucs,
            'sanphams' => $sanphams,
            'sanphammoi' => $sanphammoi,
        ]);
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
