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
                            <div id="bookTypeHelp" class="form-text"></div>
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
                            <div id="statusHelp" class="form-text"></div>
                        </div>

                        <!-- Nút Thêm -->
                        <div class="mt-4 col-md-4 col-12">
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
