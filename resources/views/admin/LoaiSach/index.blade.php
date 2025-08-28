@extends('layouts.admin-layout')
@section('noidung')

<!-- Begin Page Content -->
<div class="row">

              <h5 class="card-title fw-semibold mb-4">
                  @isset($dataOld)
                  Chỉnh Sửa Loại Sản Phẩm: {{ $dataOld->ten_loai_san_pham }}
                  @else
                  Thêm Loại Sản Phẩm
                  @endisset

              </h5>
              <div class="card">
               <div class="card-body">
                  <form
                        action="{{ isset($dataOld) ? route('loai-san-pham.update', ['id' => $dataOld->id]) : route('loai-san-pham.store') }}"
                        method="POST">
                        @csrf
                        @isset($dataOld)
                            @method('PUT') <!-- Sử dụng PUT cho cập nhật -->
                        @endisset
                    <div class="row">
                        <!-- Tên Loại Sách -->
                        <div class="col-md-4 col-12 mb-3">
                            <label for="bookType" class="form-label">Tên Loại Sách</label>
                            <input
                                type="text"
                                class="form-control"
                                id="bookType"
                                name="ten_loai_san_pham"
                                aria-describedby="bookTypeHelp"
                                @isset($dataOld)
                                value="{{ $dataOld->ten_loai_san_pham }}"
                                @endisset
                                >
                            @error('ten_loai_san_pham')
                            <div id="bookTypeHelp" class="form-text" style="color: red">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Trạng Thái -->
                        <div class="mb-3 col-md-4 col-12">
                            <label for="status" class="form-label">Trạng Thái</label>
                            <select
                                class="form-control"
                                id="status"
                                name="trang_thai">
                                <option value="1"
                                @isset($dataOld)

                                {{ $dataOld->trang_thai == 1 ? 'selected' : '' }}
                                @endisset
                                >Hoạt Động</option>
                                <option value="0"
                                @isset($dataOld)
                                {{ $dataOld->trang_thai == 0 ? 'selected' : '' }}
                                @endisset
                                >Không Hoạt Động</option>
                            </select>
                             @error('trang_thai')
                            <div id="bookTypeHelp" class="form-text" style="color: red">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Nút Thêm -->
                        <div class="mt-4 col-md-4 col-12">
                        @if(session('alert'))
                        <div class="alert alert-{{ session('alert.type') }} alert-dismissible fade show d-flex align-items-center" role="alert">
                            @if(session('alert.type') === 'danger')
                                <i class="fas fa-times-circle me-2"></i>
                            @elseif(session('alert.type') === 'success')
                                <i class="fas fa-check-circle me-2"></i>
                            @endif
                            <div>{{ session('alert.message') }}</div>
                            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        @endif
                            <button
                                style="margin-top: 6px"
                                type="submit"
                                class="btn btn-primary">Thêm
                            </button>
                        </div>
                    </div>
                </form>
            </div>

                </div>





</div>
<div class="row">
  {{-- <div class="col-lg-12 d-flex align-items-stretch"> --}}
            <div class="card w-100">
              <div class="card-body ">
                <h5 class="card-title "> Loại Sách </h5>
                <div class="table-responsive">
                  <table class="table text-nowrap mb-0 align-middle"  id="example" style="width:100%">
                    <thead class="text-dark fs-4">
                     <tr>
                            <th>Mã Sách</th>
                            <th>Tên loại truyện</th>
                            <th>Số lượng</th>
                            <th>Trạng thái</th>
                            <th>Thao Tác</th>
                        </tr>
                    </thead>
                     <tbody>
                    @foreach ($data as $item)
                        <tr>
                            <td>L-S-{{ $item -> id }}</td>
                            <td  class="fw-semibold mb-1">{{ $item->ten_loai_san_pham }}</td>
                            <td>{{ $item->san_pham_count }}</td>
                            <td >
                            @if ($item->trang_thai == 0)
                                       <span class="badge bg-danger rounded-3 fw-semibold">Không còn lưu trữ</span>

                                    @else

                                       <span class="badge bg-success rounded-3 fw-semibold"> Còn tồn tại</span>

                                       @endif
                                    </td>

                            </td>
                            <td>
                                <a href="{{ route('loai-san-pham.edit',$item->id) }}" class="ms-3 mx-2"  ><i class="ti ti-edit"></i></a>
                            <a href="javascript:void(0)"
                                    onclick="confirmDelete(event, {{ $item->id }})"
                                    style="color: red;">
                                        <i class="ti ti-trash"></i>
                                    </a>
                                <form id="delete-form-{{ $item->id }}" action="{{ route('loai-san-pham.destroy', $item->id) }}" method="POST" style="display:inline;">
                                     @csrf
                                     @method('DELETE')
                                </form>
                            </td>

                        </tr>
                        @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          {{-- </div> --}}
          </div>
<!-- /.container-fluid -->


@endsection
