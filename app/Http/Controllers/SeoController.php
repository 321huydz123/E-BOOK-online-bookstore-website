<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class SeoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $filePath = public_path('admin/js/config.json');

        // Kiểm tra file có tồn tại không, nếu không thì tạo dữ liệu mặc định
        if (File::exists($filePath)) {
            $configData = json_decode(File::get($filePath), true);
        } else {
            $configData = [
                'facebook_link' => '',
                'address' => '',
                'phone_number' => '',
                'logo' => ''
            ];
        }
        return view('admin.CaiDat.seo', compact('configData'));
    }
    public function saveScript(Request $request)
    {
        // Lấy nội dung script từ yêu cầu
        $nameContent = $request->input('name');
        $scriptContent = $request->input('script');

        // Đường dẫn đến file script.js
        $filePath = public_path('admin/js/seo.json');

        // Đọc nội dung hiện có của tệp JSON
        $currentData = [];
        if (File::exists($filePath)) {
            $currentData = json_decode(File::get($filePath), true) ?? [];
        }

        // Kiểm tra tên trùng lặp
        foreach ($currentData as $entry) {
            if ($entry['name'] == $nameContent) {
                return response()->json(['error' => 'Name already exists'], 400);
            }
        }

        // Thêm nội dung mới vào mảng
        $currentData[] = [
            'name' => $nameContent,
            'script' => $scriptContent
        ];

        // Chuyển đổi mảng thành JSON
        $jsonContent = json_encode($currentData, JSON_PRETTY_PRINT);

        // Lưu nội dung vào file
        try {
            File::put($filePath, $jsonContent);
            return response()->json([
                'alert' => [
                    'type' => 'success',
                    'message' => 'Cập nhật thành công !'
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Lưu Script Thành Công'], 500);
        }
    }
    public function getScripts()
    {
        $filePath = public_path('admin/js/seo.json');

        if (File::exists($filePath)) {
            $scripts = json_decode(File::get($filePath), true) ?? [];
        } else {
            $scripts = [];
        }

        return response()->json($scripts);
    }
    public function deleteScript(Request $request)
    {
        $name = $request->input('name');
        $filePath = public_path('admin/js/seo.json');
        if (File::exists($filePath)) {
            $scripts = json_decode(File::get($filePath), true) ?? [];
            $scripts = array_filter($scripts, function ($script) use ($name) {
                return $script['name'] !== $name;
            });
            File::put($filePath, json_encode(array_values($scripts), JSON_PRETTY_PRINT));
            return response()->json(['alert' => ['type' => 'success', 'message' => 'Xóa Script Thành Công!']]);
        } else {
            return response()->json(['error' => 'Xóa thất bại'], 500);
        }
    }
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
                'message' => 'Configuration saved successfully!'
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with('alert', [
                'type' => 'error',
                'message' => 'Failed to save chat ID and bot token to .env!'
            ]);
        }
    }
    public function saveConfig(Request $request)
    {
        $filePath = public_path('admin/js/config.json');

        // Kiểm tra input, nếu không có thì gán rỗng ""
        $facebookLink = $request->input('facebook_link', '');
        $address = $request->input('address', '');
        $phoneNumber = $request->input('phone_number', '');

        // Đọc file JSON hiện tại để lấy logo cũ
        $oldLogo = null;
        if (File::exists($filePath)) {
            $configData = json_decode(File::get($filePath), true);
            $oldLogo = $configData['logo'] ?? null;
        }

        // Xử lý upload logo mới
        if ($request->hasFile('logo')) {
            // Xóa logo cũ nếu tồn tại
            if ($oldLogo && File::exists(public_path($oldLogo))) {
                File::delete(public_path($oldLogo));
            }

            // Upload logo mới
            $logoFile = $request->file('logo');
            $logoName = time() . '_' . $logoFile->getClientOriginalName();
            $logoPath = 'assets/logo/' . $logoName;
            $logoFile->move(public_path('assets/logo/'), $logoName);
        } else {
            // Nếu không có file mới, giữ nguyên logo cũ (nếu có)
            $logoPath = $oldLogo ?? '';
        }

        // Tạo dữ liệu JSON
        $configData = [
            'facebook_link' => $facebookLink,
            'address' => $address,
            'phone_number' => $phoneNumber,
            'logo' => $logoPath
        ];

        try {
            // Lưu vào file JSON
            File::put($filePath, json_encode($configData, JSON_PRETTY_PRINT));

            // Trả về view với dữ liệu vừa lưu
            return redirect()->back()->with('alert', [
                'type' => 'success',
                'message' => 'Thành Công !'
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Không thể lưu cấu hình.');
        }
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
