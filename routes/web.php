<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OtpController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\GioiThieuController;
use App\Http\Controllers\LoaiSanPhamController;
use App\Http\Controllers\SanPhamController;
use App\Http\Controllers\ThongKeController;
use App\Http\Controllers\TacGiaController;
use App\Http\Controllers\NhaPhatHanhController;
use App\Http\Controllers\NhaSanXuatController;
use App\Http\Controllers\TrangChuController;
use App\Http\Controllers\GioHangController;
use App\Http\Controllers\TaiKhoanController;
use App\Http\Controllers\BinhLuanController;
use App\Http\Controllers\CaiDatController;
use App\Http\Controllers\CuocTroChuyenController;
use App\Http\Controllers\DiaChiController;
use App\Http\Controllers\VnPayController;
use App\Http\Controllers\DonHangController;
use App\Http\Controllers\SeoController;
use App\Http\Controllers\TinNhanController;
use App\Models\CuocTroChuyen;
use App\Models\TinNhan;

// Route::get('/Home', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [TaiKhoanController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';


Route::get('/verify', [VerificationController::class, 'showVerifyForm'])->name('verification.show');
Route::post('/verify', [VerificationController::class, 'verify'])->name('verification.verify');



// admin
Route::prefix('admin')->middleware('auth.role.admin')->group(function () {
    Route::get('Thong-Ke.html', [ThongKeController::class, 'index'])->name('thong-ke');
    Route::get('/chart-data', [ThongKeController::class, 'getChartData'])->name('chart.data');
    Route::get('/chart-data-auto', [ThongKeController::class, 'getChartDataAuto'])->name('chart.data-auto');
    Route::get('/orders-by-day', [ThongKeController::class, 'getOrdersByDay']);

    Route::get('/product-stats', [ThongKeController::class, 'getProductStats']);

    // Loại Sản Phâm
    Route::get('Loai-San-Pham.html', [LoaiSanPhamController::class, 'index'])->name('loai-san-pham');
    Route::get('{id}/Chinh-Sua-Loai-San-Pham.html', [LoaiSanPhamController::class, 'edit'])->name('loai-san-pham.edit');
    Route::post('Them-Loai-San-Pham.html', [LoaiSanPhamController::class, 'store'])->name('loai-san-pham.store');
    Route::put('{id}/Chinh-Sua-Loai-San-Pham.html', [LoaiSanPhamController::class, 'update'])->name('loai-san-pham.update');
    Route::delete('{id}/Xoa-Loai-San-Pham.html', [LoaiSanPhamController::class, 'destroy'])->name('loai-san-pham.destroy');
    // End Loại Sản Phẩm

    // Sản Phẩm
    Route::get('San-Pham.html', [SanPhamController::class, 'index'])->name('san-pham');
    Route::get('Them-San-Pham.html', [SanPhamController::class, 'create'])->name('san-pham.create');
    Route::get('{id}/Chinh-Sua-San-Pham.html', [SanPhamController::class, 'edit'])->name('san-pham.edit');
    Route::post('Them-San-Pham.html', [SanPhamController::class, 'store'])->name('san-pham.store');
    Route::put('{id}/Chinh-Sua-San-Pham', [SanPhamController::class, 'update'])->name('san-pham.update');
    Route::delete('{id}/Xoa-San-Pham.html', [SanPhamController::class, 'destroy'])->name('san-pham.destroy');

    // End Sản Phẩm

    // Tác Giả
    Route::get('Tac-Gia.html', [TacGiaController::class, 'index'])->name('tac-gia');
    Route::get('{id}/Chinh-Sua-Tac-Gia.html', [TacGiaController::class, 'edit'])->name('tac-gia.edit');
    Route::post('Them-Tac-Gia.html', [TacGiaController::class, 'store'])->name('tac-gia.store');
    Route::put('{id}/Chinh-Sua-Tac-Gia.html', [TacGiaController::class, 'update'])->name('tac-gia.update');
    Route::delete('{id}/Xoa-Tac-Gia.html', [TacGiaController::class, 'destroy'])->name('tac-gia.destroy');
    // End Tác Giả

    // Nhà Phát Hành
    Route::get('Nha-Phat-Hanh.html', [NhaPhatHanhController::class, 'index'])->name('nha-phat-hanh');
    Route::get('{id}/Chinh-Sua-Nha-Phat-Hanh.html', [NhaPhatHanhController::class, 'edit'])->name('nha-phat-hanh.edit');
    Route::post('Them-Nha-Phat-Hanh.html', [NhaPhatHanhController::class, 'store'])->name('nha-phat-hanh.store');
    Route::put('{id}/Chinh-Sua-Nha-Phat-Hanh.html', [NhaPhatHanhController::class, 'update'])->name('nha-phat-hanh.update');
    Route::delete('{id}/Xoa-Nha-Phat-Hanh.html', [NhaPhatHanhController::class, 'destroy'])->name('nha-phat-hanh.destroy');
    // End  Nhà Phát Hành

    // Nhà Sản Xuất
    Route::get('Nha-San-Xuat.html', [NhaSanXuatController::class, 'index'])->name('nha-san-xuat');
    Route::get('{id}/Chinh-Sua-Nha-San-Xuat.html', [NhaSanXuatController::class, 'edit'])->name('nha-san-xuat.edit');
    Route::post('Them-Nha-San-Xuat.html', [NhaSanXuatController::class, 'store'])->name('nha-san-xuat.store');
    Route::put('{id}/Chinh-Sua-Nha-San-Xuat.html', [NhaSanXuatController::class, 'update'])->name('nha-san-xuat.update');
    Route::delete('{id}/Xoa-Nha-San-Xuat.html', [NhaSanXuatController::class, 'destroy'])->name('nha-san-xuat.destroy');
    // End  Nhà Sản Xuất


    // Tài Khoản
    Route::get('Tai-Khoan.html', [TaiKhoanController::class, 'getAllUser'])->name('tai-khoan');
    // Route::get('{id}/Chinh-Sua-Tai-Khoan.html', [TaiKhoanController::class, 'edit'])->name('tai-khoan.edit');
    // Route::post('Them-Tai-Khoan.html', [TaiKhoanController::class, 'store'])->name('tai-khoan.store');
    Route::post('Chinh-Sua-Tai-Khoan-Trang-Thai.html', [TaiKhoanController::class, 'updateStatus'])->name('tai-khoan.update');

    // Nhắn Tin
    Route::get('Tro-Chuyen.html', [TinNhanController::class, 'index'])->name('nhan-tin');
    Route::get('Kiem-Tra-Cuoc-Tro-Chuyen.html', [CuocTroChuyenController::class, 'CheckConversation'])->name('kiem-tra-cuoc-tro-chuyen');
    Route::get('Them-Cuoc-Tro-Chuyen.html', [CuocTroChuyenController::class, 'CreateConversation'])->name('them-cuoc-tro-chuyen');
    Route::post('Luu-Tin-Nhan.html', [TinNhanController::class, 'store'])->name('luu-tin-nhan');
    Route::get('Tai-Tin-Nhan.html', [TinNhanController::class, 'showChat'])->name('tai-tin-nhan');
    // end Nhắn Tin


    // Đơn hàng
    Route::get('Don-Hang.html', [DonHangController::class, 'index'])->name('don-hang');
    Route::post('Cap-Nhat-Trang-Thai.html', [DonHangController::class, 'updateStatus'])->name('don-hang.cap-nhat-trang-thai');
    Route::get('{id}/Hoa-Don.html', [DonHangController::class, 'invoice'])->name('don-hang.hoa-don');

    // Route::get('{id}/Chi-Tiet-Don-Hang.html', [DonHangController::class, 'detail'])->name('don-hang.chi-tiet');
    // Route::post('Cap-Nhat-Trang-Thai-Don-Hang.html', [DonHangController::class, 'updateStatus'])->name('don-hang.update');
    // Route::delete('{id}/Xoa-Don-Hang.html', [DonHangController::class, 'destroy'])->name('don-hang.destroy');

    // Route::get('Thong-Ke-Don-Hang.html', [ThongKeController::class, 'donHang'])->name('thong-ke-don-hang');
    // End Đơn hàng


    // cai dat
    Route::get('SEO.html', [SeoController::class, 'index'])->name('SEO');
    Route::get('/Hien-Thi-Scripts.html', [SeoController::class, 'getScripts'])->name('Hien-Thi-Scripts');
    Route::post('/Luu-Script.html', [SeoController::class, 'saveScript'])->name('Luu-Script');
    Route::post('/Xoa-Script.html', [SeoController::class, 'deleteScript'])->name('Xoa-Script');
    Route::get('/Cau-Hinh-Mail.html', [CaiDatController::class, 'createMail'])->name('Hien-Thi-mail');
    Route::post('/Cau-Hinh-Mail.html', [CaiDatController::class, 'storeMail'])->name('Them-mail');
    Route::get('/Cau-Hinh-Telegram.html', [CaiDatController::class, 'createBotTeleGram'])->name('Hien-Thi-telegram');
    Route::post('/Cau-Hinh-Telegram.html', [CaiDatController::class, 'storeBotTeleGram'])->name('Them-telegram');
    Route::get('/Cau-Hinh-Vnpay.html', [CaiDatController::class, 'createVnPay'])->name('Hien-Thi-vnpay');
    Route::post('/Cau-Hinh-Vnpay.html', [CaiDatController::class, 'storeVnPay'])->name('Them-vnpay');
    Route::post('/Cau-Hinh-Web.html', [SeoController::class, 'saveConfig'])->name('Them-cau-hinh-web');
    // end cai dat
});



