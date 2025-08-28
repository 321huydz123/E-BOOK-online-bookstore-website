@extends('layouts.user')
@section('noidung')
<main class="main">
    <section class="pt-150 pb-150">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 m-auto" style="width: 100%;">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="dashboard-menu">
                                <ul class="nav flex-column" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="dashboard-tab" data-bs-toggle="tab" href="#dashboard" role="tab" aria-controls="dashboard" aria-selected="false"><i class="fi-rs-shopping-bag mr-10"></i>Đơn hàng</a>
                                    </li>

                                    <li class="nav-item">
                                        <a class="nav-link" id="track-orders-tab" data-bs-toggle="tab" href="#track-orders" role="tab" aria-controls="track-orders" aria-selected="false"><i class="fi-rs-shopping-cart-check mr-10"></i>Lịch sử
                                            mua hàng</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="address-tab" data-bs-toggle="tab" href="#address" role="tab" aria-controls="address" aria-selected="true"><i class="fi-rs-marker mr-10"></i>Địa chỉ</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="account-detail-tab" data-bs-toggle="tab" href="#account-detail" role="tab" aria-controls="account-detail" aria-selected="true"><i class="fi-rs-user mr-10"></i>Thông tin</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="pass-tab" data-bs-toggle="tab" href="#pass" role="tab" aria-controls="pass" aria-selected="true"><i class="fi-rs-user mr-10"></i>Đổi mật khẩu</a>
                                    </li>

                                        {{-- <li class="nav-item">
                                            <a class="nav-link" href="index.php?controller=chuyenDoi"><i class="fi-rs-sign-out mr-10"></i>Chuyển đổi qua admin</a>
                                        </li> --}}



                                   <li class="nav-item">
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                    <a class="nav-link" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="fi-rs-sign-out mr-10"></i>Đăng xuất
                                    </a>
                                </li>

                                </ul>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="tab-content dashboard-content">
                                <div class="tab-pane fade active show" id="dashboard" role="tabpanel" aria-labelledby="dashboard-tab">
                                       @include('web.TaiKhoan.page.DonHang')
                                </div>
                                <div class="tab-pane fade" id="track-orders" role="tabpanel" aria-labelledby="track-orders-tab">
                                       @include('web.TaiKhoan.page.LichSuMuaHang')

                                </div>
                                <div class="tab-pane fade" id="address" role="tabpanel" aria-labelledby="address-tab">
                                       @include('web.TaiKhoan.page.DiaChi')


                                </div>
                                <div class="tab-pane fade" id="account-detail" role="tabpanel" aria-labelledby="account-detail-tab">
                                        {{--  thong tin --}}
                                        @include('web.TaiKhoan.page.ThongTin')
                                </div>
                                <div class="tab-pane fade" id="pass" role="tabpanel" aria-labelledby="pass-tab">
                                        {{--  thong tin --}}
                                        @include('web.TaiKhoan.page.MatKhau')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection
