@extends('layouts.user')

@section('noidung')
<style>
.text-color-sl{
  color: rgb(242, 147, 79);
}

</style>
<main class="main">
    <section class="mt-50 mb-50">
        <div class="container">
            <div class="row">
                <div class="col-lg-9">
                    {{-- <div class="row product-grid-3"> --}}
                    @if($sanphams == null)


                        <p>Không tìm thấy sản phẩm nào .</p>


                    @else
                    <div class="row product-grid-3">
                    @foreach ($sanphams as $item)


                            <div class="col-lg-4 col-md-4 col-6 col-sm-6">
                                <div class="product-cart-wrap mb-30" style="max-width: 400px ;">
                                    <div class="product-img-action-wrap">
                                        <div class="product-img product-img-zoom" style="min-height: 300px; max-height:300px ; overflow: hidden;">
                                            <a href="{{ route('web.chi-tiet-san-pham',$item->id) }}" >
                                                <img class="default-img" src="{{ asset($item->hinhAnh->hinh_anh) }}" style="margin: auto;min-height:  300px;" alt="loi">
                                                <img class="hover-img" src="{{ asset($item->hinhAnh->hinh_anh) }}" style="margin: auto;min-height:  300px;" alt="loi">
                                            </a>
                                        </div>
                                    </div>
                                    <div class="product-content-wrap" id="productInfo">
                                        <h2><a href="{{ route('web.chi-tiet-san-pham',$item->id) }}" >{{ $item->ten_san_pham }}</a></h2>
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
                                        <div class="product-action-1 show">
                                            @auth
                                                <input style="display:none" type="number" id="quantity-{{ $item->id}}" min="1" max="{{ $item->so_luong }}" value="1">
                                                <button aria-label="Thêm vào giỏ hàng" onclick="addToCartt({{ $item->id }})" class="action-btn hover-up"><i class="fi-rs-shopping-bag-add"></i></button>
                                            @else
                                                <a aria-label="Thêm vào giỏ hàng" id="add_card" href="{{ route('login') }}" class="action-btn hover-up"><i class="fi-rs-shopping-bag-add"></i></a>
                                            @endauth
                                        </div>
                                    </div>
                                </div>
                            </div>

                        @endforeach



                    </div>

                    <!-- Pagination -->
                  <div class="pagination-area mt-15 mb-sm-5 mb-lg-0">
                        <nav aria-label="Page navigation example">
                            <ul class="pagination justify-content-start">
                                {{ $sanphams->links() }}
                            </ul>
                        </nav>
                    </div>
                    @endif
                </div>
                {{-- </div> --}}

                <div class="col-lg-3 primary-sidebar sticky-sidebar">
                    <div class="row">
                        <div class="col-lg-12 col-mg-6"></div>
                        <div class="col-lg-12 col-mg-6"></div>
                    </div>
                    <div class="widget-category mb-30">
                        <h5 class="section-title style-1 mb-30 wow fadeIn animated">Danh mục</h5>
                       <ul class="categories">
                            @foreach ($danhmucs as $item)
                                <li>
                                    <a href="{{ route('web.san-pham-theo-danh-muc', $item->id) }}"
                                    style="{{ isset($danhmuc_selected) && $danhmuc_selected->id == $item->id ? 'color: rgb(242, 147, 79);' : '' }}">
                                        {{ $item->ten_loai_san_pham }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>

                    </div>

                    <!-- Product sidebar Widget -->
                    @include('web.SanPham.page.productNews')
                </div>
            </div>
        </div>
    </section>
</main>
@endsection
