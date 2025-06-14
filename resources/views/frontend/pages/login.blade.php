@extends('frontend.layouts.master')

@section('title','GreenDecor || Trang Đăng Nhập')

@section('main-content')
    <!-- Page Header Start -->
    <div class="container-fluid bg-secondary">
        <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
            <h1 class="font-weight-semi-bold text-uppercase mb-3">Đăng Nhập</h1>
            <div class="d-inline-flex">
                <p class="m-0"><a href="{{ route('home') }}" class="text-dark">Trang Chủ</a></p>
                <p class="m-0 px-2">-</p>
                <p class="m-0">Đăng Nhập</p>
            </div>
        </div>	
    </div>
    <!-- End Breadcrumbs -->
            
<!-- Shop Login -->
<section class="shop-login section py-5 background-success-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8 col-12">
                <div class="login-form shadow-lg p-4 rounded bg-white"> 
                    <!-- Form -->
                    <form method="post" action="{{ route('login.submit') }}">
                        @csrf
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
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <div class="form-check">
                                    <input type="checkbox" name="news" id="remember" class="form-check-input">
                                    <label class="form-check-label" for="remember">Ghi Nhớ Tôi</label>
                                </div>
                            </div>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.reset') }}" class="text-muted">Quên mật khẩu?</a>
                            @endif
                        </div>
                        <div class="d-grid gap-2">
                            <button class="btn btn-block btn-primary my-3 py-3" type="submit">Đăng Nhập</button>
                        </div>
                    </form>
                    <div class="text-center mt-3">
                        <p>Chưa có tài khoản? <a href="{{ route('register.form') }}" class="text-primary">Đăng Ký</a></p>
                    </div>
                    <!-- Uncomment below for Social Media Login -->
                    <!-- 
                    <div class="d-flex justify-content-center mt-3">
                        <a href="{{ route('login.redirect', 'facebook') }}" class="btn btn-facebook me-2"><i class="ti-facebook"></i> Đăng nhập bằng Facebook</a>
                        <a href="{{ route('login.redirect', 'google') }}" class="btn btn-google"><i class="ti-google"></i> Đăng nhập bằng Google</a>
                    </div> 
                    -->
                </div>
            </div>
        </div>
    </div>
</section>
<!--/ End Login -->

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
