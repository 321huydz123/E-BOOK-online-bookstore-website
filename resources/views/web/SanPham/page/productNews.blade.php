 <div class="sidebar-widget product-sidebar mb-30 p-30 bg-grey border-radius-10">
                        <div class="widget-header position-relative mb-20 pb-10">
                            <h5 class="widget-title mb-10">Sản phẩm mới</h5>
                            <div class="bt-1 border-color-1"></div>
                        </div>
                        @php
                        $count_one = 0;
                        @endphp
                        @foreach ($sanphammoi as $item)
                            @php
                            $count_one++;
                            @endphp
                            <div class="single-post clearfix">
                                <div class="image">
                                    <img src="{{ asset($item->hinhAnh->hinh_anh) }}" alt="#">
                                </div>
                                <div class="content pt-10">
                                    <h5><a href="{{ route('web.chi-tiet-san-pham',$item->id) }}">{{ $item->ten_san_pham }}</a></h5>
                                    <p class="price mb-0 mt-5">{{ number_format($item->gia_ban, 0, ',', ',') }} VND</p>
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
                                </div>
                            </div>
                            @if ($count_one == 3)
                                @break
                            @endif
                        @endforeach
                    </div>
