<!DOCTYPE html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edu-Book</title>
    <!-- chat -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.min.css" integrity="sha512-q3eWabyZPc1XTCmF+8/LuE1ozpg5xxn7iO89yfSOd5/oKvyqLngoNGsx8jq92Y8eXJ/IRxQbEC+FGSYxtk2oiw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{asset('assets/css/chatbox/style1.css')}}">
     @if (!empty($scripts_seo))
        @foreach ($scripts_seo as $script)
            {!! $script['script'] !!}
        @endforeach
    @endif
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta property="og:title" content="">
    <meta property="og:type" content="">
    <meta property="og:url" content="">
    <meta property="og:image" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="shortcut icon" type="image/x-icon" href="{{asset('assets/imgs/theme/favicon.ico')}}">
    <link rel="stylesheet" href="{{asset('assets/css/main.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/custom.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/gioithieu/gioithieu.css')}}">
    <style>
        .search-form {
    display: flex;
    align-items: center;
    gap: 10px;
    background: #fff;
    padding: 3px;
    border-radius: 30px;
    box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1);
    width: fit-content;
}

.search-form input {
    border: none;
    outline: none;
    padding: 10px 15px;
    font-size: 16px;
    border-radius: 20px;
    flex: 1;
    min-width: 200px;
}

