<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Edu-book Login</title>
   @if(!empty($configData['logo']))
        <link rel="shortcut icon" type="image/png" href="{{ asset($configData['logo'])}}" />
                       @else
                            Chưa có
                        @endif
  <link rel="stylesheet" href="{{ asset('admin/css/styles.min.css') }}" />
</head>

<body>
  <!--  Body Wrapper -->
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">
    <div
      class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
      <div class="d-flex align-items-center justify-content-center w-100">
        <div class="row justify-content-center w-100">
          <div class="col-md-8 col-lg-6 col-xxl-3">
            <div class="card mb-0">
              <div class="card-body">
                <a href="{{ route('web.trang-chu') }}" class="text-nowrap logo-img text-center d-block py-3 w-100">
                    @if(!empty($configData['logo']))
                    <img src="{{asset($configData['logo'])}}" width="180" alt="">

                       @else
                            Chưa có
                        @endif
                </a>
                <p class="text-center"> Cội nguồn tri thức </p>
                  <form method="POST" action="{{ route('login') }}">
                    @csrf
                  <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Email</label>
                    <input type="email" class="form-control" id="exampleInputEmail1" name="email" aria-describedby="emailHelp">
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                  </div>
                  <div class="mb-4">
                    <label for="exampleInputPassword1" class="form-label">Mật khẩu</label>
                    <input type="password" class="form-control" name="password" id="exampleInputPassword1">
                     <x-input-error :messages="$errors->get('password')" class="mt-2" />
                  </div>
                  <div class="d-flex align-items-center justify-content-between mb-4">
                    <div class="form-check">
                      <input class="form-check-input primary" type="checkbox" id="remember_me"  name="remember" checked>
                      <label class="form-check-label text-dark" for="flexCheckChecked">
                        Lưu mật khẩu
                      </label>
                    </div>
                     @if (Route::has('password.request'))
                    <a class="text-primary fw-bold" href="{{ route('password.request') }}">Quên mật khẩu ?</a>
                     @endif
                  </div>
                  <button class="btn btn-primary w-100 py-8 fs-4 mb-4 rounded-2">Đăng nhập</button>
                  <div class="d-flex align-items-center justify-content-center">
                    <p class="fs-4 mb-0 fw-bold">Bạn chưa có tài khoản ?</p>
                    <a class="text-primary fw-bold ms-2" href="{{ route('register') }}">Tạo tài khoản</a>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
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
  <script src="{{ asset('admin/libs/jquery/dist/jquery.min.js') }}"></script>
  <script src="{{ asset('admin/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
</body>

</html>
