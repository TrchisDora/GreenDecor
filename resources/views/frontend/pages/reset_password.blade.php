@extends('frontend.layouts.master')
@section('title', 'Ecommerce Laravel || Reset Password')
@section('main-content')
    <!-- Page Header Start -->
    <div class="container-fluid bg-secondary">
        <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
            <h1 class="font-weight-semi-bold text-uppercase mb-3">Thay đổi mật khẩu</h1>
            <div class="d-inline-flex">
                <p class="m-0"><a href="{{ route('home') }}" class="text-dark">Trang chủ</a></p>
                <p class="m-0 px-2">-</p>
                <p class="m-0">Thay đổi mật khẩu</p>
            </div>
        </div>
    </div>
    <!-- End Page Header -->
    <!-- Reset Password Section -->
    <section class="shop-login section py-5 background-success-light">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6 col-md-8 col-12">
                    <div class="login-form shadow-lg p-4 rounded bg-white">
                        <!-- Reset Password Form with Updated Password Logic -->
                        <form method="POST" action="{{ route('email.reset.password') }}">
                            @csrf
                            @foreach ($errors->all() as $error)
                                <p class="text-danger">{{ $error }}</p>
                            @endforeach

                            <input type="hidden" name="token" value="{{ $token }}">
                            <input type="hidden" name="email" value="{{ request()->email }}">

                            <!-- New Password Field -->
                            <div class="mb-3">
                                <label for="new_password" class="form-label">Mật khẩu mới <span class="text-danger">*</span></label>
                                <input type="password" name="new_password" class="form-control @error('new_password') is-invalid @enderror" required placeholder="Nhập mật khẩu mới">
                                @error('new_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Confirm New Password Field -->
                            <div class="mb-3">
                                <label for="new_confirm_password" class="form-label">Xác nhận mật khẩu mới <span class="text-danger">*</span></label>
                                <input type="password" name="new_confirm_password" class="form-control @error('new_confirm_password') is-invalid @enderror" required placeholder="Nhập lại mật khẩu mới">
                                @error('new_confirm_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Submit Button -->
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary my-3 py-3 btn-block">Cập nhật mật khẩu</button>
                            </div>
                        </form>
                        <div class="text-center mt-3">
                            <p><a href="{{ route('login.form') }}" class="text-primary">Quay lại đăng nhập</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Reset Password Section -->
@endsection
