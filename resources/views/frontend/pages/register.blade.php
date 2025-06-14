@extends('frontend.layouts.master')

@section('title','GreenDecor || Trang Đăng Ký')

@section('main-content')
    <!-- Tiêu Đề Trang Bắt Đầu -->
    <div class="container-fluid bg-secondary">
        <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
            <h1 class="font-weight-semi-bold text-uppercase mb-3">Đăng Ký</h1>
            <div class="d-inline-flex">
                <p class="m-0"><a href="{{ route('home') }}" class="text-dark">Trang Chủ</a></p>
                <p class="m-0 px-2">-</p>
                <p class="m-0">Đăng Ký</p>
            </div>
        </div>	
    </div>
    <!-- Kết Thúc Tiêu Đề Trang -->

<!-- Đăng Ký Cửa Hàng -->
<section class="shop-register section py-5 background-success-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8 col-12">
                <div class="register-form shadow-lg p-4 rounded bg-white">
                    <!-- Form -->
                    <form method="post" action="{{ route('register.submit') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Tên Của Bạn<span class="text-danger">*</span></label>
                            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" placeholder="Nhập tên của bạn" required value="{{ old('name') }}">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Của Bạn<span class="text-danger">*</span></label>
                            <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" placeholder="Nhập email của bạn" required value="{{ old('email') }}">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Mật Khẩu Của Bạn<span class="text-danger">*</span></label>
                            <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" placeholder="Nhập mật khẩu của bạn" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Xác Nhận Mật Khẩu<span class="text-danger">*</span></label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" placeholder="Xác nhận mật khẩu của bạn" required>
                            @error('password_confirmation')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="d-grid gap-2 mb-3">
                            <button class="btn btn-block btn-primary my-3 py-3y" type="submit">Đăng Ký</button>
                        </div>
                        <div class="text-center">
                            <p>Bạn đã có tài khoản? <a href="{{ route('login.form') }}" class="text-primary">Quay lại Đăng Nhập</a></p>
                        </div>
                    </form>
                    <!--/ Kết Thúc Form -->
                </div>
            </div>
        </div>
    </div>
</section>
<!--/ Kết Thúc Đăng Ký -->

@endsection

@push('styles')
<style>
    .shop.login .form .btn{
        margin-right:0;
    }
    .btn-facebook{
        background:#39579A;
    }
    .btn-facebook:hover{
        background:#073088 !important;
    }
    .btn-github{
        background:#444444;
        color:white;
    }
    .btn-github:hover{
        background:black !important;
    }
    .btn-google{
        background:#ea4335;
        color:white;
    }
    .btn-google:hover{
        background:rgb(243, 26, 26) !important;
    }
</style>
@endpush
