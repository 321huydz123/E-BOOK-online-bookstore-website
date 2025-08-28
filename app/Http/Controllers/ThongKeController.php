<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DonHang;
use Carbon\Carbon;
use App\Models\SanPham;
use Illuminate\Support\Facades\DB;

class ThongKeController extends Controller
{
    public function index()
    {

        // return view('admin.thongke.index');
        // Lọc sản phẩm có so_luong > 0 và trang_thai = 1
        $products = SanPham::where('trang_thai', 1)->where('so_luong', '>', 0);

        // Tổng giá trị sản phẩm (so_luong * gia_ban)
        $totalValue = $products->sum(DB::raw('so_luong * gia_ban'));

        // Tổng số lượng sản phẩm
        $totalProducts = $products->count();

        // Số lượng sản phẩm mới (nhập trong 30 ngày qua)
        $newProducts = $products->where('ngay_nhap', '>=', Carbon::now()->subDays(30))->count();

        // Sản phẩm còn lại (tổng sản phẩm - sản phẩm mới)
        $remainingProducts = $totalProducts - $newProducts;
        $completedOrders = DonHang::where('trang_thai_don_hang', 4)->count();
        $totalOrderValue = DonHang::where('trang_thai_don_hang', 4)->sum('tong_tien');

        // sản phẩm bán chạy
        $bestSellingProducts = DB::table('san_pham as sp')
            ->join('chi_tiet_don_hang as ctdh', 'sp.id', '=', 'ctdh.id_san_pham')
            ->join('don_hang as dh', 'ctdh.id_don_hang', '=', 'dh.id')
            ->where('dh.trang_thai_don_hang', 4) // Đơn hàng hoàn thành
            ->select(
                'sp.id',
                'sp.ten_san_pham',
                'sp.gia_ban',
                DB::raw('SUM(ctdh.so_luong) as so_don'),
                DB::raw('SUM(ctdh.so_luong * (ctdh.gia * 0.2)) as loi_nhuan')
            )
            ->groupBy('sp.id', 'sp.ten_san_pham', 'sp.gia_ban')
            ->orderByDesc('so_don')
            ->limit(10)
            ->get();

        $tongLoiNhuan = $totalOrderValue * 0.2;
            
        return view('admin.thongke.index', compact('totalValue', 'totalProducts', 'newProducts', 'remainingProducts', 'completedOrders', 'totalOrderValue', 'bestSellingProducts','tongLoiNhuan'));
    }

    public function getChartData()
    {
        $data = DonHang::where('trang_thai_don_hang', 4) // Lọc đơn hàng có trạng thái 4
            ->selectRaw('DATE(thoi_gian) as date, SUM(tong_tien) as total_earnings')
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();
        // dd($data);
        $dates = $data->pluck('date')->map(function ($date) {
            return Carbon::parse($date)->format('d/m');
        });

        // Lấy danh sách thu nhập và chi phí
        $earnings = $data->pluck('total_earnings');
        $expenses = array_map(fn($e) => $e * 0.8, $earnings->toArray());



        // Định dạng đúng JSON để khớp với JavaScript
        return response()->json([
            'series' => [
                ['name' => 'Thu nhập tháng này (VND)', 'data' => $earnings->toArray()],
                ['name' => 'Chi phí tháng này (VND)', 'data' => $expenses],
            ],
            'categories' => $dates,
        ]);
    }
    public function getChartDataAuto(Request $request)
    {
        $filter = $request->input('filter', 1); // Mặc định là 1 tháng
        $query = DonHang::where('trang_thai_don_hang', 4);

        switch ($filter) {
            case 1: // 1 Tháng
                $query->where('thoi_gian', '>=', Carbon::now()->subMonth());
                break;
            case 2: // 1 Tuần
                $query->where('thoi_gian', '>=', Carbon::now()->subWeek());
                break;
            case 3: // 1 Tuần trước
                $query->whereBetween('thoi_gian', [Carbon::now()->subWeeks(2), Carbon::now()->subWeek()]);
                break;
            case 4: // 1 Tháng trước
                $query->whereBetween('thoi_gian', [Carbon::now()->subMonths(2), Carbon::now()->subMonth()]);
                break;
        }

        $data = $query->selectRaw('DATE(thoi_gian) as date, SUM(tong_tien) as total_earnings')
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();


        return response()->json([
            'series' => [
                ['name' => 'Thu nhập', 'data' => $data->pluck('total_earnings')->toArray()],
                ['name' => 'Chi phí', 'data' => array_map(fn($e) => $e * 0.8, $data->pluck('total_earnings')->toArray())],
            ],
            'categories' => $data->pluck('date')->toArray(),
        ]);
    }


    public function getProductStats()
    {
        // Lấy tổng số loại sản phẩm có so_luong > 0 và trạng thái = 1
        $totalProductTypes = SanPham::where('so_luong', '>', 0)
            ->where('trang_thai', 1)
            ->count();

        // Lấy số loại sản phẩm mới (nhập trong vòng 30 ngày)
        $newProductTypes = SanPham::where('so_luong', '>', 0)
            ->where('trang_thai', 1)
            ->where('ngay_nhap', '>=', Carbon::now()->subDays(30))
            ->count();

        // Số loại sản phẩm còn lại
        $remainingProductTypes = $totalProductTypes - $newProductTypes;

        // Tránh lỗi chia cho 0
        if ($totalProductTypes > 0) {
            $newProductPercentage = round(($newProductTypes / $totalProductTypes) * 100, 2);
            $remainingProductPercentage = round(($remainingProductTypes / $totalProductTypes) * 100, 2);
        } else {
            $newProductPercentage = 0;
            $remainingProductPercentage = 0;
        }

        return response()->json([
            'series' => [$newProductPercentage, $remainingProductPercentage],
            'labels' => ['Sản phẩm mới (%)', 'Sản phẩm còn lại (%)']
        ]);
    }
    public function getOrdersByDay()
    {
        // Lấy danh sách 7 ngày gần nhất
        $dates = [];
        for ($i = 6; $i >= 0; $i--) {
            $dates[Carbon::now()->subDays($i)->toDateString()] = 0;
        }

        // Truy vấn đơn hàng hoàn thành trong 7 ngày gần nhất
        $orders = DonHang::where('trang_thai_don_hang', 4)
            ->where('thoi_gian', '>=', Carbon::now()->subDays(6)->startOfDay())
            ->selectRaw('DATE(thoi_gian) as date, COUNT(*) as total_orders')
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->pluck('total_orders', 'date') // Lấy dữ liệu dưới dạng key-value
            ->toArray();

        // Gán dữ liệu đơn hàng vào danh sách ngày, nếu không có thì giữ nguyên 0
        foreach ($orders as $date => $total) {
            $dates[$date] = (int) $total;
        }

        return response()->json([
            'categories' => array_keys($dates),
            'series' => [
                [
                    'name' => 'Đơn hàng',
                    'color' => '#49BEFF',
                    'data' => array_values($dates),
                ]
            ]
        ]);
    }
}