// web no login

Route::get('/', [TrangChuController::class, 'index'])->name('web.trang-chu');
Route::get('/Trang-Chu.html', [TrangChuController::class, 'index'])->name('web.trang-chu');
Route::get('/San-Pham.html', [TrangChuController::class, 'getAllProducts'])->name('web.tat-ca-san-pham');
Route::get('/{id}/San-Pham.html', [TrangChuController::class, 'showByCategory'])->name('web.san-pham-theo-danh-muc');
Route::get('/San-Pham/{id}/Chi-Tiet-San-Pham.html', [SanPhamController::class, 'show'])->name('web.chi-tiet-san-pham');
Route::get('/Gioi-Thieu.html', [GioiThieuController::class, 'index'])->name('web.gioi-thieu');
Route::get('/tim-kiem-san-pham/{keyword}', [TrangChuController::class, 'search'])->name('web.tim-kiem-san-pham');
Route::get('Kiem-Tra-Cuoc-Tro-Chuyen.html', [CuocTroChuyenController::class, 'CheckConversation'])->name('kiem-tra-cuoc-tro-chuyen');
Route::get('Them-Cuoc-Tro-Chuyen.html', [CuocTroChuyenController::class, 'CreateConversation'])->name('them-cuoc-tro-chuyen');
Route::post('Luu-Tin-Nhan.html', [TinNhanController::class, 'store'])->name('luu-tin-nhan');
Route::get('Tai-Tin-Nhan.html', [TinNhanController::class, 'showChat'])->name('tai-tin-nhan');

