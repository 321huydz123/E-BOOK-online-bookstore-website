<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Modernize Free</title>
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
               <form method="POST" action="{{ route('dang-ky.store') }}">
                  @csrf
                  <div class="mb-3">
                    <label for="exampleInputtext1" class="form-label">Tên đầy đủ</label>
                    <input type="text" class="form-control"  name="ten" id="exampleInputtext1" aria-describedby="textHelp">
                     <x-input-error :messages="$errors->get('ten')" class="mt-2" />
                  </div>
                  <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Địa chỉ email</label>
                    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"  name="email" >
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                  </div>
                  <div class="mb-4">
                    <label for="exampleInputPassword1" class="form-label">Mật khẩu</label>
                    <input type="password"   name="password" class="form-control" id="exampleInputPassword1">
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />

                  </div>
                  <div class="mb-4">
                    <label for="exampleInputPassword1" class="form-label"> Nhập lại mật khẩu</label>
                    <input type="password" class="form-control" name="password_confirmation" id="exampleInputPassword1">
                     <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                  </div>
                  <button class="btn btn-primary w-100 py-8 fs-4 mb-4 rounded-2">Đăng kí</button>
                  <div class="d-flex align-items-center justify-content-center">
                    <p class="fs-4 mb-0 fw-bold">Bạn đã có tài khoản ?</p>
                    <a class="text-primary fw-bold ms-2" href="{{ route('login') }}">Đăng nhập</a>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="{{ asset('admin/libs/jquery/dist/jquery.min.js') }}"></script>
  <script src="{{ asset('admin/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
</body>

</html>
