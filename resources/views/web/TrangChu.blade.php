@extends('layouts.user')
@section('noidung')
<main class="main" style="background-color: #fff;">
    <section class="featured section-padding position-relative">
        <div class="container">
            <div class="row">
                <div class="col-lg-2 col-md-4 mb-md-3 mb-lg-0">
                    <div class="banner-features wow fadeIn animated hover-up">
                        <img src="assets/imgs/theme/icons/feature-1.png" alt="">
                        <h4 class="bg-1">Miễn phí vận chuyển</h4>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 mb-md-3 mb-lg-0">
                    <div class="banner-features wow fadeIn animated hover-up">
                        <img src="assets/imgs/theme/icons/feature-2.png" alt="">
                        <h4 class="bg-3">Đặt hàng trực tuyến</h4>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 mb-md-3 mb-lg-0">
                    <div class="banner-features wow fadeIn animated hover-up">
                        <img src="assets/imgs/theme/icons/feature-3.png" alt="">
                        <h4 class="bg-2">Tiết kiệm tiền</h4>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 mb-md-3 mb-lg-0">
                    <div class="banner-features wow fadeIn animated hover-up">
                        <img src="assets/imgs/theme/icons/feature-4.png" alt="">
                        <h4 class="bg-4">Khuyến mãi</h4>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 mb-md-3 mb-lg-0">
                    <div class="banner-features wow fadeIn animated hover-up">
                        <img src="assets/imgs/theme/icons/feature-5.png" alt="">
                        <h4 class="bg-5">Bán vui vẻ</h4>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 mb-md-3 mb-lg-0">
                    <div class="banner-features wow fadeIn animated hover-up">
                        <img src="assets/imgs/theme/icons/feature-6.png" alt="">
                        <h4 class="bg-6">Hỗ trợ 24/7</h4>
                    </div>
                </div>
            </div>
        </div>
    </section>
   <section class="product-tabs section-padding position-relative wow fadeIn animated">
        <div class="bg-square"></div>
        <div class="container">
            <!-- danh muc -->
            <div class="tab-header">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    @foreach ($danhmucs as $item)
                        <li class="nav-item" role="presentation">
                            <button class="nav-link {{ $item->id == 0 ? 'active' : '' }}"
                                    id="nav-tab-{{ $item->id }}"
                                    data-bs-toggle="tab"
                                    data-bs-target="#tab-{{ $item->id }}"
                                    type="button" role="tab" aria-controls="tab-{{ $item->id }}"
                                    aria-selected="true">{{ $item->ten_loai_san_pham }}</button>
                        </li>
                    @endforeach
                </ul>
                <a href="" class="view-more d-none d-md-flex">Xem thêm<i class="fi-rs-angle-double-small-right"></i></a>
            </div>

            <div class="tab-content wow fadeIn animated" id="myTabContent">
                @foreach ($danhmucs as $item)
                    <div class="tab-pane fade {{ $item->id == 0 ? 'show active' : '' }}" id="tab-{{ $item->id }}" role="tabpanel" aria-labelledby="tab-{{ $item->id }}">
                        <div class="row product-grid-4">
                            @foreach ($sanphams->where('id_loai_san_pham', $item->id)->take(8) as $item1)
                                <div class="col-lg-3 col-md-4 col-sm-6 col-xs-6 col-6">
                                    <div class="product-cart-wrap mb-30">
                                        <div class="product-img-action-wrap">
                                            <div class="product-img product-img-zoom" style="min-height: 300px; max-height:300px ; overflow: hidden;">
                                                <a href="{{ route('web.chi-tiet-san-pham', $item1->id) }}" >
                                                    <img class="default-img" src="{{ asset($item1->hinhAnh->hinh_anh) }}" style="margin: auto;min-height:  300px;" alt="loi">
                                                    <img class="hover-img" src="{{ asset($item1->hinhAnh->hinh_anh) }}" style="margin: auto;min-height:  300px;" alt="loi">
                                                </a>
                                            </div>
                                        </div>
                                        <div class="product-content-wrap" id="productInfo">
                                            <h2><a href="{{ route('web.chi-tiet-san-pham', $item1->id) }}">{{ $item1->ten_san_pham }}</a></h2>
                                            <div title="{{ $item1->averageRating }} sao">
                                                @php
                                                    // averageRating đã là số sao từ 1 đến 5
                                                    $ratingStars = round($item1->averageRating);
                                                @endphp
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <i class="fi-rs-star {{ $i <= $ratingStars ? 'text-warning' : 'text-muted' }}"></i>
                                                @endfor
                                                <span>({{ $item1->averageRating }}/5)</span>
                                            </div>
                                            <div class="product-price">
                                                <span>{{ number_format($item1->gia_ban, 0, ',', ',') }} VND</span>
                                                <span class="old-price">{{ number_format($item1->gia_goc, 0, ',', ',') }} VND</span>
                                            </div>
                                            <div class="product-action-1 show">
                                                {{-- @auth
                                                    <button aria-label="Add To Cart" id="add_card" onclick="addToCart({{ $item1->id_san_pham }})" class="action-btn hover-up"><i class="fi-rs-shopping-bag-add"></i></button>
                                                @else
                                                    <a aria-label="Add To Cart" id="add_card" href="{{ route('dangNhap') }}" class="action-btn hover-up"><i class="fi-rs-shopping-bag-add"></i></a>
                                                @endauth --}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
   <section class="section-padding">
    <div class="container wow fadeIn animated">
        <h3 class="section-title mb-20"><span>Sản phẩm mới</span></h3>
        <div class="carausel-6-columns-cover position-relative">
            <div class="slider-arrow slider-arrow-2 carausel-6-columns-arrow" id="carausel-6-columns-2-arrows"></div>
            <div class="carausel-6-columns carausel-arrow-center" id="carausel-6-columns-2">
                @foreach ($sanphammoi as $item)
                    <div class="product-cart-wrap small hover-up">
                        <div class="product-img-action-wrap">
                            <div class="product-img product-img-zoom"
                                style="position: relative; width: 100%; height: 0;padding-bottom: 120%;overflow: hidden;">
                                <a href="{{ route('web.chi-tiet-san-pham', $item->id) }}">
                                    <img class="default-img" src="{{ asset($item->hinhAnh->hinh_anh) }}"
                                        width="100%" alt=""
                                        style="position: absolute;top: 0;left: 0;width: 100%;height: 100%; object-fit: cover;">
                                    <img class="hover-img" src="{{ asset($item->hinhAnh->hinh_anh) }}"
                                        width="100%" alt=""
                                        style="position: absolute;top: 0;left: 0;width: 100%;height: 100%; object-fit: cover;">
                                </a>
                            </div>
                            @auth

                            <div class="product-action-1">
                                <input style="display:none" type="number" id="quantity-{{ $item->id}}" min="1" max="{{ $item->so_luong }}" value="1">
                                <a aria-label="Thêm vào giỏ hàng" onclick="addToCartt({{ $item->id }})" class="action-btn small hover-up"  tabindex="0"> <i class="fi-rs-shopping-bag-add"></i></a>
                                <a aria-label="Mua ngay" onclick="muaHangg({{ $item->id }})"  class="action-btn small hover-up"
                                    tabindex="0"><i class="fi-rs-shuffle"></i></a>
                            </div>

                            @endauth

                        </div>
                        <div class="product-content-wrap">
                            <h2><a href="{{ route('web.chi-tiet-san-pham', $item->id) }}"> {{ $item->ten_san_pham }}</a></h2>
                            <div title="{{ $item->averageRating }} sao">
                                @php
                                    // averageRating đã là số sao từ 1 đến 5
                                    $ratingStars = round($item->averageRating);
                                @endphp
                                @for ($i = 1; $i <= 5; $i++)
                                    <i class="fi-rs-star {{ $i <= $ratingStars ? 'text-warning' : 'text-muted' }}"></i>
                                @endfor
                                <span>({{ $item->averageRating }}/5)</span>
                            </div>

                            <div class="product-price">
                                <span>{{ number_format($item->gia_ban, 0, ',', ',') }} VND</span>
                                <span class="old-price">{{ number_format($item->gia_goc, 0, ',', ',') }} VND</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

    <section class="section-padding">
        <div class="container">
            <h3 class="section-title mb-20 wow fadeIn animated"><span>Nhà xuất bản</span></h3>
            <div class="carausel-6-columns-cover position-relative wow fadeIn animated">
                <div class="slider-arrow slider-arrow-2 carausel-6-columns-arrow" id="carausel-6-columns-3-arrows">
                </div>
                <div class="carausel-6-columns text-center" id="carausel-6-columns-3">
                    <div class="brand-logo">
                        <img class="img-grey-hover" src="{{ asset('assets/imgs/banner/brand-1.png')}}')}}" alt="">
                    </div>
                    <div class="brand-logo">
                        <img class="img-grey-hover" src="{{ asset('assets/imgs/banner/brand-2.png')}}" alt="">
                    </div>
                    <div class="brand-logo">
                        <img class="img-grey-hover" src="{{ asset('assets/imgs/banner/brand-3.png')}}" alt="">
                    </div>
                    <div class="brand-logo">
                        <img class="img-grey-hover" src="{{ asset('assets/imgs/banner/brand-4.png')}}" alt="">
                    </div>
                    <div class="brand-logo">
                        <img class="img-grey-hover" src="{{ asset('assets/imgs/banner/brand-5.png')}}" alt="">
                    </div>
                    <div class="brand-logo">
                        <img class="img-grey-hover" src="{{ asset('assets/imgs/banner/brand-6.png')}}" alt="">
                    </div>
                    <div class="brand-logo">
                        <img class="img-grey-hover" src="{{ asset('assets/imgs/banner/brand-3.png')}}" alt="">
                    </div>
                    <div class="brand-logo">
                        <img class="img-grey-hover" src="{{ asset('assets/imgs/banner/download (4).jpg')}}" alt="">
                    </div>
            </div>
        </div>
    </section>

</main>
@endsection
