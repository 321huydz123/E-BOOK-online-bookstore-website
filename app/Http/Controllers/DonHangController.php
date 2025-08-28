<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DonHang;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Services\TelegramService;
use App\Services\PhpMailerService;
use Illuminate\Support\Facades\File;
use App\Models\User;


class DonHangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $donhang = DonHang::with('chiTietSanPham.sanPham.hinhAnh', 'user')->get();
        // dd($donhang);
        return view('admin.DonHang.index', [
            'donhangs' => $donhang,
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
    public function store(Request $request, TelegramService $telegramService)
    {
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
        $user = User::where('id', auth()->id())->first();
        $to = $user->email;
        $subject = '<p>Order successful</p>';
        $filePath = public_path('admin/js/telegram.json');

        if (File::exists($filePath)) {
            $content = File::get($filePath);
            $data = json_decode($content, true);
            $messageTemplate = $data['message'];
        } else {
            \Log::error('Telegram JSON file not found.');
            return false;
        }
        // Kiểm tra và xử lý mảng sản phẩm
        $products = [];
        $productDetails = [];

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
            $invoiceCode = 'HD' . strtoupper(Str::random(6)) . time();

            $add_order_id = DB::table('don_hang')->insertGetId([
                'id_user' => auth()->id(),
                'trang_thai_don_hang' => 1,
                'tong_tien' => (int) str_replace('.', '', $request->totalAmount),
                'dia_chi' => $request->address,
                'ghi_chu' => $request->note ?? null,
                'sdt' => $request->phone,
                'thoi_gian' => now(),
                'ma_hoa_don' => $invoiceCode,
                'phuong_thuc_thanh_toan' => 2,
            ]);
            if ($add_order_id) {
                foreach ($products as $product) {
                    $productID = DB::table('san_pham')->where('id', $product['id'])->first();
                    DB::table('chi_tiet_don_hang')->insert([
                        'id_don_hang' => $add_order_id, // ID đơn hàng
                        'id_san_pham' => $product['id'], // ID sản phẩm
                        'so_luong' => $product['soluong'], // Số lượng
                        'ten_san_pham' => $productID->ten_san_pham,
                        'gia' => $productID->gia_ban * $product['soluong'],
                    ]);
                    DB::table('san_pham')
                        ->where('id', $product['id'])
                        ->decrement('so_luong', $product['soluong']);
                    $productDetails[] = "{$product['soluong']}x {$productID->ten_san_pham}";
                }
                $message = str_replace(
                    [
                        '{TEN_SAN_PHAM}',
                        '{ID_USER}',
                        '{DON_HANG_ID}',
                        '{TONG_TIEN}',
                        '{PAYMENT_DATE}'
                    ],
                    [
                        implode(', ', $productDetails),
                        auth()->id(),
                        $invoiceCode,
                        $request->totalAmount . 'VND. Thanh Toán khi nhận hàng',
                        now()->toDateTimeString()
                    ],
                    $messageTemplate
                );
                $telegramService->sendMessage($message);
                $body = '<div style="max-width: 600px; margin: 20px auto; background-color: #ffffff; padding: 20px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); font-family: Arial, sans-serif;">
                        <div style="text-align: center; background-color: #007BFF; color: #ffffff; padding: 10px 0; border-radius: 8px 8px 0 0;">
                            <h1 style="margin: 0;">Thông Tin Đơn Hàng</h1>
                        </div>

                        <div style="padding: 20px; color: #333333; line-height: 1.6;">
                            <p>Xin chào <strong>' . htmlspecialchars($user->ten) . '</strong>,</p>
                            <p>Cảm ơn bạn đã đặt hàng - chúng tôi sẽ sớm gửi hàng cho bạn </p>
                            <p><strong>Chi tiết đơn hàng:</strong></p>
                            <ul>
                                <li>Tên sản phẩm: <strong>' . htmlspecialchars(implode(', ', $productDetails)) . '</strong></li>
                                <li>ID Người đăt: <strong>' . htmlspecialchars(auth()->id()) . '</strong></li>
                                <li>Mã hóa đơn: <strong>' . htmlspecialchars($invoiceCode) . '</strong></li>
                                <li>Tổng tiền: <strong>' . number_format($request->totalAmount, 2) . 'VND</strong></li>
                                <li>Thời gian: <strong>' . now()->format('d-m-Y') . '</strong></li>
                            </ul>


                            <p>Nếu bạn có bất kỳ câu hỏi nào, xin vui lòng <a href="mailto:nhungbae2004@gmail.com" style="color: #007BFF;">liên hệ với chúng tôi</a>.</p>
                        </div>

                        <div style="text-align: center; margin-top: 20px; font-size: 12px; color: #888888;">
                            <p>Cảm ơn bạn đã chọn dịch vụ của chúng tôi!</p>
                            <p>&copy; 2025 Ebook. All rights reserved.</p>
                        </div>
                    </div>';
                $result = PhpMailerService::sendEmail($to, $subject, $body);
            }
            return response()->json(['success' => true, 'message' => 'thành công']);
        } else {
            // Nếu mảng sản phẩm không hợp lệ, trả về lỗi
            return response()->json(['status' => 'error', 'message' => 'Dữ liệu sản phẩm không hợp lệ.']);
        }

        // Trả về phản hồi thành công
        return response()->json(['status' => 'success']);
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
    public function updateStatus(Request $request)
    {
        $validated = $request->validate([
            'id_don_hang' => 'required|integer',
            'trang_thai' => 'required|integer|in:1,2,3,4,5',
        ]);

        $donHang = DB::table('don_hang')->where('id', $validated['id_don_hang'])->first();

        if (!$donHang) {
            return response()->json([
                'success' => false,
                'message' => 'Đơn hàng không tồn tại.',
            ]);
        }

        // Lấy trạng thái hiện tại
        $trangThaiHienTai = $donHang->trang_thai_don_hang;

        // Logic kiểm tra trạng thái hợp lệ
        $validTransitions = [
            1 => [2], // Chờ -> Tiếp nhận
            2 => [3, 5], // Tiếp nhận -> Đang giao hàng hoặc Hủy
            3 => [4], // Đang giao hàng -> Đã giao hàng
            4 => [], // Đã giao hàng -> Không thể thay đổi
            5 => [], // Hủy -> Không thể thay đổi
        ];

        // Kiểm tra trạng thái mới có hợp lệ không
        if (!in_array($validated['trang_thai'], $validTransitions[$trangThaiHienTai])) {
            return response()->json([
                'success' => false,
                'message' => 'Chuyển đổi trạng thái không hợp lệ.',
            ]);
        }

        // Cập nhật trạng thái
        DB::table('don_hang')
            ->where('id', $validated['id_don_hang'])
            ->update(['trang_thai_don_hang' => $validated['trang_thai']]);

        return response()->json([
            'success' => true,
            'message' => 'Cập nhật trạng thái thành công.',
            'trang_thai' => $validated['trang_thai'],
        ]);
    }



    /**
     * Remove the specified resource from storage.
     */
    public function cancel($id)
    {
        // Cập nhật trạng thái đơn hàng thành 5 (Đã hủy)
        DB::table('don_hang')
            ->where('id', $id)
            ->update(['trang_thai_don_hang' => 5]);

        // Quay lại trang trước và hiển thị thông báo thành công
        return redirect()
            ->back()
            ->with('alert', [
                'type' => 'success',
                'message' => 'Hủy đơn hàng thành công!'
            ]);
    }

    public function invoice($id)
    {
        $donhang = DonHang::with('chiTietSanPham.sanPham.hinhAnh', 'user')->where('id', $id)->first();
        return view('admin.DonHang.invoice', compact('donhang'));
    }
    public function destroy(string $id)
    {
        //
    }
}