.search-form button {
    background: linear-gradient(45deg, #ff7e5f, #feb47b);
    color: white;
    border: none;
    padding: 10px 20px;
    font-size: 16px;
    font-weight: bold;
    cursor: pointer;
    border-radius: 20px;
    transition: all 0.3s ease;
}



    </style>
</head>

<body>
    <header class="header-area header-style-1 header-height-2">
        <div class="header-middle header-middle-ptb-1 d-none d-lg-block">
            <div class="container">
                <div class="header-wrap">
                    <div class="logo logo-width-1">
                          @if(!empty($configData['logo']))

                      <a href="{{ route('web.trang-chu') }}"><img src="{{ asset($configData['logo']) }}" alt="logo"></a>
                       @else
                            <h5 class="fw-semibold mb-0">Chưa có Logo</h5>

                        @endif

                    </div>
                    <div class="header-right">
                        <div class="search-style-1">
                            {{-- <form action="index.php?controller=search" method="post">
                                <input type="text" name="search" placeholder="Tìm kiếm...">
                            </form> --}}
                          <form onsubmit="return updateAction(event)" class="search-form">
                            <input type="text" id="search-input" name="search" placeholder="Tìm kiếm..." value="{{ request('search') }}">
                            <button type="submit" ><i class="fi-rs-search"></i></button>
                        </form>

                        <script>
                        function updateAction(event) {
                            event.preventDefault(); // Ngăn chặn form gửi đi ngay lập tức

                            let input = document.getElementById("search-input").value.trim();
                            if (input) {
                                let searchUrl = "{{ route('web.tim-kiem-san-pham', ':keyword') }}";
                                searchUrl = searchUrl.replace(':keyword', encodeURIComponent(input)); // Chỉ thay ':keyword' trong URL

                                window.location.href = searchUrl;
                            }
                        }
                        </script>



                        </div>
                        <div class="header-action-right">
                            <div class="header-action-2">
                                <div class="header-action-icon-2">
                                </div>
                                <div class="header-action-icon-2">
                                    <a class="mini-cart-icon" href="{{ route('web.gio-hang') }}">
                                        <img alt="Surfside Media" src="{{asset('assets/imgs/theme/icons/icon-cart1.svg')}}">
                                        <span class="pro-count blue cart" id="card"></span>
                                    </a>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="header-bottom header-bottom-bg-color sticky-bar">
            <div class="container">
                <div class="header-wrap header-space-between position-relative">
                    <div class="logo logo-width-1 d-block d-lg-none">
                        <a href="index.html"><img src="{{asset('assets/imgs/logo/logo.jpg')}}" alt="logo"></a>
                    </div>
                    <div class="header-nav d-none d-lg-flex">
                        <div class="main-categori-wrap d-none d-lg-block">
                            <a class="categori-button-active" href="#">
                                <span class="fi-rs-apps"></span> Danh mục
                            </a>
                            <div class="categori-dropdown-wrap categori-dropdown-active-large">
                                <ul class="categories">
                                    @foreach ($danhmucs as $item)
                                        <li><a href="{{ route('web.san-pham-theo-danh-muc', $item->id) }}">{{ $item->ten_loai_san_pham}}</a>
                                        </li>
                                   @endforeach
                                </ul>
                            </div>
                        </div>
                        <div class="main-menu main-menu-padding-1 main-menu-lh-2 d-none d-lg-block">
                            <nav>
                                <ul>
                                   <li><a class="{{ request()->is('Trang-Chu.html') ? 'active' : '' }}" href="{{ route('web.trang-chu') }}">Trang chủ</a></li>
                                    <li><a class="{{ request()->is('San-Pham.html') ? 'active' : '' }}" href="{{ route('web.tat-ca-san-pham') }}">Sản phẩm</a></li>
                                    <li><a class="{{ request()->is('Gioi-Thieu.html') ? 'active' : '' }}" href="{{ route('web.gioi-thieu') }}">Giới thiệu</a></li>

                                    @auth
                                            @if (auth()->user()->quyen != 2)
                                            <li id="message-id" data-id="1"><a style="color: black">Liên hệ</a></li>
                                             @endif

                                      @endauth

                                </ul>
                            </nav>
                        </div>
                    </div>
                    <div class="hotline d-none d-lg-block">
                        @auth
                          <a href="{{ route('web.tai-khoan') }}">Tài khoản </a>
                            @else
                            <a href="{{ route('login') }}"> Đăng nhập</a>
                        @endauth
                    </div>
                    <div class="header-action-right d-block d-lg-none">
                        <div class="header-action-2">
                            <div class="header-action-icon-2">
                                <a class="mini-cart-icon" href="">
                                    <img alt="Surfside Media" src="{{asset('assets/imgs/theme/icons/icon-cart1.svg')}}">
                                    <span class="pro-count white card" id="card"></span>
                                </a>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </header>
    <div class="mobile-header-active mobile-header-wrapper-style">
        <div class="mobile-header-wrapper-inner">
            <div class="mobile-header-top">
                <div class="mobile-header-logo">
                    <a href="index.php?controller=trangChu"><img src="{{asset('assets/imgs/logo/logo.png')}}" alt="logo"></a>
                </div>
            </div>
            <div class="mobile-header-content-area">
                <div class="mobile-search search-style-3 mobile-header-border">
                    <form action="#">
                        <input type="text" placeholder="Search for items…">
                        <button type="submit"><i class="fi-rs-search"></i></button>
                    </form>
                </div>
                <div class="mobile-menu-wrap mobile-header-border">

                    <!-- mobile menu start -->
                    <nav>
                        <ul class="mobile-menu">
                            <li class="menu-item-has-children"><span class="menu-expand"></span><a href="index.html">Trang chủ</a></li>
                            <li class="menu-item-has-children"><span class="menu-expand"></span><a href="shop.html">Sản
                                    phẩm</a>
                            </li>
                            <li class="menu-item-has-children"><span class="menu-expand"></span><a href="blog.html">Giới
                                    thiệu</a>
                            </li>
                            <li class="menu-item-has-children"><span class="menu-expand"></span><a href="blog.html">Giới
                                    thiệu</a>
                            </li>
                            <li class="menu-item-has-children"><span class="menu-expand"></span><a href="#">Danh mục</a>
                                <ul class="dropdown">
                                    <li><a href="#">English</a></li>
                                    <li><a href="#">French</a></li>
                                    <li><a href="#">German</a></li>
                                    <li><a href="#">Spanish</a></li>
                                </ul>
                            </li>
                        </ul>
                    </nav>
                    <!-- mobile menu end -->
                </div>
                <div class="mobile-header-info-wrap mobile-header-border">
                    <div class="single-mobile-header-info">
                        <a href="login.html">Đăng nhập </a>
                    </div>
                    <div class="single-mobile-header-info">
                        <a href="register.html">Đăng ký</a>
                    </div>
                </div>
                <div class="mobile-social-icon">
                    <h5 class="mb-15 text-grey-4">Follow Us</h5>
                    <a href="#"><img src="{{asset('assets/imgs/theme/icons/icon-facebook.svg')}}" alt=""></a>
                    <a href="#"><img src="{{asset('assets/imgs/theme/icons/icon-twitter.svg')}}" alt=""></a>
                    <a href="#"><img src="{{asset('assets/imgs/theme/icons/icon-instagram.svg')}}" alt=""></a>
                    <a href="#"><img src="{{asset('assets/imgs/theme/icons/icon-pinterest.svg')}}" alt=""></a>
                    <a href="#"><img src="{{asset('assets/imgs/theme/icons/icon-youtube.svg')}}" alt=""></a>
                </div>
            </div>
        </div>
    </div>


@yield('noidung')


    <footer class="main">
    <section class="newsletter p-30 text-white wow fadeIn animated">
        <div class="container">

        </div>
    </section>
    <section class="section-padding footer-mid">
        <div class="container pt-15 pb-20">
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <div class="widget-about font-md mb-md-5 mb-lg-0">
                        <div class="logo logo-width-1 wow fadeIn animated">
                            @if(!empty($configData['logo']))

                            <a href="{{ route('web.trang-chu') }}"><img src="{{ asset($configData['logo'])}}" alt="logo"></a>
                       @else
                            Chưa có
                        @endif
                        </div>
                        <h5 class="mt-20 mb-10 fw-600 text-grey-4 wow fadeIn animated">Contact</h5>
                        <p class="wow fadeIn animated">
                            <strong>Địa chỉ: </strong>
                             @if(!empty($configData['address']))
                                {{ $configData['address'] }}
                       @else
                            Chưa có
                        @endif
                        </p>
                        <p class="wow fadeIn animated">
                            <strong>Số điện thoại</strong> @if(!empty($configData['phone_number']))
                                {{ $configData['phone_number'] }}
                       @else
                            Chưa có
                        @endif
                        </p>
                        <p class="wow fadeIn animated">
                            <strong>Email: </strong>{{ ENV('MAIL_USERNAME') }}
                        </p>
                        <h5 class="mb-10 mt-30 fw-600 text-grey-4 wow fadeIn animated">Follow Us</h5>
                        <div class="mobile-social-icon wow fadeIn animated mb-sm-5 mb-md-0">
                            <a href="#"><img src="{{asset('assets/imgs/theme/icons/icon-facebook.svg')}}" alt=""></a>
                            <a href="#"><img src="{{asset('assets/imgs/theme/icons/icon-twitter.svg')}}" alt=""></a>
                            <a href="#"><img src="{{asset('assets/imgs/theme/icons/icon-instagram.svg')}}" alt=""></a>
                            <a href="#"><img src="{{asset('assets/imgs/theme/icons/icon-pinterest.svg')}}" alt=""></a>
                            <a href="#"><img src="{{asset('assets/imgs/theme/icons/icon-youtube.svg')}}" alt=""></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-3">
                    <h5 class="widget-title wow fadeIn animated">Về</h5>
                    <ul class="footer-list wow fadeIn animated mb-sm-5 mb-md-0">
                        <li><a href="#">Về chúng tôi</a></li>
                        <li><a href="#">Thông tin giao hàng</a></li>
                        <li><a href="#">Chính sách sản phẩm</a></li>
                        <li><a href="#">Điều khoản và điều kiện</a></li>
                        <li><a href="#">Liên hệ chúng tôi</a></li>
                    </ul>
                </div>
                <div class="col-lg-2  col-md-3">
                    <h5 class="widget-title wow fadeIn animated">Tài khoản của tôi</h5>
                    <ul class="footer-list wow fadeIn animated">
                        <li><a href="my-account.html">Tài khoản của tôi</a></li>
                        <li><a href="#">Xem giỏ hàng</a></li>
                        <li><a href="#">Sản phẩm yêu thích</a></li>
                        <li><a href="#">Theo dõi đơn hàng</a></li>
                        <li><a href="#">Đặt hàng</a></li>
                    </ul>
                </div>
                <div class="col-lg-4 mob-center">
                    <h5 class="widget-title wow fadeIn animated">Cài đặt ứng dụng</h5>
                    <div class="row">
                        <div class="col-md-8 col-lg-12">
                            <p class="wow fadeIn animated">Từ App Store hoặc Google Play</p>
                            <div class="download-app wow fadeIn animated mob-app">
                                <a href="#" class="hover-up mb-sm-4 mb-lg-0"><img class="active" src="{{asset('assets/imgs/theme/app-store.jpg')}}" alt=""></a>
                                <a href="#" class="hover-up"><img src="{{asset('assets/imgs/theme/google-play.jpg')}}" alt=""></a>
                            </div>
                        </div>
                        <div class="col-md-4 col-lg-12 mt-md-3 mt-lg-0">
                            <p class="mb-20 wow fadeIn animated">Cổng thanh toán an toàn</p>
                            <img class="wow fadeIn animated" src="{{asset('assets/imgs/theme/payment-method.png')}}" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="container pb-20 wow fadeIn animated mob-center">
        <div class="row">
            <div class="col-12 mb-20">
                <div class="footer-bottom"></div>
            </div>
            <div class="col-lg-6">
                <p class="float-md-left font-sm text-muted mb-0">
                    <a href="privacy-policy.html">Chính sách bảo mật</a> | <a href="terms-conditions.html">Điều khoản và
                        điều kiện</a>
                </p>
            </div>
            <div class="col-lg-6">
                <p class="text-lg-end text-start font-sm text-muted mb-0">
                    &copy; <strong class="text-brand">EduBook</strong> Mọi quyền được bảo lưu
                </p>
            </div>
        </div>
    </div>
</footer>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@if (session('alert'))
<script>
    const Toast = Swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.onmouseenter = Swal.stopTimer;
            toast.onmouseleave = Swal.resumeTimer;
        }
    });
    Toast.fire({
        icon: "{{ session('alert')['type'] }}",
        title: "{{ session('alert')['message'] }}"
    });
