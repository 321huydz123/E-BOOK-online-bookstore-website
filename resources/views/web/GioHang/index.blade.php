@extends('layouts.user')
@section('noidung')
<main class="main">
    <section class="mt-50 mb-50">
        <div class="container">
            <div class="row">

                @if (!empty($giohang) && count($giohang) > 0)
                <div class="col-12">
                    {{-- <form action="{{ route('check.thongTin') }}" method="post"> --}}
                        <div class="table-responsive">
                            <table class="table shopping-summery text-center clean">
                                <thead>
                                    <tr class="main-heading">
                                        <th></th>
                                        <th scope="col">Hình ảnh</th>
                                        <th scope="col">Tên sản phẩm</th>
                                        <th scope="col">Giá bán</th>
                                        <th scope="col">Số lượng</th>
                                        <th scope="col">Thành tiền</th>
                                        <th scope="col">Xoá</th>
                                    </tr>
                                </thead>
                                <tbody id="tbody">
                                    @if ($giohang == null)
                                        <tr class='text'>
                                            <td colspan='7'>Không có sản phẩm trong giỏ hàng.</td>
                                        </tr>
                                    @else
                                        @foreach ($giohang as $item)
                                           <tr class="cart-item-row cart-item-{{ $item->id }}" data-id="{{ $item->id }}">
                                                <td>
                                                    <label class="checkbox-wrap checkbox-primary">
                                                        <input type="checkbox" name="card[]" value="{{ $item->id }}" />
                                                        <span class="checkmark"></span>
                                                    </label>
                                                </td>
                                                <td class="image product-thumbnail">
                                                    <img src="{{ asset($item->san_pham->hinhAnh->hinh_anh) }}" alt="#">
                                                </td>
                                                <td class="product-des product-name">
                                                    <h5 class="product-name">
                                                        <a href="{{ route('web.chi-tiet-san-pham',$item->id_san_pham) }}">{{ $item->san_pham->ten_san_pham}}</a>
                                                    </h5>
                                                </td>
                                                <td class="price" data-title="Price">
                                                    <span class="item-price">{{ number_format($item->san_pham->gia_ban, 0, ',', '.') }} VND</span>
                                                </td>
                                                <td class="text-center" data-title="Stock">
                                                    <div class="detai border radius m-auto">
                                                        <a href="#" class="qty-down" data-id-san-pham="{{ $item->id_san_pham }}" data-id="{{ $item->id }}" onclick="giamsl(this)"><i class="fi-rs-angle-small-down"></i></a>
                                                        <span class="item-quantity">{{ $item->so_luong }}</span>
                                                        <a href="#" class="qty-up" data-id-san-pham="{{ $item->id_san_pham }}" data-id="{{ $item->id }}" onclick="tangsl(this)"><i class="fi-rs-angle-small-up"></i></a>
                                                    </div>
                                                </td>
                                                <td class="text-right" data-title="Cart">
                                                    <span class="item-total">{{ number_format($item->san_pham->gia_ban * $item->so_luong, 0, ',', '.')}} VND</span>
                                                </td>
                                               {{-- <td class="action" data-title="Remove">
                                                    <form action="{{ route('web.xoa-gio-hang',$item->id) }}" method="POST" >
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-link text-muted">
                                                            <i class="fi-rs-trash"></i>
                                                        </button>
                                                    </form>
                                                </td> --}}
                                                <td>
                                               <a href="javascript:void(0);" class="text-muted" onclick="document.getElementById('delete-form-{{ $item->id }}').submit();">
                                                    <i class="fi-rs-trash"></i>
                                                </a>
                                                <form id="delete-form-{{ $item->id }}" action="{{ route('web.xoa-gio-hang', $item->id) }}" method="POST" style="display: none;">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                                </td>


                                            </tr>

                                        @endforeach
                                    @endif

                                    <tr>
                                        <td colspan="7" class="text-end">
                                            <a href="javascript:void(0);" class="text-muted" onclick="document.getElementById('delete-all-cart-form').submit();">
                                                <i class="fi-rs-cross-small"></i> Xóa toàn bộ giỏ hàng
                                            </a>
                                            <form id="delete-all-cart-form" action="{{ route('web.xoa-toan-bo-gio-hang') }}" method="POST" style="display: none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="cart-action text-end">
                            <a class="btn " onclick="selectAll()"><i class="fi-rs-checkmark mr-10"></i> Chọn tất cả</a>
                            <a class="btn " onclick="deselectAll()"><i class="fi-rs-cross mr-10"></i> Bỏ chọn tất cả</a>

                            <a class="btn " onclick="muaHang()" ><i class="fi-rs-shopping-bag mr-10"></i> <button style="outline: none; border: transparent; background: transparent; color: #fff;">Mua hàng</button></a>
                        </div>
                        <div class="divider center_icon mt-50 mb-50"><i class="fi-rs-fingerprint"></i></div>
                    </form>
                </div>
                @else
                    <p class="text-center text-muted">Không có sản phẩm trong giỏ hàng.</p>
                @endif
            </div>
        </div>
    </section>
    <!-- Thêm link CDN cho jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


    <script>
        function updateCartRow(cartItemId, newQuantity, newTotalPrice) {
    // Cập nhật số lượng
    const row = document.querySelector(`.cart-item-${cartItemId}`);
    if (row) {
        row.querySelector('.item-quantity').textContent = newQuantity;
        row.querySelector('.item-total').textContent = `${newTotalPrice} VND`;
    }
}

      function giamsl(element) {
    // Lấy dữ liệu từ thuộc tính data của thẻ
    const id = element.getAttribute('data-id');
    const idSanPham = element.getAttribute('data-id-san-pham');

    // Gửi yêu cầu AJAX
    $.ajax({
        url: "{{ route('web.cap-nhat-so-luong') }}", // Đường dẫn tới route xử lý
        method: "POST",
        data: {
            id: id, // ID của mục giỏ hàng
            id_san_pham: idSanPham, // ID sản phẩm
            action: 'decrease', // Hành động giảm số lượng
            _token: "{{ csrf_token() }}", // Token bảo mật
        },
        success: function(response) {
            if (response.success) {
                   updateCartRow(id, response.so_luong, response.total_price);
            } else {
                alert(response.message);
            }
        },
        error: function() {
            alert("Có lỗi xảy ra khi giảm số lượng sản phẩm.");
        }
    });
}

 function tangsl(element) {
    // Lấy dữ liệu từ thuộc tính data của thẻ
    const id = element.getAttribute('data-id');
    const idSanPham = element.getAttribute('data-id-san-pham');

    // Gửi yêu cầu AJAX
    $.ajax({
        url: "{{ route('web.cap-nhat-so-luong') }}", // Đường dẫn tới route xử lý
        method: "POST",
        data: {
            id: id, // ID của mục giỏ hàng
            id_san_pham: idSanPham, // ID sản phẩm
            action: 'increase', // Hành động giảm số lượng
            _token: "{{ csrf_token() }}", // Token bảo mật
        },
        success: function(response) {
            if (response.success) {
                // Tìm dòng tương ứng với sản phẩm
                updateCartRow(id, response.so_luong, response.total_price);
                // displayToast('success', 'Người dùng đã được mở khóa!');
            } else {
                alert(response.message);
            }
        },
        error: function() {
            alert("Có lỗi xảy ra khi tăng số lượng sản phẩm.");
        }
    });
}
function muaHang() {

    // Lấy danh sách các checkbox được chọn
    const selectedIds = [];
    document.querySelectorAll('input[name="card[]"]:checked').forEach((checkbox) => {
        selectedIds.push(checkbox.value);
         console.log("Checkbox ID:", checkbox.value);
    });

    // Kiểm tra danh sách đã chọn và log ra console
    console.log("Danh sách sản phẩm đã chọn: ", selectedIds);

    if (selectedIds.length === 0) {
        alert("Vui lòng chọn ít nhất một sản phẩm để mua hàng!");
        return;
    }

    // Gửi dữ liệu qua AJAX
    $.ajax({
        url: "{{ route('web.luu-gio-hang') }}", // Đường dẫn đến route xử lý lưu session
        method: "POST",
        data: {
            selectedIds: selectedIds,
            _token: "{{ csrf_token() }}", // Token bảo mật
        },
        success: function(response) {
            if (response.success) {
                window.location.href = "{{ route('web.thanh-toan') }}"; // Chuyển đến trang thanh toán
            } else {
                alert(response.message || "Có lỗi xảy ra. Vui lòng thử lại.");
            }
        },
        error: function() {
            alert("Không thể thực hiện mua hàng. Vui lòng thử lại sau.");
        }
    });
}




    </script>
</main>
@endsection
