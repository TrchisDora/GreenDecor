@extends('frontend.layouts.master')

@section('title', 'Ecommerce Laravel || About Us')

@section('main-content')

<!-- Page Header Start -->
<div class="container-fluid bg-secondary mb-5">
    <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
        <h1 class="font-weight-semi-bold text-uppercase mb-3">About Us</h1>
        <div class="d-inline-flex">
            <p class="m-0"><a href="{{ route('home') }}" class="text-dark">Home</a></p>
            <p class="m-0 px-2">-</p>
            <p class="m-0">About Us</p>
        </div>
    </div>
</div>
<!-- Page Header End -->

<!-- About Us Start -->
@php
    $settings = DB::table('settings')->first();
@endphp

<div class="container-fluid pt-5">
    <div class="row px-xl-5">
        <div class="col-lg-6 col-md-12 col-12 mb-4">
            <h3>Welcome To <span class="text-primary">Ecommerce Laravel</span></h3>
            <p>{{ $settings->description ?? 'Thông tin đang được cập nhật...' }}</p>
            <div class="mt-4">
                <a href="{{ route('blog') }}" class="btn btn-outline-dark mr-2">Our Blog</a>
                <a href="{{ route('contact') }}" class="btn btn-dark">Contact Us</a>
            </div>
        </div>
        <div class="col-lg-6 col-md-12 col-12 mb-4">
            <div class="position-relative overflow-hidden">
				<div class="container mb-5">
					<h3 class="mb-3">Giới thiệu qua video</h3>
					<div class="embed-responsive embed-responsive-16by9">
						<iframe class="embed-responsive-item" src="https://www.youtube.com/embed/7edcgCdiHVU" allowfullscreen></iframe>
					</div>
				</div>
            </div>
        </div>
    </div>
</div>
<!-- About Us End -->

<!-- Shop Services Start -->
<div class="container-fluid pt-5">
        <div class="row px-xl-5 pb-3">
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="d-flex align-items-center border mb-4" style="padding: 30px;">
                    <h1 class="fa fa-check text-primary m-0 mr-3"></h1>
                    <h5 class="font-weight-semi-bold m-0">Quality Product</h5>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="d-flex align-items-center border mb-4" style="padding: 30px;">
                    <h1 class="fa fa-shipping-fast text-primary m-0 mr-2"></h1>
                    <h5 class="font-weight-semi-bold m-0">Free Shipping</h5>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="d-flex align-items-center border mb-4" style="padding: 30px;">
                    <h1 class="fas fa-exchange-alt text-primary m-0 mr-3"></h1>
                    <h5 class="font-weight-semi-bold m-0">14-Day Return</h5>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="d-flex align-items-center border mb-4" style="padding: 30px;">
                    <h1 class="fa fa-phone-volume text-primary m-0 mr-3"></h1>
                    <h5 class="font-weight-semi-bold m-0">24/7 Support</h5>
                </div>
            </div>
        </div>
    </div>
<!-- Shop Services End -->

@include('frontend.layouts.newsletter')

@endsection
