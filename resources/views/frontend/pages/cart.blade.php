@extends('frontend.layouts.master')
@section('title','GreenDecor || Giỏ hàng')
@section('main-content')
	<!-- Page Header Start -->
	<div class="container-fluid bg-secondary">
		<div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
			<h1 class="font-weight-semi-bold text-uppercase mb-3">Giỏ hàng</h1>
			<div class="d-inline-flex">
				<p class="m-0"><a href="{{ route('home') }}" class="text-dark">Trang chủ</a></p>
				<p class="m-0 px-2">-</p>
				<p class="m-0">Giỏ hàng</p>
			</div>
		</div>    
	</div>
	<!-- End Breadcrumbs -->

	<!-- Cart Start -->
	<div class="container-fluid pt-5">
		<div class="row px-xl-5">
			<div class="col-lg-8 table-responsive mb-5">
				<table class="table table-bordered text-center mb-0">
					<thead class="bg-secondary text-dark">
						<tr>
							<th>Sản phẩm</th>
							<th>Tên sản phẩm</th>
							<th>Giá</th>
							<th>Số lượng</th>
							<th>Tổng cộng</th>
							<th>Xóa</th>
						</tr>
					</thead>
					<tbody class="align-middle" id="cart_item_list">
						<form action="{{route('cart.update')}}" method="POST" id="cart-update-form">
							@csrf
							@if(Helper::getAllProductFromCart())
								@foreach(Helper::getAllProductFromCart() as $key=>$cart)
									@php
									$photo=explode(',',$cart->product['photo']);
									@endphp
									<tr>
										<td class="align-middle">
											<img src="{{$photo[0]}}" alt="{{$photo[0]}}" class="img-fluid rounded" style="max-height: 80px;">
										</td>
										<td class="align-middle">
										<a href="{{route('product-detail',$cart->product['slug'])}}" target="_blank">{{$cart->product['title']}}</a>
										<p class="text-muted small">{!!($cart['summary']) !!}</p>
										</td>
										<td class="align-middle cart_single_price">{{number_format($cart['price'])}} đ</td>
										<td class="align-middle">
											<div class="input-group quantity mx-auto" style="width: 100px;">
												<input type="number" name="quant[{{ $key }}]"
													class="form-control form-control-sm text-center border-primary"
													value="{{ $cart->quantity }}" min="1">
												<input type="hidden" name="qty_id[{{ $key }}]" value="{{ $cart->id }}">
											</div>
										</td>
										<td class="align-middle">{{number_format($cart['amount'])}} đ</td>
										<td class="align-middle">
											<a href="{{route('cart-delete',$cart->id)}}" class="btn btn-sm btn-danger">
												<i class="fas fa-times"></i>
											</a>
										</td>
									</tr>
								@endforeach
								<tr>
									<td colspan="4">
									<span class="text-danger" style="font-size:15px;">[Lưu ý: Khi cập nhật giỏ hàng thì áp dụng của Mã giảm giá (MGG) trước đó sẽ biển mất!]</span>
									</td>
									<td colspan="5" class="text-right">
										<button class="btn btn-primary" type="submit">Cập nhật giỏ hàng</button>
									</td>
								</tr>
							@else
								<tr>
									<td colspan="6" class="text-center">
									<div class="alert-warning text-center p-4 rounded-3 shadow-sm">
										Giỏ hàng của bạn đang trống. <a href="{{route('product-grids')}}" class="btn btn-sm btn-outline-success">Tiếp tục mua sắm</a>
									</div>
									</td>
								</tr>
							@endif
						</form>
					</tbody>
				</table>
			</div>
			<div class="col-lg-4">
				<form class="mb-5" action="{{route('coupon-store')}}" method="POST">
					@csrf
					<div class="input-group">
						<input type="text" name="code" class="form-control p-4" placeholder="Mã giảm giá">
						<div class="input-group-append">
							<button class="btn btn-primary">Áp dụng mã giảm giá</button>
						</div>
					</div>
				</form>
				<div class="card border-secondary mb-5">
					<div class="card-header bg-secondary border-0">
						<h4 class="font-weight-semi-bold m-0">Tổng giỏ hàng</h4>
					</div>
					<div class="card-body">
						{{-- Tổng tiền trước giảm --}}
						<div class="d-flex justify-content-between mb-3">
							<h6 class="font-weight-medium">Tạm tính</h6>
							<h6 class="font-weight-medium">{{ number_format(Helper::totalCartPrice()) }} đ</h6>
						</div>
						{{-- Nếu có coupon thì hiển thị phần giảm --}}
						@if(session()->has('coupon'))
						<div class="d-flex justify-content-between mb-3">
							<h6 class="font-weight-medium">Giảm giá ({{ Session::get('coupon')['code'] }})</h6>
							<h6 class="font-weight-medium text-success">- {{ number_format(Session::get('coupon')['value'], 2) }} đ</h6>
						</div>
						@endif
						{{-- Tổng tiền sau giảm --}}
						@php
							$total = Helper::totalCartPrice();
							$discount = session('coupon.value') ?? 0;
							$total_amount = Helper::totalCartPrice() - $discount;
						@endphp

						<div class="d-flex justify-content-between">
							<h6 class="font-weight-bold">Tổng cộng</h6>
							<h6 class="font-weight-bold">{{ number_format($total_amount) }} đ</h6>
						</div>
					</div>
					<div class="card-footer border-secondary bg-transparent">
						<div class="d-flex justify-content-between mt-2">
							<h5 class="font-weight-bold">Số tiền bạn phải trả</h5>
							<h5 class="font-weight-bold" id="order_total_price">
								{{number_format($total_amount ?? Helper::totalCartPrice())}} đ
							</h5>
						</div>
						<div class="button5 mt-3">
							<a href="{{route('checkout')}}" class="btn btn-block btn-primary my-3 py-3">Tiến hành thanh toán</a>
							<a href="{{route('product-grids')}}" class="btn btn-block btn-outline-success">Tiếp tục mua sắm</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<!-- Cart End -->

	<!-- Featured Start -->
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
					<h1 class="fa fa-shipping-fast text-primary m-0 mr-3"></h1>
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
	<!-- Featured End -->

	<!-- Start Shop Newsletter  -->
	@include('frontend.layouts.newsletter')
	<!-- End Shop Newsletter -->

