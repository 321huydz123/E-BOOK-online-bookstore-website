@extends('layouts.admin-layout')
@section('noidung')
<div class="row">
  {{-- <div class="col-lg-12 d-flex align-items-stretch"> --}}
            <div class="card w-100">
              <div class="card-body ">
                <h5 class="card-title "> Danh Sách người dùng </h5>
                <div class="table-responsive">
                  <table class="table text-nowrap mb-0 align-middle"  id="example" style="width:100%">
                    <thead class="text-dark fs-4">
                     <tr>
                            <th>STT</th>
                            <th>Tên người dùng</th>
                            <th>Email</th>
                            <th>Số điện thoại</th>
                            <th>Trạng thái</th>
                            <th>Chi tiết</th>

                            <th>Thao Tác</th>
                        </tr>
                    </thead>
                     <tbody>
                        @php
                        $i = 1;
                        @endphp
                    @foreach ($users as $item)
                        <tr>
                            <td>{{ $i++ }}</td>
                            <td  >
                                <div class="d-flex align-items-center">
                          <img src="{{ asset( $item->anh ? $item->anh : 'admin/images/profile/user-1.jpg') }}" alt="avatar" class="rounded-circle" width="35">
                          <div class="ms-3">
                            <div class="user-meta-info">
                              <h6 class="user-name mb-0" data-name="{{ $item->ten}}"> {{ $item->ten}} </h6>

                            </div>
                          </div>
                        </div>
                                </td>
                            <td  >{{ $item->email}}</td>
                            <td  >{{ $item->sdt}}</td>
                            <td class="status-{{ $item->id }}">
                                    @if ($item->trang_thai == 0)
                                        <span class="badge bg-danger rounded-3 fw-semibold">Ngừng hoạt động</span>
                                    @else
                                        <span class="badge bg-success rounded-3 fw-semibold">Hoạt động</span>
                                    @endif
                                </td>
                            <td>
                                 <button type="button" class="btn btn-light m-1" data-bs-toggle="modal"
                                                        data-bs-target="#modal{{ $item->id }}"><i class="ti ti-eye"></i></button>
                                                        <div class="modal fade" id="modal{{ $item->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">Thông tin người dùng {{ $item->ten }} </h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                               <p>Tên: {{ $item->ten }}</p>
                                                               <p>Email: {{ $item->email }}</p>
                                                               <p>Số điện thoại: {{ $item->sdt }}</p>
                                                               <p>Trạng thái: @if ($item->trang_thai == 0) Ngừng hoạt động @else Hoạt động @endif</p>
                                                               <p> Đơn Hàng : {{ $item->don_hang_count }} </p>

                                                            </div>

                                                            </div>
                                                        </div>
                                                        </div>
                            </td>
                            <td>
                                @if ($item->trang_thai == 0)
                                    <button type="button" class="btn btn-info m-1 " id="status-btn-{{ $item->id }}" data-id="{{ $item->id }}" data-status="1">
                                        <i class="ti ti-lock-open"></i>
                                    </button>
                                @else
                                    <button type="button" class="btn btn-danger m-1 " id="status-btn-{{ $item->id }}" data-id="{{ $item->id }}" data-status="0">
                                        <i class="ti ti-lock"></i>
                                    </button>
                                @endif

                            </td>

                        </tr>
                        @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
            </div>

          </div>




           <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script>
$(document).ready(function () {
    $("button[id^='status-btn-']").click(function() {
        const button = $(this); // Lấy nút được click
        const id = button.data("id"); // Lấy ID của đối tượng
        const newStatus = button.data("status"); // Trạng thái mới cần cập nhật

        $.ajax({
            url: "{{ route('tai-khoan.update') }}", // Đường dẫn tới controller xử lý
            type: "POST",
            data: {
                id: id,
                status: newStatus,
                _token: $('meta[name="csrf-token"]').attr('content') // CSRF Token
            },
            success: function (response) {
                if (response.success) {
                    // Cập nhật giao diện tạm thời
                    const statusCell = button.closest('tr').find('td span.badge');

                    if (newStatus == 1) {
                        button
                            .removeClass("btn-info")
                            .addClass("btn-danger")
                            .data("status", 0)
                            .html('<i class="ti ti-lock"></i>');

                        statusCell
                            .removeClass("bg-danger")
                            .addClass("bg-success")
                            .text('Hoạt động');

                        displayToast('success', 'Người dùng đã được mở khóa!');
                    } else {
                        button
                            .removeClass("btn-danger")
                            .addClass("btn-info")
                            .data("status", 1)
                            .html('<i class="ti ti-lock-open"></i>');

                        statusCell
                            .removeClass("bg-success")
                            .addClass("bg-danger")
                            .text('Ngừng hoạt động');

                        displayToast('success', 'Thực hiện khóa người dùng thành công!');
                    }
                } else {
                    alert("Cập nhật trạng thái thất bại!");
                }
            },
            error: function () {
                alert("Có lỗi xảy ra. Vui lòng thử lại!");
            }
        });
    });
});


</script>




@endsection

