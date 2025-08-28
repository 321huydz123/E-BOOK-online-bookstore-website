<?php

namespace App\Http\Controllers;

use App\Models\DiaChi;
use App\Models\GioHang;
use Illuminate\Http\Request;
use App\Models\LoaiSanPham;
use App\Models\SanPham;
use Illuminate\Support\Facades\DB;

class GioHangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // dd(auth()->id());
        $danhmucs = LoaiSanPham::all();
        $giohang = GioHang::with(
            'san_pham',
            'san_pham.hinhAnh'
        )->where('id_user', auth()->id()) // Lọc theo người dùng hiện tại
            ->get();


        // dd($giohang);


        return view(
            'web.GioHang.index',
            [
                'giohang' => $giohang,
                'danhmucs' => $danhmucs,
            ]
        );
    }


    public function updateQuantity(Request $request)
    {
        $cartItemId = $request->input('id');
        $productId = $request->input('id_san_pham'); // Nhận id_san_pham
        $action = $request->input('action'); // 'increase' hoặc 'decrease'

        // Lấy thông tin sản phẩm từ giỏ hàng
        $cartItem = GioHang::find($cartItemId);
        if (!$cartItem || $cartItem->id_san_pham != $productId) {
            return response()->json(['success' => false, 'message' => 'Dữ liệu không hợp lệ.']);
        }

        // Lấy thông tin sản phẩm từ bảng `san_pham`
        $product = DB::table('san_pham')->where('id', $productId)->first();
        if (!$product) {
            return response()->json(['success' => false, 'message' => 'Sản phẩm không tồn tại.']);
        }

        // Kiểm tra số lượng tồn kho
        if ($action === 'increase') {
            if ($cartItem->so_luong + 1 > $product->so_luong) {
                return response()->json([
                    'success' => false,
                    'message' => 'Số lượng sản phẩm không đủ trong kho.'
                ]);
            }
            $cartItem->so_luong += 1;
        } elseif ($action === 'decrease' && $cartItem->so_luong > 1) {
            $cartItem->so_luong -= 1;
        }

        $cartItem->save();

        // Tính lại tổng giá cho sản phẩm
        $totalPrice = $cartItem->so_luong * $cartItem->san_pham->gia_ban;

        return response()->json([
            'success' => true,
            'so_luong' => $cartItem->so_luong,
            'total_price' => $totalPrice,
        ]);
    }
    public function checkout()
    {
        $danhmucs = LoaiSanPham::all();
        $diachi = DiaChi::where('id_user', auth()->id())
            ->where('trang_thai', 1)
            ->first();
        // Lấy danh sách sản phẩm từ session
        $cartIds = session('cart', []);

        if (empty($cartIds)) {
            return redirect()->route('web.cart')->with('error', 'Giỏ hàng trống!');
        }

        // Lấy thông tin sản phẩm từ cơ sở dữ liệu và kiểm tra trạng thái sản phẩm
        $products = GioHang::with(
            'san_pham',
            'san_pham.hinhAnh'
        )->whereIn('id', $cartIds)->get();
        // dd($products);

        // Kiểm tra các sản phẩm có trạng thái là 0 (ngừng bán) và thông báo lại
        $outOfStockProducts = $products->filter(function ($item) {
            return $item->san_pham->trang_thai == 0; // Kiểm tra sản phẩm đã ngừng bán
        });

        if ($outOfStockProducts->isNotEmpty()) {
            // Tạo thông báo hoặc loại bỏ sản phẩm đã ngừng bán
            $outOfStockProductNames = $outOfStockProducts->pluck('san_pham.ten_san_pham')->implode(', ');
            return redirect()->route('web.gio-hang')->with('error', 'Sản phẩm ' . $outOfStockProductNames . ' đã ngừng bán!');
        }

        return view('web.GioHang.checkout', [
            'danhmucs' => $danhmucs,
            'products' => $products,
            'diachi' => $diachi,
        ]);
    }
    public function checkoutv2()
    {
        $danhmucs = LoaiSanPham::all();
        $diachi = DiaChi::where('id_user', auth()->id())
            ->where('trang_thai', 1)
            ->first();

        // Lấy danh sách sản phẩm từ session
        $cartIds = session('cart', []);

        if (empty($cartIds)) {
            return redirect()->route('web.cart')->with('error', 'Giỏ hàng trống!');
        }

        // Lấy thông tin sản phẩm từ cơ sở dữ liệu và kiểm tra trạng thái sản phẩm
        $products = SanPham::with(
            'hinhAnh'
        )->whereIn('id', $cartIds)->get();
        // dd($products);

        // Kiểm tra các sản phẩm có trạng thái là 0 (ngừng bán) và thông báo lại
        $outOfStockProducts = $products->filter(function ($item) {
            return $item->trang_thai == 0; // Kiểm tra sản phẩm đã ngừng bán
        });

        if ($outOfStockProducts->isNotEmpty()) {
            // Tạo thông báo hoặc loại bỏ sản phẩm đã ngừng bán
            $outOfStockProductNames = $outOfStockProducts->pluck('ten_san_pham')->implode(', ');
            return redirect()->route('web.gio-hang')->with('error', 'Sản phẩm ' . $outOfStockProductNames . ' đã ngừng bán!');
        }

        return view('web.GioHang.checkoutv2', [
            'danhmucs' => $danhmucs,
            'products' => $products,
            'diachi' => $diachi,
        ]);
    }

    public function storeCart(Request $request)
    {
        $selectedIds = $request->selectedIds;
        // dd($selectedIds);
        // Giả sử lưu giỏ hàng vào session
        session(['cart' => $selectedIds]);

        return response()->json(['success' => true]);
    }
    public function storeOrderInfo(Request $request)
    {
        // dd($request->all());
        // Kiểm tra và xóa các session cũ nếu có
        if (session()->has('payment_method')) {
            session()->forget('payment_method');
        }
        if (session()->has('total_amount')) {
            session()->forget('total_amount');
        }
        if (session()->has('address')) {
            session()->forget('address');
        }
        if (session()->has('products')) {
            session()->forget('products');
        }
        if (session()->has('note')) {
            session()->forget('note');
        }
        if (session()->has('phone')) {
            session()->forget('phone');
        }
        // Kiểm tra và xử lý mảng sản phẩm
        $products = [];

        // Kiểm tra xem mảng 'products' có tồn tại trong request không
        if ($request->has('products') && is_array($request->products)) {
            foreach ($request->products as $product) {
                // Lưu thông tin sản phẩm vào mảng $products
                $products[] = [
                    'id' => $product['id'],     // ID sản phẩm
                    'soluong' => $product['soluong'],  // Số lượng
                ];
            }
        }

        // Kiểm tra nếu mảng sản phẩm không rỗng
        if (!empty($products)) {
            // Lưu thông tin vào session
            session([
                'payment_method' => $request->paymentMethod, // Phương thức thanh toán
                'total_amount' => $request->totalAmount, // Tổng tiền
                'address' => $request->address, // Địa chỉ
                'note' => $request->note, //
                'phone' => $request->phone, //
                'products' => $products, // Mảng sản phẩm
            ]);
        } else {
            // Nếu mảng sản phẩm không hợp lệ, trả về lỗi
            return response()->json(['status' => 'error', 'message' => 'Dữ liệu sản phẩm không hợp lệ.']);
        }

        // Trả về phản hồi thành công
        return response()->json(['status' => 'success']);
    }



    public function addToCart(Request $request)
    {
        $userId = auth()->id(); // Lấy ID người dùng đang đăng nhập
        $productId = $request->product_id;
        $quantity = $request->quantity ?? 1;

        // Kiểm tra xem sản phẩm đã có trong giỏ hàng chưa
        $cartItem = GioHang::where('id_user', $userId)
            ->where('id_san_pham', $productId)
            ->first();

        if ($cartItem) {
            // Nếu có rồi thì cập nhật số lượng
            $cartItem->so_luong += $quantity;
            $cartItem->save();
        } else {
            // Nếu chưa có, thêm mới vào bảng cart
            GioHang::create([
                'id_user' => $userId,
                'id_san_pham' => $productId,
                'so_luong' => $quantity,
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Sản phẩm đã được thêm vào giỏ hàng!',
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

        $cartItem = GioHang::find($id);

        if ($cartItem) {
            $cartItem->delete(); // Xóa sản phẩm khỏi bảng
            return redirect()->back()->with('alert', [
                'type' => 'success',
                'message' => 'Xóa sản phẩm trong giỏ hàng thành công!',
            ]);
        }

        return redirect()->back()->with('alert', [
            'type' => 'erro',
            'message' => 'Không tìm thấy sản phẩm !',
        ]);
    }
    public function destroyAll()
    {
        // Lấy ID user đang đăng nhập
        $userId = auth()->id();

        if (!$userId) {
            return redirect()->back()->with('error', 'Bạn cần đăng nhập để xóa giỏ hàng!');
        }

        // Xóa toàn bộ sản phẩm trong giỏ hàng của user hiện tại
        GioHang::where('id_user', $userId)->delete();

        return redirect()->back()->with('alert', [
            'type' => 'success',
            'message' => 'Xóa sản phẩm trong giỏ hàng thành công!',
        ]);
    }
}