@endsection
@push('styles')
	<style>
		li.shipping{
			display: inline-flex;
			width: 100%;
			font-size: 14px;
		}
		li.shipping .input-group-icon {
			width: 100%;
			margin-left: 10px;
		}
		.input-group-icon .icon {
			position: absolute;
			left: 20px;
			top: 0;
			line-height: 40px;
			z-index: 3;
		}
		.form-select {
			height: 30px;
			width: 100%;
		}
		.form-select .nice-select {
			border: none;
			border-radius: 0px;
			height: 40px;
			background: #f6f6f6 !important;
			padding-left: 45px;
			padding-right: 40px;
			width: 100%;
		}
		.list li{
			margin-bottom:0 !important;
		}
		.list li:hover{
			background:#F7941D !important;
			color:white !important;
		}
		.form-select .nice-select::after {
			top: 14px;
		}
	</style>
@endpush
@push('scripts')
	<script src="{{asset('frontend/js/nice-select/js/jquery.nice-select.min.js')}}"></script>
	<script src="{{ asset('frontend/js/select2/js/select2.min.js') }}"></script>
	<script>
		$(document).ready(function() { $("select.select2").select2(); });
  		$('select.nice-select').niceSelect();
	</script>
	<script>
		$(document).ready(function(){
			$('.shipping select[name=shipping]').change(function(){
				let cost = parseFloat( $(this).find('option:selected').data('price') ) || 0;
				let subtotal = parseFloat( $('.order_subtotal').data('price') );
				let coupon = parseFloat( $('.coupon_price').data('price') ) || 0;
				// alert(coupon);
				$('#order_total_price span').text('$'+(subtotal + cost-coupon).toFixed(2));
			});

		});	
	</script>
@endpush
