 <div class="card">
                                        <div class="card-header">
                                            <h5 class="mb-0">Đơn hàng</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th>Mã Đơn hàng</th>
                                                            <th>Ngày Đặt</th>
                                                            <th>Sản Phẩm</th>
                                                            <th>Thanh Toán</th>
                                                            <th>Trạng thái</th>

                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($lichsumuahang as $item)
                                                          <tr>

                                                        <td>{{ $item->ma_hoa_don }}</td>
                                                       <td>{{ \Carbon\Carbon::parse($item->thoi_gian)->format('d/m/Y H:i') }}</td>
                                                        <td>@foreach ( $item->chiTietSanPham as $itemDetail )
                                                          <span><a href="{{ route('web.chi-tiet-san-pham',$itemDetail->id_san_pham) }}"> {{ $itemDetail->ten_san_pham }}</a></span><br>
                                                        @endforeach
                                                        </td>
                                                        <td>
                                                            @if ($item->phuong_thuc_thanh_toan == 1)
                                                            Đã thanh toán
                                                            @else
                                                            Khi nhận hàng
                                                            @endif
                                                        </td>

                                                        <td>
                                                            @if($item->trang_thai_don_hang == 1)
                                                                Chờ xử lý
                                                            @elseif($item->trang_thai_don_hang == 2)
                                                                Tiếp nhận
                                                            @elseif($item->trang_thai_don_hang == 3)
                                                                Đang giao hàng
                                                            @elseif($item->trang_thai_don_hang == 4)
                                                                Đã giao hàng
                                                            @elseif($item->trang_thai_don_hang == 5)
                                                                Đã hủy
                                                            @else
                                                                Không xác định
                                                            @endif
                                                        </td>

                                                          </tr>

                                                        @endforeach

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