</script>
@endif
<script>
    function displayToast(type, message) {
    const Toast = Swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.onmouseenter = Swal.stopTimer;
            toast.onmouseleave = Swal.resumeTimer;
        }
    });
    Toast.fire({
        icon: type,
        title: message
    });
}
</script>


<!-- Vendor JS-->
<script src="{{asset('assets/js/vendor/modernizr-3.6.0.min.js')}}"></script>
<script src="{{asset('assets/js/vendor/jquery-3.6.0.min.js')}}"></script>
<script src="{{asset('assets/js/vendor/jquery-migrate-3.3.0.min.js')}}"></script>
<script src="{{asset('assets/js/vendor/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('assets/js/plugins/slick.js')}}"></script>
<script src="{{asset('assets/js/plugins/jquery.syotimer.min.js')}}"></script>
<script src="{{asset('assets/js/plugins/wow.js')}}"></script>
<script src="{{asset('assets/js/plugins/jquery-ui.js')}}"></script>
<script src="{{asset('assets/js/plugins/perfect-scrollbar.js')}}"></script>
<script src="{{asset('assets/js/plugins/magnific-popup.js')}}"></script>
<script src="{{asset('assets/js/plugins/select2.min.js')}}"></script>
<script src="{{asset('assets/js/plugins/waypoints.js')}}"></script>
<script src="{{asset('assets/js/plugins/counterup.js')}}"></script>
<script src="{{asset('assets/js/plugins/jquery.countdown.min.js')}}"></script>
<script src="{{asset('assets/js/plugins/images-loaded.js')}}"></script>
<script src="{{asset('assets/js/plugins/isotope.js')}}"></script>
<script src="{{asset('assets/js/plugins/scrollup.js')}}"></script>
<script src="{{asset('assets/js/plugins/jquery.vticker-min.js')}}"></script>
<script src="{{asset('assets/js/plugins/jquery.theia.sticky.js')}}"></script>
<script src="{{asset('assets/js/plugins/jquery.elevatezoom.js')}}"></script>
<!-- Template  JS -->
<script src="{{asset('assets/js/main.js')}}"></script>
<script src="{{asset('assets/js/shop.js')}}"></script>
<script src="{{asset('assets/js/addcard.js')}}"></script>
<!-- địa chỉ -->
<script src="{{asset('assets/js/form_dia_chi.js')}}"></script>
<!-- commnent -->
<script src="{{asset('assets/js/binh_luan.js')}}"></script>
<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js')}}"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js')}}"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


