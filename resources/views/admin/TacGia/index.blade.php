@extends('layouts.admin-layout')
@section('noidung')

<!-- Begin Page Content -->


<div class="row">

              <h5 class="card-title fw-semibold mb-4">
                  @isset($dataOld)
                  Chỉnh Sửa Tác Giả: {{ $dataOld->ten_tac_gia }}
                  @else
                  Thêm Tác Giả
                  @endisset

              </h5>
              <div class="card">
               <div class="card-body">
                  <form
                        action="{{ isset($dataOld) ? route('tac-gia.update', ['id' => $dataOld->id]) : route('tac-gia.store') }}"
                        method="POST">
                        @csrf
                        @isset($dataOld)
                            @method('PUT') <!-- Sử dụng PUT cho cập nhật -->
                        @endisset
                    <div class="row">
                        <!-- Tên Loại Sách -->
                        <div class="col-md-5 col-12 mb-3">
                            <label for="bookType" class="form-label">Tên Tác Giả</label>
                            <input
                                type="text"
                                class="form-control"
                                id="bookType"
                                name="ten_tac_gia"
                                aria-describedby="bookTypeHelp"
                                @isset($dataOld)
                                value="{{ $dataOld->ten_tac_gia }}"
                                @endisset
                                >
                            @error('ten_tac_gia')
                            <div id="bookTypeHelp" class="form-text" style="color: red">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Trạng Thái -->
                        <div class="mb-3 col-md-5 col-12">
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
                        <div class="mt-4 col-md-2 col-12">
                            <button
                                style="margin-top: 6px"
                                type="submit"
                                class="btn btn-primary">
                                  @isset($dataOld)
                                  Lưu
                                  @else
                                    Thêm Tác Giả
                                    @endisset
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
                <h5 class="card-title "> Danh Sách Tác Giả </h5>
                <div class="table-responsive">
                  <table class="table text-nowrap mb-0 align-middle"  id="example" style="width:100%">
                    <thead class="text-dark fs-4">
                     <tr>
                            <th>STT</th>
                            <th>Tên tác giả</th>
                            <th>Trạng thái</th>
                            <th>Thao Tác</th>
                        </tr>
                    </thead>
                     <tbody>
                        @php
                        $i = 1;
                        @endphp
                    @foreach ($data as $item)
                        <tr>
                            <td>{{ $i++ }}</td>
                            <td  class="fw-semibold mb-1">{{ $item->ten_tac_gia }}</td>
                            <td >
                            @if ($item->trang_thai == 0)
                                       <span class="badge bg-danger rounded-3 fw-semibold">Ngừng hoạt động </span>

                                    @else

                                       <span class="badge bg-success rounded-3 fw-semibold">Hoạt động</span>

                                       @endif
                                    </td>

                            </td>
                            <td>
                                <a href="{{ route('tac-gia.edit',$item->id) }}" class="ms-3 mx-2"  ><i class="ti ti-edit"></i></a>
                            <a href="javascript:void(0)"
                                    onclick="confirmDelete(event,{{ $item->id }})"
                                    style="color: red;">
                                        <i class="ti ti-trash"></i>
                                    </a>
                                <form id="delete-form-{{ $item->id }}" action="{{ route('tac-gia.destroy', $item->id) }}" method="POST" style="display:inline;">
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
