<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Carbon;
use App\Models\Channel;
use App\Models\User;

use Illuminate\Support\Facades\File;
use App\Services\PhpMailerService;
use App\Services\TelegramService;


class VnPayController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function initiatePayment(Request $request)
    {
        // dd(session('total_amount'));


        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = 'http://' . env('VNPAY_WEB_URL') . '/IPN';
        $vnp_TmnCode = env('VNPAY_TERMINAL_ID'); // Mã website tại VNPAY
        $vnp_HashSecret = env('VNPAY_SECRET_KEY'); // Chuỗi bí mật
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $OrderInfo = auth()->id() . '_' . substr(str_shuffle(str_repeat($characters, 8)), 0, 8);
        $vnp_TxnRef = $OrderInfo; // Mã đơn hàng
        $vnp_OrderInfo = $OrderInfo;
        $vnp_OrderType = "topup";
        $vnp_Amount = (int) str_replace('.', '', session('total_amount')) * 100;

        $vnp_Locale = "vi";
        $vnp_BankCode = "";
        $vnp_IpAddr = $request->ip();
        $vnp_Bill_Mobile = '84773311371';
        $vnp_Bill_Email = 'nguyenquangcuong25022004@gmail.com';
        $fullName = trim("Nguyen Quang Cuong");

        if (isset($fullName) && trim($fullName) != '') {
            $name = explode(' ', $fullName);
            $vnp_Bill_FirstName = array_shift($name);
            $vnp_Bill_LastName = array_pop($name);
        }

        $inputData = [
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,
            //  "vnp_ExpireDate" => $vnp_ExpireDate,
            "vnp_Bill_Mobile" => $vnp_Bill_Mobile,
            "vnp_Bill_Email" => $vnp_Bill_Email,
            "vnp_Bill_FirstName" => $vnp_Bill_FirstName,
            "vnp_Bill_LastName" => $vnp_Bill_LastName,
            "vnp_Inv_Type" => 1,
        ];

        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }
        if (isset($vnp_Bill_State) && $vnp_Bill_State != "") {
            $inputData['vnp_Bill_State'] = $vnp_Bill_State;
        }

        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret); //
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }
        $returnData = array(
            'code' => '00',
            'message' => 'success',
            'data' => $vnp_Url
        );
        if (isset($returnData)) {
            header('Location: ' . $vnp_Url);

            die();
        } else {
            echo json_encode($returnData);
        }
    }

    public function handleIPN(TelegramService $telegramService)
    {
        $vnp_HashSecret = env('VNPAY_SECRET_KEY');
        $vnp_SecureHash = $_GET['vnp_SecureHash'];
        $inputData = array();
        foreach ($_GET as $key => $value) {
            if (substr($key, 0, 4) == "vnp_") {
                $inputData[$key] = $value;
            }
        }
        unset($inputData['vnp_SecureHash']);
        ksort($inputData);
        $i = 0;
        $hashData = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashData = $hashData . '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashData = $hashData . urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
        }
        $secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);
        if ($secureHash == $vnp_SecureHash) {
            $vnp_Amount = $_GET['vnp_Amount'];
            $vnp_BankCode = $_GET['vnp_BankCode'];
            $vnp_BankTranNo = isset($_GET['vnp_BankTranNo']) ? $_GET['vnp_BankTranNo'] : null;
            $vnp_CardType = $_GET['vnp_CardType'];
            $vnp_OrderInfo = $_GET['vnp_OrderInfo'];
            $vnp_PayDate = date('Y-m-d H:i:s', strtotime($_GET['vnp_PayDate']));
            $vnp_ResponseCode = $_GET['vnp_ResponseCode'];
            $vnp_TmnCode = $_GET['vnp_TmnCode'];
            $vnp_TransactionNo = $_GET['vnp_TransactionNo'];
            $vnp_TransactionStatus = $_GET['vnp_TransactionStatus'];
            $vnp_TxnRef = $_GET['vnp_TxnRef'];
            $vnp_SecureHash = $_GET['vnp_SecureHash'];






            $user = User::where('id', auth()->id())->first();
            $to = $user->email;
            $subject = 'Thanh Toan Thanh Cong';



            $filePath = public_path('admin/js/telegram.json');

            if (File::exists($filePath)) {
                $content = File::get($filePath);
                $data = json_decode($content, true);
                $messageTemplate = $data['message'];
            } else {
                \Log::error('Telegram JSON file not found.');
                return false;
            }

            if ($_GET['vnp_ResponseCode'] == '00') {
                $add_order_id = DB::table('don_hang')->insertGetId([
                    'id_user' => auth()->id(),
                    'trang_thai_don_hang' => 1,
                    'tong_tien' => (int) str_replace('.', '', session('total_amount')),
                    'dia_chi' => session('address'),
                    'ghi_chu' => session('note') ?? null,
                    'sdt' => session('phone'),
                    'thoi_gian' => now(),
                    'ma_hoa_don' => $vnp_OrderInfo,
                    'phuong_thuc_thanh_toan' => 1,
                ]);
                $productDetails = [];
                if ($add_order_id) {

                    foreach (session('products') as $product) {
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
                            $vnp_OrderInfo,
                            (int) str_replace('.', '', session('total_amount')) . 'VND',
                            Carbon::now()->toDateTimeString()
                        ],
                        $messageTemplate
                    );

                    // Gửi tin nhắn qua Telegram
                    $telegramService->sendMessage($message);
                    $body = '<div style="max-width: 600px; margin: 20px auto; background-color: #ffffff; padding: 20px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); font-family: Arial, sans-serif;">
                        <div style="text-align: center; background-color: #007BFF; color: #ffffff; padding: 10px 0; border-radius: 8px 8px 0 0;">
                            <h1 style="margin: 0;">Thông Tin Giao Dịch</h1>
                        </div>

                        <div style="padding: 20px; color: #333333; line-height: 1.6;">
                            <p>Xin chào <strong>' . htmlspecialchars($user->ten) . '</strong>,</p>
                            <p>Cảm ơn bạn đã mua hàng - chúng tôi đã nhận được khoản thanh toán</p>
                            <p><strong>Chi tiết giao dịch:</strong></p>
                            <ul>
                                <li>Tên sản phẩm: <strong>' . htmlspecialchars(implode(', ', $productDetails)) . '</strong></li>
                                <li>ID Người đăt: <strong>' . htmlspecialchars(auth()->id()) . '</strong></li>
                                <li>Mã hóa đơn: <strong>' . htmlspecialchars($vnp_OrderInfo) . '</strong></li>
                                <li>Tổng tiền: <strong>' . number_format((int) str_replace('.', '', session('total_amount')), 2) . 'VND</strong></li>
                                <li>Thời gian: <strong>' . Carbon::now()->format('d-m-Y') . '</strong></li>
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
                DB::table('gio_hang')->where('id_user', auth()->id())->where('id_san_pham', $productID->id)->delete();


                return redirect()->route('web.trang-chu')->with('alert', [
                    'type' => 'success',
                    'message' => 'Thanh toán thành công!'
                ]);
            } else {
                return redirect()->route('web.thanh-toan')->with('alert', [
                    'type' => 'error',
                    'message' => 'Thanh toán thất bại!'
                ]);
            }
        } else {
            return redirect()->route('web.thanh-toan')->with('alert', [
                'type' => 'error',
                'message' => 'Không hợp lệ!'
            ]);
        }
    }
}
