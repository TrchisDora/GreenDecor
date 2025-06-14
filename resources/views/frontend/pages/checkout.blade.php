@extends('frontend.layouts.master')

@section('title','Checkout page')

@section('main-content')

    <!-- Page Header Start -->
    <div class="container-fluid bg-secondary">
        <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
            <h1 class="font-weight-semi-bold text-uppercase mb-3">Thanh Toán</h1>
            <div class="d-inline-flex">
                <p class="m-0"><a href="{{ route('home') }}" class="text-dark">Trang chủ</a></p>
                <p class="m-0 px-2">-</p>
                <p class="m-0">Thanh Toán</p>
            </div>
        </div>    
    </div>
    <!-- End Breadcrumbs -->
                
<!-- Start Checkout -->
<section class="shop checkout section">
<form method="POST" action="{{ route('cart.order') }}">
@csrf
<div class="container-fluid pt-5">
    <div class="row px-xl-5">
        <div class="col-lg-8">
            <div class="mb-4">
                <h4 class="font-weight-semi-bold mb-4">Địa chỉ thanh toán</h4>
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label>Họ<span>*</span></label>
                        <input class="form-control" type="text" name="first_name" placeholder="John" value="{{ old('first_name') }}" required>
                        @error('first_name')
                            <span class='text-danger'>{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Tên<span>*</span></label>
                        <input class="form-control" type="text" name="last_name" placeholder="Doe" value="{{ old('last_name') }}" required>
                        @error('last_name')
                            <span class='text-danger'>{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Địa chỉ email<span>*</span></label>
                        <input class="form-control" type="email" name="email" placeholder="example@email.com" value="{{ old('email') }}" required>
                        @error('email')
                            <span class='text-danger'>{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Số điện thoại<span>*</span></label>
                        <input class="form-control" type="text" name="phone" placeholder="+123 456 789" value="{{ old('phone') }}" required>
                        @error('phone')
                            <span class='text-danger'>{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Quốc gia<span>*</span></label>
                        <select name="country" class="form-control custom-select" id="country" required>
                            <option value="VN">Việt Nam</option>
                        </select>
                    </div>
                </div>

                <!-- Thông tin vận chuyển -->
                <div id="shippingInputs" class="mt-4 border p-3 rounded bg-light" style="display: none;">
                    <h4 class="font-weight-bold mb-3">Thông tin vận chuyển đã chọn</h4>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>Địa chỉ 1 <span class="text-danger">*</span></label>
                            <input class="form-control" type="text" name="shipping_address1" id="shippingAddress1" readonly value="{{ old('address1') }}" required>
                            @error('address1')
                                <span class='text-danger'>{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Địa chỉ 2</label>
                            <input class="form-control" type="text" name="shipping_address2" id="shippingAddress2" readonly value="{{ old('address2') }}">
                            <input type="hidden" id="province_name" name="province_name" value="">
                            @error('address2')
                                <span class='text-danger'>{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-6 form-group">
                            <label>Mã bưu điện <span class="text-danger">*</span></label>
                            <input class="form-control" name="shipping_postcode" id="shippingPostCode" readonly value="{{ old('post_code') }}">
                            @error('post_code')
                                <span class='text-danger'>{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-6 form-group">
                            <label>Phương thức vận chuyển</label>
                            <input type="text" class="form-control" name="shipping_method" id="shippingMethod" readonly>
                            <input type="hidden" id="shippingIdInput" name="shipping_id" value="">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Phí vận chuyển</label>
                            <input type="text" class="form-control" name="shipping_price" id="shippingPriceInput" readonly>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tóm tắt đơn hàng -->
        <div class="col-lg-4">
            <div class="card border-secondary mb-5">
                <div class="card-header bg-secondary border-0">
                    <h4 class="font-weight-semi-bold m-0">Tóm tắt giỏ hàng</h4>
                </div>
                <div class="card-body">
                    <h5 class="font-weight-medium mb-3">Sản phẩm</h5>
                    @foreach(Helper::getAllProductFromCart() as $cart)
                    <div class="d-flex justify-content-between">
                        <p>{{ $cart->product->title }} (x{{ $cart->quantity }})</p>
                        <p>${{ number_format($cart->amount, 2) }}</p>
                    </div>
                    @endforeach
                    <hr class="mt-0">
                    <div class="d-flex justify-content-between mb-3 pt-1">
                        <h6 class="font-weight-medium">Tổng tiền</h6>
                        <h6 class="font-weight-medium">${{ number_format(Helper::totalCartPrice(), 2) }}</h6>
                    </div>
                    @if(session('coupon'))
                    <div class="d-flex justify-content-between">
                        <h6 class="font-weight-medium">Giảm giá mã giảm</h6>
                        <h6 class="font-weight-medium">-${{ number_format(session('coupon')['value'], 2) }}</h6>
                    </div>
                    @endif
                    <div class="d-flex justify-content-between align-items-center mb-5 pt-1">
                        <h6 class="font-weight-medium mb-0 mr-3">Vận chuyển</h6>
                        <a data-toggle="modal" data-target="#shippingModal" class="btn btn-outline-primary btn-sm mb-2">
                            <i class="ti-truck mr-2"></i> Chọn phương thức vận chuyển
                        </a>
                    </div>
                    <div class="form-group">
                        <p id="shippingPrice" class="font-weight-bold text-info"></p>
                    </div>
                    <div class="card-footer border-secondary bg-transparent">
                        <div class="d-flex justify-content-between mt-2">
                            <h5 class="font-weight-bold">Tổng cộng</h5>
                            <h5 class="font-weight-bold" id="totalPrice">
                                {{ number_format(Helper::totalCartPrice() - (session('coupon')['value'] ?? 0), 0, ',', '.') }} đ
                            </h5>
                        </div>
                    </div>
                </div>
                </div>
                <div class="card border-secondary mb-5">
                    <div class="card-header bg-secondary border-0">
                        <h4 class="font-weight-semi-bold m-0">Phương thức thanh toán</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <div class="custom-control custom-radio">
                                <input type="radio" class="custom-control-input" name="payment_method" id="cod" value="cod" required>
                                <label class="custom-control-label" for="cod">Thanh toán khi nhận hàng</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-radio">
                                <input type="radio" class="custom-control-input" name="payment_method" id="vnpay" value="vnpay">
                                <label class="custom-control-label" for="vnpay">Thanh toán qua VNPay</label>
                            </div>
                        </div>
                        <!-- Payment Method Widget -->
                                <div class="single-widget payement mt-3 mb-3">
                                    <div class="content">
                                        <img src="{{('backend/img/payment_vnpay.png')}}" alt="#" style="width: 150px; height: auto;">

                                    </div>
                                </div>
                                <!--/ End Payment Method Widget -->
                    </div>
                    <div class="card-footer border-secondary bg-transparent">
                        <button type="submit" class="btn btn-lg btn-block btn-primary font-weight-bold my-3 py-3">Thanh toán</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </form>
    <!-- Checkout End -->
    </section>

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


<!-- Modal -->
<div class="modal fade" id="shippingModal" tabindex="-1" role="dialog" aria-labelledby="shippingModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content border-0">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title">Chọn thông tin vận chuyển</h5>
        <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
      </div>

      <div class="modal-body">
        <div class="form-group">
          <label>Địa chỉ dòng 1 <span class="text-danger">*</span></label>
          <input class="form-control" type="text" name="address1" placeholder="123 Đường ABC" value="{{ old('address1') }}" required>
          @error('address1')
            <span class='text-danger'>{{$message}}</span>
          @enderror
        </div>
        <div class="row">
          <div class="col-md-4 form-group">
            <label>Tỉnh / Thành phố</label>
            <select class="form-control" id="province" required>
              <option value="">-- Chọn Tỉnh --</option>
            </select>
          </div>

          <div class="col-md-4 form-group">
            <label>Quận / Huyện</label>
            <select class="form-control" id="district" disabled>
              <option value="">-- Chọn Quận --</option>
            </select>
          </div>

          <div class="col-md-4 form-group">
            <label>Phường / Xã</label>
            <select class="form-control" id="ward" disabled>
              <option value="">-- Chọn Phường --</option>
            </select>
          </div>
        </div>

        <input type="hidden" name="address2" id="address2" value="{{ old('address2') }}">
        @error('address2')
          <span class='text-danger'>{{$message}}</span>
        @enderror

        <div class="row">
          <div class="col-md-6 form-group">
            <label>Mã bưu chính</label>
            <input class="form-control" type="text" name="post_code" placeholder="12345" value="{{ old('post_code') }}">
            @error('post_code')
              <span class='text-danger'>{{$message}}</span>
            @enderror
          </div>

          <div class="col-md-6 form-group">
            <label>Phương thức vận chuyển</label>
            @if(count(Helper::shipping()) > 0 && Helper::cartCount() > 0)
              <select name="shipping" class="form-control" id="shippingSelect" required>
                <option value="" disabled selected>-- Chọn phương thức --</option>
                @foreach(Helper::shipping() as $shipping)
                  <option value="{{ $shipping->id }}">{{ $shipping->type }} - {{ $shipping->Name }}</option>
                @endforeach
              </select>
            @else
              <p class="mt-2 text-muted">Miễn phí vận chuyển</p>
            @endif
          </div>
        </div>
      </div>

      <div class="modal-footer bg-light">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
        <button type="button" class="btn btn-primary" id="confirmShippingBtn">Áp dụng</button>
      </div>
    </div>
  </div>
</div>


@endsection
@push('styles')
	<style>
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
		function showMe(box){
			var checkbox=document.getElementById('shipping').style.display;
			// alert(checkbox);
			var vis= 'none';
			if(checkbox=="none"){
				vis='block';
			}
			if(checkbox=="block"){
				vis="none";
			}
			document.getElementById(box).style.display=vis;
		}
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

<script>
    $(document).ready(function() {
        $('input[name="payment_method"]').change(function() {
            if ($(this).val() === 'cardpay') {
                $('#creditCardDetails').show();
            } else {
                $('#creditCardDetails').hide();
            }
        });
    });
</script>
<script>
    // Show/hide credit card details
    document.querySelectorAll('input[name="payment_method"]').forEach(el => {
        el.addEventListener('change', function() {
            document.getElementById('creditCardDetails').style.display = 
                this.value === 'cardpay' ? 'block' : 'none';
        });
    });
</script>

<script>
    const provinceEl = document.getElementById('province');
    const districtEl = document.getElementById('district');
    const wardEl = document.getElementById('ward');
    const address2El = document.getElementById('address2');

    async function loadProvinces() {
        const res = await fetch('https://provinces.open-api.vn/api/?depth=1');
        const provinces = await res.json();
        provinces.forEach(p => {
            const opt = document.createElement('option');
            opt.value = p.code;
            opt.textContent = p.name;
            provinceEl.appendChild(opt);
        });
    }

    async function loadDistricts(provinceCode) {
        const res = await fetch(`https://provinces.open-api.vn/api/p/${provinceCode}?depth=2`);
        const province = await res.json();
        districtEl.innerHTML = '<option value="">Chọn Quận/Huyện</option>';
        wardEl.innerHTML = '<option value="">Chọn Xã/Phường</option>';
        districtEl.disabled = false;
        wardEl.disabled = true;

        province.districts.forEach(d => {
            const opt = document.createElement('option');
            opt.value = JSON.stringify({name: d.name, code: d.code});
            opt.textContent = d.name;
            districtEl.appendChild(opt);
        });
    }

    async function loadWards(districtCode) {
        const res = await fetch(`https://provinces.open-api.vn/api/d/${districtCode}?depth=2`);
        const district = await res.json();
        wardEl.innerHTML = '<option value="">Chọn Xã/Phường</option>';
        wardEl.disabled = false;

        district.wards.forEach(w => {
            const opt = document.createElement('option');
            opt.value = w.name;
            opt.textContent = w.name;
            wardEl.appendChild(opt);
        });
    }

    // Xử lý chọn tỉnh
    provinceEl.addEventListener('change', (e) => {
        const provinceName = provinceEl.options[provinceEl.selectedIndex].text;
        if (e.target.value) {
            loadDistricts(e.target.value);
            address2El.value = provinceName;
        } else {
            districtEl.disabled = true;
            wardEl.disabled = true;
            address2El.value = '';
        }
    });

    // Xử lý chọn quận
    districtEl.addEventListener('change', (e) => {
        const selectedDistrict = JSON.parse(e.target.value || '{}');
        const provinceName = provinceEl.options[provinceEl.selectedIndex].text;
        const districtName = selectedDistrict.name;

        if (selectedDistrict.code) {
            loadWards(selectedDistrict.code);
            address2El.value = districtName + ', ' + provinceName;
        } else {
            wardEl.disabled = true;
        }
    });

    // Xử lý chọn phường
    wardEl.addEventListener('change', (e) => {
        const wardName = e.target.value;
        const districtName = districtEl.options[districtEl.selectedIndex].text;
        const provinceName = provinceEl.options[provinceEl.selectedIndex].text;
        address2El.value = wardName + ', ' + districtName + ', ' + provinceName;
    });

    loadProvinces();
</script>
<script>
$('#confirmShippingBtn').click(function () {
    let address1 = $('input[name="address1"]').val(); 
    let post_code = $('input[name="post_code"]').val(); 
    let shippingText = $('#shippingSelect option:selected').text(); 

    let province = $('#province option:selected').text(); 
    let district = $('#district option:selected').text(); 
    let ward = $('#ward option:selected').text(); 
    let shippingId = $('#shippingSelect').val(); 
    if (province && district && ward && shippingId) {
        $.ajax({
            url: '{{ route("get.shipping.price") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                province: province,
                district: district,
                ward: ward,
                shipping_id: shippingId
            },
            success: function (response) {
                if (response.price !== undefined) {
                    let originalTotal = {{ Helper::totalCartPrice() - (session('coupon')['value'] ?? 0) }};
                    let shippingPrice = Number(response.price.toString().replace(/,/g, ''));
                    let newTotal = originalTotal + shippingPrice;
                    $('#shippingPrice').text('Phí vận chuyển: ' + shippingPrice.toLocaleString('vi-VN') + 'đ');
                    $('#hiddenShippingPrice').val(response.price); 
                    $('#totalPrice').text(newTotal.toLocaleString('vi-VN') + 'đ');
                    $('#shippingAddress1').val(address1);
                    $('#shippingAddress2').val(`${ward}, ${district}, ${province}`);
                    $('#province_name').val(province); 
                    $('#shippingPostCode').val(post_code);
                    $('#shippingMethod').val(shippingText);
                    $('#shippingIdInput').val(shippingId); 
                    $('#shippingPriceInput').val(shippingPrice);
                    $('#shippingInfoDisplay').show();
                    $('#shippingModal').modal('hide');
                    $('#shippingInputs').show();
                } else {
                    $('#shippingPrice').text('Không tìm thấy phí vận chuyển.');
                }
            },
            error: function () {
                $('#shippingPrice').text('Lỗi khi lấy giá vận chuyển.');
            }
        });
    } else {
        alert('Vui lòng chọn đầy đủ Tỉnh, Huyện, Xã và phương thức vận chuyển!');
    }
});
</script>
@endpush