@extends('layouts.admin-layout')
@section('noidung')
<div class="row">
    <h5 class="card-title fw-semibold mb-4">Chỉnh Sửa Sách</h5>
    <div class="card">
        <div class="card-body">
            <form action="{{ route('san-pham.update', $data->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    <!-- Tên Sách -->
                    <div class="col-md-6 col-12 mb-3">
                        <label for="bookType" class="form-label">Tên Sách</label>
                        <input type="text" class="form-control" id="bookType" name="ten_san_pham" value="{{ old('ten_san_pham', $data->ten_san_pham) }}">
                        @error('ten_san_pham')
                            <div id="bookTypeHelp" class="form-text" style="color: red">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Danh Mục -->
                    <div class="mb-3 col-md-6 col-12">
                        <label for="status" class="form-label">Danh Mục</label>
                        <select class="form-control" id="status" name="id_loai_san_pham">
                            @foreach($loaiSanPham as $item)
                                <option value="{{ $item->id }}" {{ $data->id_loai_san_pham == $item->id ? 'selected' : '' }}>{{ $item->ten_loai_san_pham }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Mô Tả -->
                    <div class="col-md-12 col-12 mb-3">
                        <label class="form-label">Mô Tả</label>
                        <textarea name="mo_ta" id="editor" rows="5" class="form-control">{{ old('mo_ta', $data->mo_ta) }}</textarea>
                        @error('mo_ta')
                            <div id="bookTypeHelp" class="form-text" style="color: red">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                    <!-- Cột Upload Ảnh -->
                    <div id="uploadColumn" class="col-md-6 col-12 mb-1">
                        <label for="imageUpload" class="form-label">Hình Ảnh</label>
                        <input
                            type="file"
                            id="imageUpload"
                            name="hinhanh[]"
                            class="form-control"
                            accept="image/*"
                            multiple
                            onchange="handleImageUpload()">
                             @error('hinhanh')
                            <div id="bookTypeHelp" class="form-text" style="color: red">{{ $message }}</div>
                            @enderror
                    </div>

                    <!-- Cột Hiển Thị Ảnh -->
                    <div id="previewColumn" class="col-md-6 col-12 mb-3" >
                        <label class="form-label">Hình Ảnh Đã Tải Lên</label>
                        <div class="row" id="imagePreviewRow">
                            @foreach($data->hinhAnhs as $item)
                                <div class="col-4">
                                    <img src="{{ asset($item->hinh_anh) }}" alt="" width="100px" class="img-thumbnail">
                                </div>
                            @endforeach

                        </div>
                    </div>
                    <div id="error-message" class="form-text" style="color: red"></div>


                </div>
                    <!-- Giá Bán -->
                    <div class="col-md-3 col-12 mb-3">
                        <label class="form-label">Giá Bán</label>
                        <input type="number" name="gia_ban" min="0" class="form-control" value="{{ old('gia_ban', $data->gia_ban) }}">
                        @error('gia_ban')
                            <div id="bookTypeHelp" class="form-text" style="color: red">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Giá Góc -->
                    <div class="col-md-3 col-12 mb-3">
                        <label class="form-label">Giá Góc</label>
                        <input type="number" name="gia_goc" min="0" class="form-control" value="{{ old('gia_goc', $data->gia_goc) }}">
                        @error('gia_goc')
                            <div id="bookTypeHelp" class="form-text" style="color: red">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Số Lượng -->
                    <div class="col-md-3 col-12 mb-3">
                        <label class="form-label">Số Lượng</label>
                        <input type="number" name="so_luong" min="1" class="form-control" value="{{ old('so_luong', $data->so_luong) }}">
                        @error('so_luong')
                            <div id="bookTypeHelp" class="form-text" style="color: red">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Số Trang -->
                    <div class="col-md-3 col-12 mb-3">
                        <label class="form-label">Số Trang</label>
                        <input type="number" name="so_trang" min="1" class="form-control" value="{{ old('so_trang', $data->so_trang) }}">
                        @error('so_trang')
                            <div id="bookTypeHelp" class="form-text" style="color: red">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Kích Thước -->
                    <div class="col-md-3 col-12 mb-3">
                        <label class="form-label">Kích Thước</label>
                        <input type="text" name="kich_thuoc" class="form-control" value="{{ old('kich_thuoc', $data->kich_thuoc) }}">
                        @error('kich_thuoc')
                            <div id="bookTypeHelp" class="form-text" style="color: red">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Trọng Lượng -->
                    <div class="col-md-3 col-12 mb-3">
                        <label class="form-label">Trọng Lượng (g)</label>
                        <input type="number" name="trong_luong" class="form-control" value="{{ old('trong_luong', $data->trong_luong) }}">
                        @error('trong_luong')
                            <div id="bookTypeHelp" class="form-text" style="color: red">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Ngày Nhập -->
                    <div class="col-md-3 col-12 mb-3">
                        <label class="form-label">Ngày Nhập</label>
                        <input type="date" name="ngay_nhap" class="form-control" value="{{ old('ngay_nhap', $data->ngay_nhap) }}">
                        @error('ngay_nhap')
                            <div id="bookTypeHelp" class="form-text" style="color: red">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Năm Xuất Bản -->
                    <div class="col-md-3 col-12 mb-3">
                        <label class="form-label">Năm Xuất Bản</label>
                        <input type="date" name="nam_xb" class="form-control" value="{{ old('nam_xb', $data->nam_xb) }}">
                        @error('nam_xb')
                            <div id="bookTypeHelp" class="form-text" style="color: red">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Nhà Sản Xuất -->
                    <div class="mb-3 col-md-3 col-12">
                        <label for="status" class="form-label">Nhà Sản Xuất</label>
                        <select class="form-control" id="status" name="id_nha_san_xuat">
                            @foreach($nhaSanXuat as $item)
                                <option value="{{ $item->id }}" {{ $data->id_nha_san_xuat == $item->id ? 'selected' : '' }}>{{ $item->ten_nha_san_xuat }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Nhà Phát Hành -->
                    <div class="mb-3 col-md-3 col-12">
                        <label for="status" class="form-label">Nhà Phát Hành</label>
                        <select class="form-control" id="status" name="id_nha_phat_hanh">
                            @foreach($nhaPhatHanh as $item)
                                <option value="{{ $item->id }}" {{ $data->id_nha_phat_hanh == $item->id ? 'selected' : '' }}>{{ $item->ten_nha_phat_hanh }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Tác Giả -->
                    <div class="mb-3 col-md-3 col-12">
                        <label for="status" class="form-label">Tác Giả</label>
                        <select class="form-control" id="status" name="id_tac_gia">
                            @foreach($tacGia as $item)
                                <option value="{{ $item->id }}" {{ $data->id_tac_gia == $item->id ? 'selected' : '' }}>{{ $item->ten_tac_gia }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Trạng Thái -->
                    <div class="mb-3 col-md-3 col-12">
                        <label for="status" class="form-label">Trạng Thái</label>
                        <select class="form-control" id="status" name="trang_thai">
                            <option value="1" {{ $data->trang_thai == 1 ? 'selected' : '' }}>Hoạt Động</option>
                            <option value="0" {{ $data->trang_thai == 0 ? 'selected' : '' }}>Không Hoạt Động</option>
                        </select>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Cập Nhật Sách</button>
            </form>
        </div>
    </div>
</div>
<script>

 function handleImageUpload() {
    const fileInput = document.getElementById('imageUpload');
    const uploadColumn = document.getElementById('uploadColumn');
    const previewColumn = document.getElementById('previewColumn');
    const imagePreviewRow = document.getElementById('imagePreviewRow');
    const errorMessage = document.getElementById('error-message');
    const files = fileInput.files;

    // Reset trạng thái hiển thị
    imagePreviewRow.innerHTML = '';
    errorMessage.textContent = '';

    // Kiểm tra nếu không có file được upload
    if (files.length === 0) {
        uploadColumn.classList.remove('col-md-6');
        uploadColumn.classList.add('col-md-12');
        previewColumn.style.display = 'none';
        return;
    }

    // Kiểm tra số lượng file (giới hạn 5 file)
    if (files.length > 5) {
        errorMessage.textContent = 'Bạn chỉ được tải lên tối đa 5 ảnh.';
        fileInput.value = ''; // Reset input file
        return;
    }

    // Kiểm tra định dạng file (chỉ chấp nhận ảnh)
    const validImageTypes = ['image/jpeg', 'image/png', 'image/gif'];
    for (let file of files) {
        if (!validImageTypes.includes(file.type)) {
            errorMessage.textContent = 'Chỉ chấp nhận các định dạng ảnh: JPG, PNG, GIF.';
            fileInput.value = ''; // Reset input file
            return;
        }
    }

    // Đổi cột upload thành col-md-6 và hiển thị cột preview
    uploadColumn.classList.remove('col-md-12');
    uploadColumn.classList.add('col-md-6');
    previewColumn.style.display = 'block';

    // Hiển thị ảnh (tối đa 5 file)
    for (let i = 0; i < files.length; i++) {
        const file = files[i];
        const reader = new FileReader();

        reader.onload = function (e) {
            // Tạo cột nhỏ để hiển thị từng ảnh
            const imageCol = document.createElement('div');
            imageCol.className = 'col-md-2 col-6 mb-3 position-relative'; // Thêm position-relative cho việc xóa ảnh

            const image = document.createElement('img');
            image.src = e.target.result;
            image.alt = `Ảnh ${i + 1}`;
            image.style.width = '100%';
            image.style.height = 'auto';
            image.style.borderRadius = '8px';

            // Tạo nút xóa ảnh
            const deleteButton = document.createElement('button');
            deleteButton.innerHTML = '<i class="ti ti-x"></i>';
            deleteButton.className = 'btn btn-danger btn-sm position-absolute top-0 end-0'; // Đặt nút xóa ở góc trên bên phải
            deleteButton.style.borderRadius = '50%';
            deleteButton.style.padding = '0.3rem 0.4rem';

            // Xử lý sự kiện xóa ảnh
            deleteButton.onclick = function () {
                imageCol.remove(); // Xóa ảnh khi nhấn nút

                // Cập nhật lại danh sách files trong input
                const fileArray = Array.from(fileInput.files);
                const fileIndex = fileArray.indexOf(file);
                if (fileIndex > -1) {
                    fileArray.splice(fileIndex, 1); // Xóa ảnh khỏi mảng file
                    const dataTransfer = new DataTransfer();
                    fileArray.forEach(f => dataTransfer.items.add(f)); // Thêm lại các ảnh còn lại vào input
                    fileInput.files = dataTransfer.files;
                }

                // Nếu không còn ảnh nào, reset trạng thái
                if (imagePreviewRow.children.length === 0) {
                    uploadColumn.classList.remove('col-md-6');
                    uploadColumn.classList.add('col-md-12');
                    previewColumn.style.display = 'none';
                }
            };

            // Thêm ảnh và nút xóa vào trong cột
            imageCol.appendChild(image);
            imageCol.appendChild(deleteButton);
            imagePreviewRow.appendChild(imageCol);
        };

        reader.readAsDataURL(file);
    }
}






</script>
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.2/super-build/ckeditor.js"></script>
<script src="{{ asset('admin/js/ckeditor.js') }}"></script>
@endsection