// End web no login


// web login
Route::middleware('auth.role')->group(function () {
    Route::get('/Gio-Hang.html', [GioHangController::class, 'index'])->name('web.gio-hang');
    Route::post('/Them-Vao-Gio-Hang.html', [GioHangController::class, 'addToCart'])->name('web.them-vao-gio-hang');
    Route::post('/Cap-Nhat-So-Luong.html', [GioHangController::class, 'updateQuantity'])->name('web.cap-nhat-so-luong');
    Route::post('/Luu-Gio-Hang.html', [GioHangController::class, 'storeCart'])->name('web.luu-gio-hang');
    Route::delete('/{id}/Xoa-Gio-Hang.html', [GioHangController::class, 'destroy'])->name('web.xoa-gio-hang');
    Route::delete('/Xoa-Toan-Bo-Gio-Hang.html', [GioHangController::class, 'destroyAll'])->name('web.xoa-toan-bo-gio-hang');

    Route::get('/Thanh-Toan.html', [GioHangController::class, 'checkout'])->name('web.thanh-toan');
    Route::get('/Thanh-Toan-San-Pham.html', [GioHangController::class, 'checkoutv2'])->name('web.thanh-toanv2');
    Route::post('/Thanh-Toan-San-Pham-Truc-Tiep.html', [DonHangController::class, 'store'])->name('web.thanh-toan-truc-tiep');


    // checkout
    Route::post('/Them-Thong-Tin-Don-Hang.html', [GioHangController::class, 'storeOrderInfo'])->name('web.them-thong-tin-don-hang');
    // end checkout

    //thanh-toan
    Route::get('/Thanh-Toan-VNPAY.html', [VnPayController::class, 'initiatePayment'])->name('web.payment');
    Route::get('/IPN', [VnpayController::class, 'handleIPN']);
    // end thanh-toan

    //tai-khoan
    Route::get('/Tai-Khoan.html', [TaiKhoanController::class, 'index'])->name('web.tai-khoan');
    Route::post('/TaiKoan/{id}/Huy-Don-Hang.html', [DonHangController::class, 'cancel'])->name('web.huy-don-hang');
    Route::post('/{id}/Chon-Dia-Chi-Mac-Dinh.Html', [DiaChiController::class, 'index'])->name('web.chon-dia-chi-mac-dinh');
    Route::post('/Them-Dia-Chi.Html', [DiaChiController::class, 'store'])->name('web.them-dia-chi');
    //end tai-khoan

    // binh-luan
    Route::post('/Binh-Luan.html', [BinhLuanController::class, 'store'])->name('web.gui-binh-luan');
    // end binh-luan

    // lien-he
    Route::get('/lien-he.html', [TinNhanController::class, 'chat'])->name('web.lien-he');
    Route::get('Kiem-Tra-Cuoc-Tro-Chuyen-User.html', [CuocTroChuyenController::class, 'CheckConversationUser'])->name('kiem-tra-cuoc-tro-chuyen-user');

    // end lien-he



});