@extends('layouts.admin-layout')
@section('noidung')
{{-- <div class="row"> --}}
  {{-- <div class="col-lg-12 d-flex align-items-stretch"> --}}
            <div class="card w-100">
              <div class="card-body ">
                <h5 class="card-title "> Đơn hàng </h5>
                <div class="table-responsive">
                  <table class="table text-nowrap mb-0 align-middle"  id="example" style="width:100%">
                    <thead class="text-dark fs-4">
                     <tr>
                            <th>STT</th>
                            <th> Mã hóa đơn </th>
                            <th> Đơn giá </th>
                            <th> Số điện thoại/Ghi chú </th>
                            <th>Xem</th>
                            <th>Trạng thái</th>
                        </tr>
                    </thead>
                     <tbody>
                        @php
                            $i=1;
                        @endphp
                        @foreach ($donhangs as $item )


                        <tr>
                            <td>{{ $i++ }}</td>
                            <td>

                              <div>
                                <h6 class="fw-semibold  mb-1"><a class="text-dark" href="{{ route('don-hang.hoa-don',$item->id) }}">{{ $item->ma_hoa_don }}</a></h6>
                                @if($item->phuong_thuc_thanh_toan == 1)
                                 <span class="badge fw-semibold py-1 w-85 bg-success-subtle text-success">Thanh toán trực tuyến </span>
                                 @else
                                 <span class="badge bg-primary rounded-3 fw-semibold">Thanh toán khi nhận hàng</span>

                                 @endif

                              </div>
                            </td>
                            <td>{{ number_format($item->tong_tien, 0, ',', '.') }} VND</td>
                            <td>
                               {{ $item->sdt }}/{{ $item->ghi_chu }}

                            </td>
                            <td>


                                <button type="button" class="btn btn-light m-1" data-bs-toggle="modal" data-bs-target="#exampleModal{{ $item->id }}"><i class="ti ti-eye"></i></button>
                                <div class="modal fade" id="exampleModal{{ $item->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                    <div class="modal-header  ">
                                        <h5 class="modal-title" id="exampleModalLabel">{{ $item->ma_hoa_don }}
                                @if($item->phuong_thuc_thanh_toan == 1)
                                 <span class="badge fw-semibold py-1 w-85 bg-success-subtle text-success">Thanh toán trực tuyến </span>
                                 @else
                                 <span class="badge bg-primary rounded-3 fw-semibold">Thanh toán khi nhận hàng</span>
                                 @endif
                                </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="position-relative">
                                            <div class="d-flex align-items-center justify-content-between mb-7">
                                            <div class="d-flex">
                                                <div class="p-6 bg-primary-subtle rounded me-6 d-flex align-items-center justify-content-center">
                                                <i class="ti ti-grid-dots text-primary fs-6"></i>
                                                </div>
                                                <div>
                                                <h6 class="mb-1 fs-4 fw-semibold"> Họ tên: {{ $item->user->ten }}</h6>
                                                <p class="fs-3 mb-0">Liên lạc: {{ $item->sdt }}</p>
                                                </div>
                                            </div>
                                            <div class="bg-primary-subtle badge">
                                                <p class="fs-3 text-primary fw-semibold mb-0">{{ $item->dia_chi }}</p>
                                            </div>
                                            </div>

                                            <div class="d-flex align-items-center justify-content-between mb-7">
                                                <div class="d-flex">
                                                    <div class="p-6 bg-success-subtle rounded me-6 d-flex align-items-center justify-content-center">
                                                    <i class="ti ti-grid-dots text-success fs-6"></i>
                                                    </div>
                                                    <div>
                                                    <h6 class="mb-1 fs-4 fw-semibold"> Tổng tiền : {{ number_format( $item->tong_tien, 0, ',', ',') }}VND</h6>
                                                    <p class="fs-3 mb-0">{{ $item->thoi_gian }}</p>
                                                    </div>
                                                </div>
                                                <div class="bg-success-subtle badge">
                                                    <p class="fs-3 text-success fw-semibold mb-0">{{ $item->ghi_chu }}</p>
                                                </div>
                                                </div>


                                        </div>
                                        <div class="accordion accordion-flush mb-5 card position-relative overflow-hidden" id="accordionFlushExample">
                                           @foreach ($item->chiTietSanPham as $sanphamct )
                                            <div class="accordion-item">
                                            <h2 class="accordion-header" id="flush-heading{{ $sanphamct->id }}">
                                                <button class="accordion-button fs-4 fw-semibold shadow-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse{{ $sanphamct->id }}" aria-expanded="false" aria-controls="flush-collapse{{ $sanphamct->id }}">
                                                    <div class="me-2 pe-1">
                                                        <img src="{{ asset($sanphamct->sanPham->hinhAnh->hinh_anh) }}" class="rounded-2" width="48" height="48" alt="modernize-img">
                                                    </div>
                                                {{ $sanphamct->ten_san_pham }}
                                                </button>
                                            </h2>
                                            <div id="flush-collapse{{ $sanphamct->id }}" class="accordion-collapse collapse" aria-labelledby="flush-heading{{ $sanphamct->id }}" data-bs-parent="#accordionFlushExample" style="">
                                                <div class="accordion-body fw-normal">
                                               <div class="position-relative">
                                                    <div class="d-flex align-items-center justify-content-between mb-4">
                                                    <div class="d-flex">
                                                        <div>
                                                        <h6 class="mb-1 fs-4 fw-semibold"> {{ $sanphamct->ten_san_pham }} {{ number_format($sanphamct->sanPham->gia_ban, 0, ',', ',') }} VND</h6>
                                                        <p class="fs-3 mb-0">x {{ $sanphamct->so_luong }}</p>
                                                        </div>
                                                    </div>
                                                    <h6 class="mb-0 fw-semibold">{{ number_format( $sanphamct->sanPham->gia_ban *  $sanphamct->so_luong, 0, ',', ',') }} VND</h6>
                                                    </div>
                                                     </div>
                                                </div>
                                            </div>
                                            @endforeach

                                            </div>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                                </div>

                            </td>
                            <td class="d-flex align-items-center" data-id="{{ $item->id }}">
                                @if ($item->trang_thai_don_hang == 1)
                                    <span class="btn px-4 fs-4 bg-secondary-subtle text-secondary fw-medium">Chờ</span>
                                @elseif ($item->trang_thai_don_hang == 2)
                                    <span class="btn px-4 fs-4 bg-warning-subtle text-warning fw-medium">Tiếp nhận</span>
                                @elseif ($item->trang_thai_don_hang == 3)
                                    <span class="btn px-4 fs-4 bg-info-subtle text-info fw-medium">Đang giao hàng</span>
                                @elseif ($item->trang_thai_don_hang == 4)
                                    <span class="btn px-4 fs-4 bg-success-subtle text-success fw-medium">Đã giao hàng</span>
                                @elseif ($item->trang_thai_don_hang == 5)
                                    <span class="btn px-4 fs-4 bg-danger-subtle text-danger fw-medium">Hủy</span>
                                @endif

                                <div class="ms-2">
                                    <div class="dropdown dropstart">
                                        <a href="javascript:void(0)" class="link text-dark" id="new" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="ti ti-dots fs-7"></i>
                                        </a>
                                        <ul class="dropdown-menu" aria-labelledby="new">
                                            <li><a class="dropdown-item" href="javascript:void(0)">Chờ</a></li>
                                            <li><a class="dropdown-item" href="javascript:void(0)">Tiếp nhận</a></li>
                                            <li><a class="dropdown-item" href="javascript:void(0)">Đang giao hàng</a></li>
                                            <li><a class="dropdown-item" href="javascript:void(0)">Đã giao hàng</a></li>
                                            <li><a class="dropdown-item" href="javascript:void(0)">Hủy</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </td>

                        </tr>
                        @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
           <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

            <script>
                $(document).on('click', '.dropdown-item', function () {
                    let trangThaiMoi = $(this).text().trim(); // Lấy tên trạng thái mới
                    let idDonHang = $(this).closest('td').data('id'); // Lấy ID đơn hàng
                    let trangThaiMapping = {
                        'Chờ': 1,
                        'Tiếp nhận': 2,
                        'Đang giao hàng': 3,
                        'Đã giao hàng': 4,
                        'Hủy': 5,
                    };

                    if (!idDonHang || !trangThaiMapping[trangThaiMoi]) {
                        alert('Thông tin không hợp lệ.');
                        return;
                    }

                    $.ajax({
                        url: "{{ route('don-hang.cap-nhat-trang-thai') }}",
                        type: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            id_don_hang: idDonHang,
                            trang_thai: trangThaiMapping[trangThaiMoi],
                        },
                        success: function (response) {
                            if (response.success) {
                                let btnClassMapping = {
                                    1: 'bg-secondary-subtle text-secondary',
                                    2: 'bg-warning-subtle text-warning',
                                    3: 'bg-info-subtle text-info',
                                    4: 'bg-success-subtle text-success',
                                    5: 'bg-danger-subtle text-danger',
                                };

                                // Cập nhật trạng thái hiển thị
                                let newButton = `<span class="btn px-4 fs-4 ${btnClassMapping[response.trang_thai]} fw-medium">${trangThaiMoi}</span>`;
                                $(`td[data-id="${idDonHang}"]`).find('.btn').replaceWith(newButton);

                                displayToast('success','Cập nhật trạng thái đơn hàng thành công !');
                            } else {
                                // alert(response.message);
                                displayToast('error',response.message);
                            }
                        },
                        error: function () {
                                displayToast('error',' Không thể thức hiện được thao tác !');

                        },
                    });
                });

            </script>



@endsection
