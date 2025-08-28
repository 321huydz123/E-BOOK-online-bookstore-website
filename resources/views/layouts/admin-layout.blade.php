<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>Edu-Book Admin</title>
  @if(!empty($configData['logo']))
        <link rel="shortcut icon" type="image/png" href="{{ asset($configData['logo'])}}" />
                       @else
                            Chưa có
                        @endif
  <link rel="stylesheet" href="{{ asset('admin/css/styles.min.css')}}" />
   <link href="{{ asset('admin/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body>
  <!--  Body Wrapper -->
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">
    <!-- Sidebar Start -->
    <aside class="left-sidebar">
      <!-- Sidebar scroll-->
      <div>
        <div class="brand-logo d-flex align-items-center justify-content-between">
                     @if(!empty($configData['logo']))
                      {{-- <img src="{{ asset($configData['logo']) }}" alt="modernize-img" class=" mb-3" width="100" height="100"> --}}
                         <a href="{{ route('web.trang-chu') }}" class="text-nowrap logo-img">
                        <img src="{{ asset($configData['logo']) }}" width="180" alt="" />
                    </a>
                       @else
                            <h5 class="fw-semibold mb-0">Chưa có Logo</h5>

                        @endif
          {{-- <a href="./index.html" class="text-nowrap logo-img">
            <img src="{{ asset('admin/images/logos/dark-logo.svg')}}" width="180" alt="" />
          </a> --}}
          <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
            <i class="ti ti-x fs-8"></i>
          </div>
        </div>
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
          <ul id="sidebarnav">
            <li class="nav-small-cap">
              <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
              <span class="hide-menu">Home</span>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="{{ route('thong-ke') }}" aria-expanded="false">
                <span>
                  <i class="ti ti-layout-dashboard"></i>
                </span>
                <span class="hide-menu">Thống kê</span>
              </a>
            </li>


            <li class="sidebar-item">
              <a class="sidebar-link" href="{{ route('loai-san-pham') }}" aria-expanded="false">
                <span>
                 <i class="ti ti-category"></i>
                </span>
                <span class="hide-menu">Quản lý danh mục</span>
              </a>
            </li>

            <li class="sidebar-item" class="form-select">
              <a class="sidebar-link has-arrow" href="javascript:void(0)" aria-expanded="false">
                <span class="d-flex">
                 <i class="ti ti-books"></i>
                </span> Quản lý sản phẩm
                <span class="hide-menu"></span>
              </a>
              <ul aria-expanded="false" class="collapse first-level">
                <li class="sidebar-item">
                  <a href="{{ route('san-pham') }}" class="sidebar-link">
                    <div class="round-16 d-flex align-items-center justify-content-center">

                    </div>
                    <span class="hide-menu"> Danh sách sản phẩm </span>
                  </a>
                </li>
                <li class="sidebar-item">
                  <a href="{{ route('san-pham.create') }}" class="sidebar-link">
                    <div class="round-16 d-flex align-items-center justify-content-center">

                    </div>
                    <span class="hide-menu">Thêm sản phẩm</span>
                  </a>
                </li>

              </ul>
            </li>
            <li class="sidebar-item" class="form-select">
              <a class="sidebar-link has-arrow" href="javascript:void(0)" aria-expanded="false">
                <span class="d-flex">
                  <i class="ti ti-feather"></i>
                </span>Thông tin xuất bản
                <span class="hide-menu"></span>
              </a>
              <ul aria-expanded="false" class="collapse first-level">
                <li class="sidebar-item">
                  <a href="{{ route('tac-gia') }}" class="sidebar-link">
                    <div class="round-16 d-flex align-items-center justify-content-center">

                    </div>
                    <span class="hide-menu"> Tác Giả </span>
                  </a>
                </li>
                <li class="sidebar-item">
                  <a href="{{ route('nha-phat-hanh') }}" class="sidebar-link">
                    <div class="round-16 d-flex align-items-center justify-content-center">

                    </div>
                    <span class="hide-menu">Nhà Phát Hành</span>
                  </a>
                </li>
                <li class="sidebar-item">
                  <a href="{{ route('nha-san-xuat') }}" class="sidebar-link">
                    <div class="round-16 d-flex align-items-center justify-content-center">

                    </div>
                    <span class="hide-menu">Nhà Sản Xuất</span>
                  </a>
                </li>
              </ul>
            </li>

            <li class="sidebar-item">
              <a class="sidebar-link" href="{{ route('nhan-tin') }}" aria-expanded="false">
                <span>
                 <i class="ti ti-message-dots"></i>
                </span>
                <span class="hide-menu">Tư vấn khách hàng</span>
              </a>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="{{ route('don-hang') }}" aria-expanded="false">
                <span>
                 <i class="ti ti-shopping-cart"></i>

                </span>
                <span class="hide-menu">Quản lý đơn hàng</span>
              </a>
            </li>
              <li class="sidebar-item">
              <a class="sidebar-link" href="{{ route('tai-khoan') }}" aria-expanded="false">
                <span>
                <i class="ti ti-users"></i>
                </span>
                <span class="hide-menu">Quản lý tài khoản </span>
              </a>
            </li>

            <li class="nav-small-cap">
              <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
              <span class="hide-menu"> Cài Đặt </span>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="{{ route('SEO') }}" aria-expanded="false">
                <span>
                  <i class="ti ti-seo"></i>
                </span>
                <span class="hide-menu">SEO</span>
              </a>
            </li>
            <li class="sidebar-item">
              {{-- <a class="sidebar-link" href="./authentication-register.html" aria-expanded="false">
                <span>
                 <i class="ti ti-settings"></i>
                </span>
                <span class="hide-menu">Cấu hình</span>
              </a> --}}
              <a class="sidebar-link has-arrow" href="javascript:void(0)" aria-expanded="false">
                <span class="d-flex">
                  <i class="ti ti-settings"></i>
                </span>Cấu hình
                <span class="hide-menu"></span>
              </a>
              <ul aria-expanded="false" class="collapse first-level">
                <li class="sidebar-item">
                  <a href="{{ route('Hien-Thi-mail') }}" class="sidebar-link">
                    <div class="round-16 d-flex align-items-center justify-content-center">

                    </div>
                    <span class="hide-menu"> Mail </span>
                  </a>
                </li>
                <li class="sidebar-item">
                  <a href="{{ route('Hien-Thi-telegram') }}" class="sidebar-link">
                    <div class="round-16 d-flex align-items-center justify-content-center">

                    </div>
                    <span class="hide-menu">Telegram</span>
                  </a>
                </li>
                <a href="{{ route('Hien-Thi-vnpay') }}" class="sidebar-link">
                    <div class="round-16 d-flex align-items-center justify-content-center">

                    </div>
                    <span class="hide-menu">Vnpay</span>
                  </a>
                </li>
            </ul>
            </li>

          </ul>

        </nav>
        <!-- End Sidebar navigation -->
      </div>
      <!-- End Sidebar scroll-->
    </aside>
    <!--  Sidebar End -->
    <!--  Main wrapper -->
    <div class="body-wrapper">
      <!--  Header Start -->
      <header class="app-header">
        <nav class="navbar navbar-expand-lg navbar-light">
          <ul class="navbar-nav">
            <li class="nav-item d-block d-xl-none">
              <a class="nav-link sidebartoggler nav-icon-hover" id="headerCollapse" href="javascript:void(0)">
                <i class="ti ti-menu-2"></i>
              </a>
            </li>

          </ul>
          <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
            <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">

              <li class="nav-item dropdown">
                <a class="nav-link nav-icon-hover" href="javascript:void(0)" id="drop2" data-bs-toggle="dropdown"
                  aria-expanded="false">
                 <img src="{{ asset(Auth::user()->anh ? Auth::user()->anh : 'admin/images/profile/user-1.jpg') }}"
     alt="User Avatar" width="35" height="35" class="rounded-circle">

                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop2">
                  <div class="message-body">
                    {{-- <a href="javascript:void(0)" class="d-flex align-items-center gap-2 dropdown-item">
                      <i class="ti ti-user fs-6"></i>
                      <p class="mb-0 fs-3">My Profile</p>
                    </a> --}}

                      <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                        </form>
                    <a href="#" class="btn btn-outline-primary mx-3 mt-2 d-block"  onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Đăng xuất</a>
                  </div>
                </div>
              </li>
            </ul>
          </div>
        </nav>
      </header>
      <!--  Header End -->
      <div
      @if(request()->is('admin/Tro-Chuyen.html'))
        class="container"
      @else
        class="container-fluid"
      @endif
      >

        @yield('noidung')

        @include('layouts.script')

      </div>
    </div>
  </div>
  <script src="{{ asset('admin/libs/jquery/dist/jquery.min.js')}}"></script>
  <script src="{{ asset('admin/libs/bootstrap/dist/js/bootstrap.bundle.min.js')}}"></script>
  <script src="{{ asset('admin/js/sidebarmenu.js')}}"></script>
  <script src="{{ asset('admin/js/app.min.js')}}"></script>
  <script src="{{ asset('admin/libs/apexcharts/dist/apexcharts.min.js')}}"></script>
  <script src="{{ asset('admin/libs/simplebar/dist/simplebar.js')}}"></script>
  <script src="{{ asset('admin/js/dashboard.js')}}"></script>

{{-- <script>
    var chartDataUrl = "{{ url('/admin/chart-data') }}"; // ✅ Gửi URL sang JS
     document.addEventListener("DOMContentLoaded", function () {
        fetch(chartDataUrl)
            .then(response => response.json())
            .then(data => {
                console.log(data);
                chart.updateOptions({
                    series: data.series,
                    xaxis: {
                        categories: data.categories
                    }
                });
            })
            .catch(error => console.error("Lỗi khi fetch API:", error));
    });
</script> --}}
</body>

</html>
