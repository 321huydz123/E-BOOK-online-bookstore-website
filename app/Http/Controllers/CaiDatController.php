<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class CaiDatController extends Controller
{
    public function createMail()
    {
        return view('admin.CaiDat.mail');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeMail(Request $request)
    {

        $request->validate([
            'mailUserName' => 'required|email',
            'MAIL_FROM_NAME' => 'string'
            // Validate email format
        ]);

        $mailUserName = $request->input('mailUserName');
        $mailPassWord = $request->input('mailPassWord');
        $mailfromName = $request->input('MAIL_FROM_NAME');
        $mailPassWord = str_replace(' ', '', $mailPassWord);


        try {
            $this->updateEnv([
                'MAIL_USERNAME' => $mailUserName,
                'MAIL_FROM_ADDRESS' => $mailUserName,
                'MAIL_PASSWORD' => $mailPassWord,
                'MAIL_FROM_NAME' => "\"" . $mailfromName . "\"",
                'MAIL_FROM_ADDRESS' => $mailUserName

            ]);

            return redirect()->back()->with('alert', [
                'type' => 'success',
                'message' => 'Đã lưu cấu hình thành công!'
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with('alert', [
                'type' => 'error',
                'message' => 'Không lưu được ID trò chuyện và mã thông báo bot vào .env!'
            ]);
        }
    }
    private function updateEnv(array $data)
    {
        $envPath = base_path('.env');
        $envContent = file_get_contents($envPath);

        foreach ($data as $key => $value) {
            $pattern = "/^{$key}=.*$/m";

            if (preg_match($pattern, $envContent)) {
                $envContent = preg_replace($pattern, "{$key}={$value}", $envContent);
            } else {
                $envContent .= "\n{$key}={$value}";
            }
        }

        file_put_contents($envPath, $envContent);
    }
    public function createBotTeleGram()
    {
        $filePath = public_path('admin/js/telegram.json');

        // Biến để lưu dữ liệu từ JSON
        $data = [];

        // Kiểm tra nếu file tồn tại
        if (File::exists($filePath)) {
            // Đọc nội dung của file
            $content = File::get($filePath);

            // Chuyển đổi nội dung JSON thành mảng PHP
            $data = json_decode($content, true);

            // Kiểm tra lỗi khi giải mã JSON
            if (json_last_error() !== JSON_ERROR_NONE) {
                // return response()->json(['error' => 'Invalid JSON format'], 400);
            }
        }
        // Trả về view với dữ liệu
        return view('admin.CaiDat.telegram', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeBotTeleGram(Request $request)
    {
        $message = $request->input('message');
        $messageContact = $request->input('messageContact');
        $filePath = public_path('admin/js/telegram.json');

        $requiredPlaceholders = [
            '{TEN_SAN_PHAM}',
            '{ID_USER}',
            '{DON_HANG_ID}',
            '{TONG_TIEN}',
            '{PAYMENT_DATE}',
        ];


        

        $missingPlaceholders = [];
        foreach ($requiredPlaceholders as $placeholder) {
            if (strpos($message, $placeholder) === false) {
                $missingPlaceholders[] = $placeholder;
            }
        }

        

        if (!empty($missingPlaceholders)) {
            $missingPlaceholdersString = implode(', ', $missingPlaceholders);

            return redirect()->back()->with('alert', [
                'type' => 'error',
                'message' => 'The message is missing required placeholders: ' . $missingPlaceholdersString
            ]);
        }

        // Lưu message vào file JSON
        $jsonContent = json_encode([
            'message' => $message,
            'messageContact' => $messageContact,
        ], JSON_PRETTY_PRINT);

        try {
            File::put($filePath, $jsonContent);
        } catch (\Exception $e) {
            return redirect()->back()->with('alert', [
                'type' => 'error',
                'message' => 'Failed to save message to JSON file!'
            ]);
        }

        // Lưu chatID và botToken vào file .env
        $chatID = $request->input('chatID');
        $botToken = $request->input('botToken');
    

        try {
            $this->updateEnv([
                'TELEGRAM_CHAT_ID' => $chatID,
                'TELEGRAM_BOT_TOKEN' => $botToken,

            ]);

            return redirect()->back()->with('alert', [
                'type' => 'success',
                'message' => 'Configuration saved successfully!'
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with('alert', [
                'type' => 'error',
                'message' => 'Failed to save chat ID and bot token to .env!'
            ]);
        }
    }
    public function createVnPay()
    {
        return view('admin.CaiDat.vnpay');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeVnPay(Request $request)
    {

        $terminalID = $request->input('terminalID');
        $secretKey = $request->input('secretKey');
        $webUrl = $request->input('webUrl');

        if (!preg_match('/^https?:\/\//', $webUrl)) {
            $webUrl = 'https://' . $webUrl;
        }


        if (!filter_var($webUrl, FILTER_VALIDATE_URL)) {
            return redirect()->back()->with('alert', [
                'type' => 'error',
                'message' => 'The provided URL is not valid!'
            ]);
        }



        // Lấy hostname từ URL
        $parsedUrl = parse_url($webUrl);
        $host = $parsedUrl['host'] ?? null;

        $webUrl = preg_replace('/^https?:\/\//', '', $host);
        if (!$host) {
            return redirect()->back()->with('alert', [
                'type' => 'error',
                'message' => 'The URL is invalid. Could not extract the domain!'
            ]);
        }



        // dd($webUrl);

        try {
            $this->updateEnv([
                'VNPAY_TERMINAL_ID' => $terminalID,
                'VNPAY_SECRET_KEY' => $secretKey,
                'VNPAY_WEB_URL' => $webUrl,

            ]);

            return redirect()->back()->with('alert', [
                'type' => 'success',
                'message' => 'Configuration saved successfully!'
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with('alert', [
                'type' => 'error',
                'message' => 'Failed to save chat ID and bot token to .env!'
            ]);
        }
    }
}