<script>
    function addToCartt(productId) {
        var quantity = $('#quantity-' + productId).val();
        var token = "{{ csrf_token() }}";

        $.ajax({
            url: "{{ route('web.them-vao-gio-hang') }}",
            method: "POST",
            data: {
                _token: token,
                product_id: productId,
                quantity: quantity
            },
            success: function(response) {
                if (response.success) {
                   displayToast('success', 'Thêm vào giỏ hàng thành công !');
                } else {
                    alert("Có lỗi xảy ra, vui lòng thử lại!");
                }
            },
            error: function() {
                alert("Không thể thêm sản phẩm vào giỏ hàng.");
            }
        });
    }
 function muaHangg(productId) {

    // Lấy danh sách các checkbox được chọn
    const selectedIds = [];

        selectedIds.push(productId.toString());

        //  console.log("Checkbox ID:", checkbox.value);


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
                window.location.href = "{{ route('web.thanh-toanv2') }}";
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

<script>

    $(document).ready(function() {

    // message
    @auth


    var recipientId = null;
    var currentChannel = null;

    var recipientImage = null;
    var login_userId = {{ auth()->id()}};
    $('#message-id').click(function(){
        console.log('message');
        recipientId = $(this).attr('data-id');


        $.ajax({
              url: "{{ route('kiem-tra-cuoc-tro-chuyen-user') }}",
              method: 'GET',
              data: { recipientId: recipientId },
              success: function(response) {
                  if (response.channelExists) {
                     localStorage.setItem('channelName', response.channelName);
                      window.location.href = '{{ route('web.lien-he') }}';

                  } else {
                      createNewChannel(recipientId);

                  }
              },
              error: function(xhr, status, error) { console.error(error); }
          });
    });
    function createNewChannel(recipientId) {

        $.ajax({
            url: '{{ route('them-cuoc-tro-chuyen') }}',
            method: 'GET',
            data: { recipientId: recipientId },
            success: function (response) {
                if(response.success == true){

                localStorage.setItem('channelName', response.channelName);

                window.location.href = '{{ route('web.lien-he') }}';
                }
                else{

                console.log(response.error);
                }
            },

        });
        }

        @endauth
    });
</script>
</body>

</html>
