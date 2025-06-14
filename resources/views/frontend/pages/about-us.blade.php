@extends('frontend.layouts.master')

@section('title', 'GreenDecor || Giới thiệu')

@section('main-content')

<!-- Tiêu đề trang Start -->
<div class="container-fluid bg-secondary mb-5">
    <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
        <h1 class="font-weight-semi-bold text-uppercase mb-3">Về Chúng Tôi</h1>
        <div class="d-inline-flex">
            <p class="m-0"><a href="{{ route('home') }}" class="text-dark">Trang chủ</a></p>
            <p class="m-0 px-2">-</p>
            <p class="m-0">Về chúng tôi</p>
        </div>
    </div>
</div>
<!-- Tiêu đề trang End -->

<!-- Giới thiệu Start -->
@php
    $settings = DB::table('settings')->first();
@endphp

<div class="container-fluid pt-5">
    <div class="row px-xl-5">
        <div class="col-lg-6 col-md-12 col-12 mb-4">
            <h3>Chào mừng đến với <span class="text-primary">GreenDecor</span></h3>
            <p> {{ strip_tags($settings->description ?? 'Thông tin đang được cập nhật...') }}</p>
            <div class="mt-4">
                <a href="{{ route('blog') }}" class="btn btn-outline-dark mr-2">Blog của chúng tôi</a>
                <a href="{{ route('contact') }}" class="btn btn-dark">Liên hệ</a>
            </div>
        </div>
        <div class="col-lg-6 col-md-12 col-12 mb-4">
            <div class="position-relative overflow-hidden">
				<div class="container mb-5">
					<div class="embed-responsive embed-responsive-16by9">
						<iframe class="embed-responsive-item" src="https://www.youtube.com/embed/IJrug1Erp-E" allowfullscreen></iframe>
					</div>
				</div>
            </div>
        </div>
    </div>
</div>
<!-- Giới thiệu End -->

<!-- Dịch vụ của cửa hàng Start -->
<div class="container-fluid pt-5">
    <div class="row px-xl-5 pb-3">
        <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
            <div class="d-flex align-items-center border mb-4" style="padding: 30px;">
                <h1 class="fa fa-check text-primary m-0 mr-3"></h1>
                <h5 class="font-weight-semi-bold m-0">Sản phẩm chất lượng</h5>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
            <div class="d-flex align-items-center border mb-4" style="padding: 30px;">
                <h1 class="fa fa-shipping-fast text-primary m-0 mr-2"></h1>
                <h5 class="font-weight-semi-bold m-0">Miễn phí giao hàng</h5>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
            <div class="d-flex align-items-center border mb-4" style="padding: 30px;">
                <h1 class="fas fa-exchange-alt text-primary m-0 mr-3"></h1>
                <h5 class="font-weight-semi-bold m-0">Đổi trả trong 14 ngày</h5>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
            <div class="d-flex align-items-center border mb-4" style="padding: 30px;">
                <h1 class="fa fa-phone-volume text-primary m-0 mr-3"></h1>
                <h5 class="font-weight-semi-bold m-0">Hỗ trợ 24/7</h5>
            </div>
        </div>
    </div>
</div>
<!-- Dịch vụ của cửa hàng End -->

@include('frontend.layouts.newsletter')

@endsection
