@extends('frontend.layouts.master')

@section('title', 'GreenDecor || Quên Mật Khẩu')

@section('main-content')
    <!-- Page Header Start -->
    <div class="container-fluid bg-secondary">
        <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
            <h1 class="font-weight-semi-bold text-uppercase mb-3">Quên Mật Khẩu</h1>
            <div class="d-inline-flex">
                <p class="m-0"><a href="{{ route('home') }}" class="text-dark">Trang Chủ</a></p>
                <p class="m-0 px-2">-</p>
                <p class="m-0">Quên Mật Khẩu</p>
            </div>
        </div>    
    </div>
    <!-- End Breadcrumbs -->
            
    <!-- Forgot Password Section -->
    <section class="shop-login section py-5 background-success-light">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6 col-md-8 col-12">
                    <div class="login-form shadow-lg p-4 rounded bg-white"> 
                        <!-- Form -->
                        <form action="{{ route('send.reset.link') }}" method="post">
                            @csrf
                            <div class="mb-3">
                                <label for="email" class="form-label">Email của bạn<span class="text-danger"> *</span></label>
                                <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" placeholder="Nhập email của bạn" required value="{{ old('email') }}">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-grid gap-2">
                                <button class="btn btn-block btn-primary my-3 py-3" type="submit">Gửi</button>
                            </div>
                        </form>
                        <div class="text-center mt-3">
                            <p><a href="{{route('login.form')}}" class="text-primary">Quay lại đăng nhập</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--/ End Forgot Password -->
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
