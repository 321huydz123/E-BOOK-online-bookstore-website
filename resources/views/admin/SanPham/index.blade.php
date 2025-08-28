@extends('layouts.admin-layout')
@section('noidung')
<div class="row">
    <style>
        .content-scroll {
    max-height: 200px; /* Đặt chiều cao tối đa */
    overflow-y: auto; /* Cho phép cuộn theo chiều dọc */
    padding-right: 10px; /* Thêm khoảng cách bên phải nếu cần */
}

    </style>
  {{-- <div class="col-lg-12 d-flex align-items-stretch"> --}}
            <div class="card w-100">
              <div class="card-body ">
                <h5 class="card-title "> Danh Sách Sản Phẩm </h5>
                <div class="table-responsive">
                  <table class="table text-nowrap mb-0 align-middle"  id="example" style="width:100%">
                    <thead class="text-dark fs-4">
                     <tr>
                            <th>STT</th>
                            <th>Tên Sách </th>
                            <th> </th>
                            <th>Số Lượng</th>
                            <th>Trạng Thái</th>
                            <th>Giá Bán</th>
                            <th>Chi Tiết</th>
                            <th>Thao Tác </th>

                        </tr>
                    </thead>
                     <tbody>
                        @php
                            $i=1;
                        @endphp
                    @foreach ($data as $item)

                        <tr>
                            <td>{{ $i++ }}</td>
                            <td class="fw-semibold mb-1">{{ $item->ten_san_pham }}</td>
                            <td><img src="{{ asset($item->hinhAnh->hinh_anh) }}" width="100px" alt="{{ $item->ten_san_pham }}"></td>
                            <td>
                                @if($item->so_luong>0)
                                <span class="badge bg-secondary rounded-3 fw-semibold">Còn {{ $item->so_luong }} </span>
                                @else
                                <span class="badge bg-danger rounded-3 fw-semibold">Hết hàng</span>
                                @endif
                            </td>
                            <td >
                            @if ($item->trang_thai == 0)
                                       <span class="badge bg-danger rounded-3 fw-semibold"> Ngừng bán</span>

                                    @else

                                       <span class="badge bg-success rounded-3 fw-semibold"> Đang bán </span>

                                       @endif
                                    </td>
                           <td>{{ number_format($item->gia_ban, 0, ',', '.') }} VND</td>



                            </td>
                            <td>

                                <button type="button" class="btn btn-light m-1" data-bs-toggle="modal"
                                                        data-bs-target="#modal{{ $item->id }}"><i class="ti ti-eye"></i></button>
                                                        <div class="modal fade" id="modal{{ $item->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Nội dung sản phẩm </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                        aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <table class="table">
                                                                        <tbody>
                                                                            <tr data-dt-row="2" data-dt-column="2">
                                                                                <td class="col-3">Hình ảnh:</td>
                                                                                <td class="col-9">
                                                                                    <div
                                                                                        class="d-flex justify-content-start align-items-center product-name">
                                                                                        <div class="avatar-wrapper">
                                                                                            <div
                                                                                                class="d-flex flex-wrap">
                                                                                                @foreach ($item->hinhAnhs
                                                                                                as $itemIMG)
                                                                                                <div
                                                                                                    class="avatar avatar me-4 rounded-2 bg-label-secondary">
                                                                                                    <img src="{{ asset($itemIMG->hinh_anh) }}"
                                                                                                        alt="Product-3"
                                                                                                        class="rounded p-2"
                                                                                                        style="width: 60px; object-fit: cover;">
                                                                                                </div>
                                                                                                @endforeach
                                                                                            </div>
                                                                                        </div>


                                                                                    </div>

                                                                                        </div>
                                                                        </td>
                                                                    </tr>
                                                                    <tr data-dt-row="2" data-dt-column="2">
                                                                        <td class="col-3">Tên:</td>
                                                                        <td class="col-9">
                                                                            <div
                                                                                class="d-flex justify-content-start align-items-center product-name">

                                                                                <div class="d-flex flex-column">
                                                                                    <h6 class="mb-0 text-truncate-1">
                                                                                        {{ $item->ten_san_pham }}</h6>

                                                                                </div>
                                                                            </div>




                                                        </div>
                                                        </td>
                                                        </tr>
                                                         <tr data-dt-row="2" data-dt-column="3">
                                                            <td class="col-3">Mô tả:</td>
                                                            <td class="col-9">
                                                                <div class="content-scroll">
                                                                        {!! $item->mo_ta !!}
                                                                    </div>


                                                            </td>
                                                        </tr>
                                                        <tr data-dt-row="2" data-dt-column="3">
                                                            <td class="col-3">Loại sản phẩm:</td>
                                                            <td class="col-9">

                                                              <h6 class="mb-0 text-truncate-1">
                                                                                        {{ $item->loaiSanPham->ten_loai_san_pham }}</h6>
                                                            </td>
                                                        </tr>
                                                        <tr data-dt-row="2" data-dt-column="3">
                                                            <td class="col-3">Thông số :
                                                            </td>
                                                            <td class="col-9">

                                                              <h6 class="mb-0 text-truncate-1"> Số lượng : còn {{ $item->so_luong }} <br>
                                                            Số trang : {{ $item->so_trang}} <br>
                                                            Kích thước : {{ $item->kich_thuoc}} <br>
                                                            Trọng lượng : {{ $item->trong_luong }}g</h6>
                                                            </h6>
                                                            </td>
                                                        </tr>

                                                        <tr data-dt-row="2" data-dt-column="3">
                                                            <td class="col-3">
                                                                Thông tin xuất bản:</td>
                                                            <td class="col-9">

                                                              <h6 class="mb-0 text-truncate-1">Tác giả : {{ $item->tacGia->ten_tac_gia }} <br>
                                                            Nhà phát hành : {{ $item->nhaPhatHanh->ten_nha_phat_hanh }} <br>
                                                            Nhà sản xuất : {{ $item->nhaSanXuat->ten_nha_san_xuat }} <br>
                                                            </h6>
                                                            </td>
                                                        </tr>
                                                        <tr data-dt-row="2" data-dt-column="6">
                                                            <td class="col-3">Giá:</td>
                                                            <td class="col-9"><span
                                                                    class="badge text-secondary">{{ number_format($item->gia_goc, 0, ',', '.') }} VND</span>
                                                                 <span class="text-muted"> &#8594; </span>
                                                                  <span
                                                                    class=" badge bg-secondary rounded-3 fw-semibold"> {{ number_format($item->gia_ban, 0, ',', '.') }} VND</span></td>
                                                        </tr>


                                                    </div>
                                                    <tr data-dt-row="2" data-dt-column="9">
                                                        <td class="col-3">Ngày xuất bản:</td>
                                                        <td class="col-9">
                                                                <span>{{ \Carbon\Carbon::parse($item->nam_xb)->locale('vi')->isoFormat('dddd, D MMMM YYYY') }}</span>
                                                            </td>


                                                        </td>
                                                    </tr>

                                                    <tr data-dt-row="2" data-dt-column="9">
                                                        <td class="col-3">Ngày nhập:</td>
                                                        <td class="col-9">
                                                                <span>{{ \Carbon\Carbon::parse($item->ngay_nhap)->locale('vi')->isoFormat('dddd, D MMMM YYYY') }}</span>
                                                            </td>


                                                        </td>
                                                    </tr>
                                                    <tr data-dt-row="2" data-dt-column="7">
                                                        <td class="col-3">Trạng thái:</td>
                                                        <td class="col-8  rounded">
                                                            @if ($item->trang_thai == 1)
                                                            <span class="badge bg-success rounded-3 fw-semibold">Đang bán</span>
                                                            @else
                                                            <span class="badge bg-danger rounded-3 fw-semibold">Ngừng bán</span>
                                                            @endif
                                                        </td>
                                                    </tr>

                                                    </tbody>
                                                        </table>

                                                                </div>
                            </td>
                            <td>
                                <a href="{{ route('san-pham.edit',$item->id) }}" class="ms-3 mx-2"  ><i class="ti ti-edit"></i></a>
                            <a href="javascript:void(0)"
                                    onclick="confirmDelete(event,{{ $item->id }})"
                                    style="color: red;">
                                        <i class="ti ti-trash"></i>
                                    </a>
                                <form id="delete-form-{{ $item->id }}" action="{{ route('san-pham.destroy', $item->id) }}" method="POST" style="display:inline;">
                                     @csrf
                                     @method('DELETE')
                                </form>
                            </td>


                            <!-- Modal -->

                            {{-- end --}}

                        </tr>
                        @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          {{-- </div> --}}
          </div>
@endsection
