@extends('layouts.user')

@section('noidung')

<main class="main">
    <section class="mt-50 mb-50">
        <div class="container">
            <div class="row">
                <div class="col-lg-9">
                    <div class="product-detail accordion-detail">
                        <div class="row mb-50">
                            <div class="col-md-6 col-sm-12 col-xs-12">
                                <div class="detail-gallery">
                                    <span class="zoom-icon"><i class="fi-rs-search"></i></span>
                                    <!-- MAIN SLIDES -->
                                    <div class="product-image-slider" style="overflow: hidden;">

                                        @foreach ($data->hinhAnhs as $item)
                                        <figure class="border-radius-10">
                                            <img src="{{ asset($item->hinh_anh)}}"
                                                style="width: 100%;height: 100%;object-fit: cover;" alt="product image">
                                        </figure>
                                        @endforeach
                                    </div>
                                    <!-- THUMBNAILS -->
                                    <div class="slider-nav-thumbnails pl-15 pr-15">
                                        @foreach ($data->hinhAnhs as $item)
                                        <div><img src="{{asset($item->hinh_anh)}}"
                                                alt="product image"></div>
                                        @endforeach
                                    </div>
                                </div>
                                <!-- End Gallery -->
                                <div class="social-icons single-share">
                                    <ul class="text-grey-5 d-inline-block">
                                        <li><strong class="mr-10">Share this:</strong></li>
                                        <li class="social-facebook"><a href="#"><img
                                                    src="{{ asset('assets/imgs/theme/icons/icon-facebook.svg')}}" alt=""></a></li>
                                        <li class="social-twitter"> <a href="#"><img
                                                    src="{{ asset('assets/imgs/theme/icons/icon-twitter.svg')}}" alt=""></a></li>
                                        <li class="social-instagram"><a href="#"><img
                                                    src="{{ asset('assets/imgs/theme/icons/icon-instagram.svg')}}" alt=""></a></li>
                                        <li class="social-linkedin"><a href="#"><img
                                                    src="{{ asset('assets/imgs/theme/icons/icon-pinterest.svg')}}" alt=""></a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12 col-xs-12">


                                <div class="detail-info">
                                    <h2 class="title-detail">{{ $data->ten_san_pham }}</h2>

                                    <div class="clearfix product-price-cover">
                                        <div class="product-price primary-color float-left">
                                            <ins><span
                                                    class="text-brand">{{  number_format($data->gia_ban, 0, ',', ',') }}
                                                    VND</span></ins>
                                            <ins><span
                                                    class="old-price font-md ml-15">{{ number_format($data->gia_goc, 0, ',', ',')  }}
                                                    VND</span></ins>
                                            <span
                                                class="save-price  font-md color3 ml-15">{{ $data->gia_goc != 0 ? round(($data->gia_ban / $data->gia_goc) * 100, 2) . '%' : 'N/A' }}

                                                Off</span>
                                        </div>
                                    </div>
                                    <div class="bt-1 border-color-1 mt-15 mb-15"></div>
                                    <div class="short-desc mb-30">
                                      {!! $data->mo_ta !!}
                                    </div>
                                    <div class="product_sort_info font-xs mb-30">
                                        <ul>
                                            <li class="mb-10"><i class="fi-rs-crown mr-5"></i> Giao hàng nhanh </li>
                                            <li class="mb-10"><i class="fi-rs-refresh mr-5"></i>Đổi trả hàng khi có lỗi
                                                từ nhà sản xuất</li>
                                            <li><i class="fi-rs-credit-card mr-5"></i> Phục vụ hỗ trợ 24/24
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="bt-1 border-color-1 mt-30 mb-30"></div>
                                    {{-- <form action="" method="post"> --}}
                                      <div class="detail-extralink">
                                            <div class="detail-qty border radius" style="width: 10%;">
                                                <input type="number" id="quantity-{{ $data->id }}" min="1" max="{{ $data->so_luong }}" value="1">
                                                <input type="hidden" id="product-id-{{ $data->id }}" value="{{ $data->id }}">
                                            </div>
                                            <div class="product-extra-link2">
                                                <button class="button button-add-to-cart" onclick="muaHangg({{ $data->id }})">Mua ngay</button>
                                                <a aria-label="Add To Cart" class="action-btn hover-up" onclick="addToCartt({{ $data->id }})">
                                                    <i class="fi-rs-shopping-bag-add"></i>
                                                </a>
                                            </div>
                                        </div>

                                    {{-- </form> --}}

                                </div>
                                <!-- Detail Info -->
                            </div>
                        </div>
                        <div class="tab-style3">
                            <ul class="nav nav-tabs text-uppercase">
                                <li class="nav-item">
                                    <a class="nav-link active" id="Description-tab" data-bs-toggle="tab"
                                        href="#Description">CHI TIẾT</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="Reviews-tab" data-bs-toggle="tab" href="#Reviews">BÌNH
                                        LUẬN</a>
                                </li>
                            </ul>
                            <div class="tab-content shop_info_tab entry-main-content">
                                <div class="tab-pane fade show active" id="Description">
                                    <table class="font-md">
                                        <tbody>

                                            <tr class="stand-up">
                                                <th>Số lượng sách</th>
                                                <td>
                                                    <p>{{ $data->so_luong }}</p>
                                                </td>
                                            </tr>
                                            <tr class="stand-up">
                                                <th>Tác giả</th>
                                                <td>
                                                    <p>{{ $data->tacGia->ten_tac_gia }}</p>
                                                </td>
                                            </tr>
                                            <tr class="stand-up">
                                                <th>Năm xuất bản</th>
                                                <td>
                                                    <p>{{ $data->nam_xb }}</p>
                                                </td>
                                            </tr>
                                            <tr class="stand-up">
                                                <th>Thể loại</th>
                                                <td>
                                                    <p>{{ $data->loaiSanPham->ten_loai_san_pham }}</p>
                                                </td>
                                            </tr>
                                            <tr class="stand-up">
                                                <th>Nhà sản xuất </th>
                                                <td>
                                                    <p>{{ $data->nhaSanXuat->ten_nha_san_xuat }}</p>
                                                </td>
                                            </tr>
                                            <tr class="stand-up">
                                                <th>Nhà phát hành</th>
                                                <td>
                                                    <p>{{ $data->nhaPhatHanh->ten_nha_phat_hanh }}</p>
                                                </td>
                                            </tr>
                                            <tr class="stand-up">
                                                <th>Trọng lượng(g)</th>
                                                <td>
                                                    <p>{{ $data->trong_luong }}</p>
                                                </td>
                                            </tr>
                                            <tr class="stand-up">
                                                <th>Kích thước  </th>
                                                <td>

                                                    <p>{{ $data->kich_thuoc }}</p>
                                                </td>
                                            </tr>
                                            <tr class="stand-up">
                                                <th>Số trang</th>
                                                <td>
                                                    <p>{{ $data->so_trang }}</p>
                                                </td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </div>
                                @include('web.SanPham.page.comments')
                                    {{--  Chỗ Của Cmt --}}
                            </div>
                        </div>
                            {{--  chỗ sản phẩm liên quan  --}}
                    </div>
                </div>
              {{--  chỗ bộ truyện --}}
            </div>
        </div>
    </section>
</main>



@endsection
