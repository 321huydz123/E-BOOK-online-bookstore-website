@extends('layouts.user')

@section('noidung')
<main class="main">
    <section class="mt-50 mb-50">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-25">
                        <h4>Thông tin hóa đơn</h4>
                    </div>
                    <form action="" method="post" id="orderForm">
                        @csrf
                        <div class="form-group">
                            <label for="fname">Họ và tên:</label>
                            <input class="form-control" type="text" name="txt_billing_fullname"
                                placeholder="Họ và tên *" value="{{ auth()->user()->ten }}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="sdt">Số điện thoại:</label>
                          <input class="form-control" type="text" name="txt_billing_mobile"
                                    placeholder="Số điện thoại *"
                                    value="{{ auth()->user()->sdt ? auth()->user()->sdt : '' }}"
                                    {{ auth()->user()->sdt ? 'readonly' : '' }} >

                        </div>
                        <div class="form-group">
                            <label for="diaChi">Địa chỉ:</label>
                            <input class="form-control" type="text" name="txt_billing_addr1" value="{{ $diachi->dia_chi ?? '' }}" placeholder="Địa chỉ *">

                        </div>


                        <div class="form-group">
                            <label for="payment_method">Phương thức thanh toán:</label>
                            <select class="form-control" id="payment_method" name="payment_method" required>
                                <option value="online">Thanh toán online</option>
                                <option value="cod">Thanh toán khi nhận hàng</option>
                            </select>
                        </div>
                          <div class="form-group">
                            <label for="note">Ghi chú:</label>
                            <textarea class="form-control" type="text" name="note" placeholder="Ghi chú"> </textarea>
                        </div>
                    </form>
                </div>

                <div class="col-md-6">
                    <div class="order_review">
                        <div class="mb-20">
                            <h4>Thông tin sản phẩm</h4>
                        </div>
                        <div class="table-responsive order_table text-center">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th colspan="2">Sản phẩm</th>
                                        <th>Giá</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $thanhTien = 0;
                                    @endphp
                                    @foreach($products as $sp)
                                        <tr>
                                            <td class="image product-thumbnail"><img
                                                    src="{{ asset($sp->hinhAnh->hinh_anh) }}" alt="#"></td>
                                            <td>
                                                <h5><a href="">{{ $sp->ten_san_pham }}</a>
                                                    <span class="product-qty" data-product-id="{{ $sp->id }}">x1</span>
                                                </h5>
                                            </td>
                                            <td>{{ number_format($sp->gia_ban, 0, ',', '.') }} VND</td>
                                        </tr>
                                        @php
                                            $thanhTien += 1 * $sp->gia_ban;
                                        @endphp
                                    @endforeach
                                    <tr>
                                        <th>Phí giao hàng</th>
                                        <td colspan="2"><em>Miễn phí</em></td>
                                    </tr>
                                    <tr>
                                        <th>Thành tiền</th>
                                        <td colspan="2" class="product-subtotal">
                                            <span class="font-xl text-brand fw-900">{{ number_format($thanhTien, 0, ',', '.') }} VND</span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-end">
                            <!-- Nút Hủy, màu xám -->
                            <button type="reset" class="btn btn-secondary mx-2">Hủy</button>

                            <!-- Nút Đặt hàng, màu chính -->
                            <button type="button" class="btn btn-primary mx-2" id="orderButton">Đặt hàng</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    var paymentUrl = "{{ route('web.payment') }}"; // Lấy URL của route 'web.payment'
    var taikhoan = "{{ route('web.tai-khoan') }}";
</script>

<script>
   $(document).ready(function() {
    $('#orderButton').on('click', function(e) {
        e.preventDefault(); // Ngăn việc submit form mặc định

        // Lấy các thông tin cần thiết từ form
        var paymentMethod = $('#payment_method').val(); // Lấy phương thức thanh toán
        var totalAmount = $('.product-subtotal span').text().trim().replace('VND', '').replace(',', ''); // Lấy tổng tiền
        var address = $("input[name='txt_billing_addr1']").val(); // Lấy địa chỉ
        var phone = $("input[name='txt_billing_mobile']").val(); // Lấy địa chỉ
        var note = $("textarea[name='note']").val(); // Lấy địa chỉ

        var products = [];

        $('.product-qty').each(function() {
            var productId = $(this).data('product-id'); // Lấy id của sản phẩm
            var quantity = $(this).text().replace('x', '').trim(); // Lấy số lượng của sản phẩm

            // Tạo đối tượng sản phẩm và thêm vào mảng
            products.push({
                id: productId,
                soluong: quantity
            });
        });

        // Gửi yêu cầu AJAX để lưu thông tin vào session
        $.ajax({
            url: "{{ route('web.them-thong-tin-don-hang') }}", // Route lưu thông tin vào session
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}', // CSRF token để bảo vệ request
                totalAmount: totalAmount,
                address: address,
                products: products,  // Gửi mảng sản phẩm với id và số lượng
                phone: phone,
                note: note,  // Gửi mảng sản phẩm với id và số lượng
                paymentMethod: paymentMethod
            },
            success: function(response) {
                if(paymentMethod === 'online') {
                    // Nếu là thanh toán online, chuyển hướng đến trang thanh toán online
                     window.location.href = paymentUrl;
                    // console.log('vailon');

                } else {
                     $.ajax({
                url: "{{ route('web.thanh-toan-truc-tiep') }}", // Route lưu thông tin vào session
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}', // CSRF token để bảo vệ request
                    totalAmount: totalAmount,
                    address: address,
                    products: products,  // Gửi mảng sản phẩm với id và số lượng
                    phone: phone,
                    note: note,  // Gửi mảng sản phẩm với id và số lượng
                    paymentMethod: paymentMethod
                },
                success: function(response) {
                    // Kiểm tra trạng thái của thanh toán (thành công hay thất bại)
                    if(response.success) {
                        // Nếu thanh toán thành công, hiển thị thông báo và chuyển hướng
                        displayToast('success', 'Thanh Toán Thành Công!');
                        window.location.href = taikhoan; // Chuyển hướng đến tài khoản
                    } else {
                        // Nếu có lỗi, hiển thị thông báo lỗi
                        displayToast('error', 'Thanh Toán Thất Bại! Vui lòng thử lại.');
                    }
                },
                error: function(xhr, status, error) {
                    alert('Đã có lỗi xảy ra khi thanh toán COD! Vui lòng thử lại.');
                }
            });
        }







            },
            error: function(xhr, status, error) {
                alert('Đã có lỗi xảy ra! Vui lòng thử lại.');
            }
        });
    });
});

</script>
@endsection
