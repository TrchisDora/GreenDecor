<!DOCTYPE html>
<html lang="vi">

<head>
  <title>GreenDecor - Bảng Đăng Nhập Quản Trị</title>
  @include('backend.layouts.head')

  <style>
    /* Đảm bảo ảnh nền chiếm toàn bộ chiều cao */
    .bg-login-image {
      position: relative;
      background-image: url('http://127.0.0.1:8000/storage/photos/1/blog/decor-phong-ngu-nho-dep-don-gian.jpg');
      background-size: cover; /* Làm cho ảnh bao phủ toàn bộ không gian */
      background-position: center;
    }

    /* Thêm lớp phủ mờ cho nền */
    .bg-overlay {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.5); /* Màu đen mờ */
      z-index: 5; /* Đảm bảo lớp phủ nằm trên ảnh nền */
    }

    /* Định vị logo trên nền mờ */
    .logo {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      z-index: 10; /* Đảm bảo logo hiển thị trên lớp phủ */
      max-width: 150px; /* Đặt kích thước tối đa cho logo */
    }
  </style>
</head>

<body class="bg-gradient-info">

  <div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

      <div class="col-xl-10 col-lg-12 col-md-9 mt-5">

        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row mb-0">
              <!-- Thêm ảnh và lớp phủ mờ -->
              <div class="col-lg-6 d-none d-lg-block bg-login-image">
                <!-- Lớp phủ mờ -->
                <div class="bg-overlay"></div>
                <!-- Logo -->
                <img src="http://127.0.0.1:8000/storage/photos/1/logo_icon.png" alt="Logo" class="logo" />
              </div>
              <div class="col-lg-6">
                <div class="p-5">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Bảng Đăng Nhập Quản Trị</h1>
                  </div>
                  <form class="user" method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="form-group">
                      <input type="email" class="form-control form-control-user @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Nhập Địa Chỉ Email..." required autocomplete="email">
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                      <input type="password" class="form-control form-control-user @error('password') is-invalid @enderror" id="exampleInputPassword" placeholder="Mật Khẩu" name="password" required autocomplete="current-password">
                         @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    
                    <button type="submit" class="btn btn-success btn-user btn-block">
                      Đăng Nhập
                    </button>
                  </form>
                  <hr>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>
<!-- Visit 'codeastro' for more projects -->
    </div>

  </div>
</body>

</html>
