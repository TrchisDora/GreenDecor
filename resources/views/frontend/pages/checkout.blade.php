@extends('frontend.layouts.master')

@section('title','Checkout page')

@section('main-content')

    <!-- Page Header Start -->
    <div class="container-fluid bg-secondary">
        <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
            <h1 class="font-weight-semi-bold text-uppercase mb-3">CheckOut</h1>
            <div class="d-inline-flex">
                <p class="m-0"><a href="{{ route('home') }}" class="text-dark">Home</a></p>
                <p class="m-0 px-2">-</p>
                <p class="m-0">CheckOut</p>
            </div>
        </div>	
    </div>
    <!-- End Breadcrumbs -->
            
    <!-- Start Checkout -->
    <section class="shop checkout section">
    <form method="POST" action="{{route('cart.order')}}">
    @csrf
    <div class="container-fluid pt-5">
        <div class="row px-xl-5">
            <div class="col-lg-8">
                <div class="mb-4">
                    <h4 class="font-weight-semi-bold mb-4">Billing Address</h4>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>First Name<span>*</span></label>
                            <input class="form-control" type="text" name="first_name" placeholder="John" value="{{old('first_name')}}" required>
                            @error('first_name')
                                <span class='text-danger'>{{$message}}</span>
                            @enderror
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Last Name<span>*</span></label>
                            <input class="form-control" type="text" name="last_name" placeholder="Doe" value="{{old('last_name')}}" required>
                            @error('last_name')
                                <span class='text-danger'>{{$message}}</span>
                            @enderror
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Email Address<span>*</span></label>
                            <input class="form-control" type="email" name="email" placeholder="example@email.com" value="{{old('email')}}" required>
                            @error('email')
                                <span class='text-danger'>{{$message}}</span>
                            @enderror
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Phone Number<span>*</span></label>
                            <input class="form-control" type="number" name="phone" placeholder="+123 456 789" value="{{old('phone')}}" required>
                            @error('phone')
                                <span class='text-danger'>{{$message}}</span>
                            @enderror
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Country<span>*</span></label>
                            <select name="country" class="form-control custom-select" id="country" required>
                                    <option value="AF">Afghanistan</option>
                                                    <option value="AX">Åland Islands</option>
                                                    <option value="AL">Albania</option>
                                                    <option value="DZ">Algeria</option>
                                                    <option value="AS">American Samoa</option>
                                                    <option value="AD">Andorra</option>
                                                    <option value="AO">Angola</option>
                                                    <option value="AI">Anguilla</option>
                                                    <option value="AQ">Antarctica</option>
                                                    <option value="AG">Antigua and Barbuda</option>
                                                    <option value="AR">Argentina</option>
                                                    <option value="AM">Armenia</option>
                                                    <option value="AW">Aruba</option>
                                                    <option value="AU">Australia</option>
                                                    <option value="AT">Austria</option>
                                                    <option value="AZ">Azerbaijan</option>
                                                    <option value="BS">Bahamas</option>
                                                    <option value="BH">Bahrain</option>
                                                    <option value="BD">Bangladesh</option>
                                                    <option value="BB">Barbados</option>
                                                    <option value="BY">Belarus</option>
                                                    <option value="BE">Belgium</option>
                                                    <option value="BZ">Belize</option>
                                                    <option value="BJ">Benin</option>
                                                    <option value="BM">Bermuda</option>
                                                    <option value="BT">Bhutan</option>
                                                    <option value="BO">Bolivia</option>
                                                    <option value="BA">Bosnia and Herzegovina</option>
                                                    <option value="BW">Botswana</option>
                                                    <option value="BV">Bouvet Island</option>
                                                    <option value="BR">Brazil</option>
                                                    <option value="IO">British Indian Ocean Territory</option>
                                                    <option value="VG">British Virgin Islands</option>
                                                    <option value="BN">Brunei</option>
                                                    <option value="BG">Bulgaria</option>
                                                    <option value="BF">Burkina Faso</option>
                                                    <option value="BI">Burundi</option>
                                                    <option value="KH">Cambodia</option>
                                                    <option value="CM">Cameroon</option>
                                                    <option value="CA">Canada</option>
                                                    <option value="CV">Cape Verde</option>
                                                    <option value="KY">Cayman Islands</option>
                                                    <option value="CF">Central African Republic</option>
                                                    <option value="TD">Chad</option>
                                                    <option value="CL">Chile</option>
                                                    <option value="CN">China</option>
                                                    <option value="CX">Christmas Island</option>
                                                    <option value="CC">Cocos [Keeling] Islands</option>
                                                    <option value="CO">Colombia</option>
                                                    <option value="KM">Comoros</option>
                                                    <option value="CG">Congo - Brazzaville</option>
                                                    <option value="CD">Congo - Kinshasa</option>
                                                    <option value="CK">Cook Islands</option>
                                                    <option value="CR">Costa Rica</option>
                                                    <option value="CI">Côte d’Ivoire</option>
                                                    <option value="HR">Croatia</option>
                                                    <option value="CU">Cuba</option>
                                                    <option value="CY">Cyprus</option>
                                                    <option value="CZ">Czech Republic</option>
                                                    <option value="DK">Denmark</option>
                                                    <option value="DJ">Djibouti</option>
                                                    <option value="DM">Dominica</option>
                                                    <option value="DO">Dominican Republic</option>
                                                    <option value="EC">Ecuador</option>
                                                    <option value="EG">Egypt</option>
                                                    <option value="SV">El Salvador</option>
                                                    <option value="GQ">Equatorial Guinea</option>
                                                    <option value="ER">Eritrea</option>
                                                    <option value="EE">Estonia</option>
                                                    <option value="ET">Ethiopia</option>
                                                    <option value="FK">Falkland Islands</option>
                                                    <option value="FO">Faroe Islands</option>
                                                    <option value="FJ">Fiji</option>
                                                    <option value="FI">Finland</option>
                                                    <option value="FR">France</option>
                                                    <option value="GF">French Guiana</option>
                                                    <option value="PF">French Polynesia</option>
                                                    <option value="TF">French Southern Territories</option>
                                                    <option value="GA">Gabon</option>
                                                    <option value="GM">Gambia</option>
                                                    <option value="GE">Georgia</option>
                                                    <option value="DE">Germany</option>
                                                    <option value="GH">Ghana</option>
                                                    <option value="GI">Gibraltar</option>
                                                    <option value="GR">Greece</option>
                                                    <option value="GL">Greenland</option>
                                                    <option value="GD">Grenada</option>
                                                    <option value="GP">Guadeloupe</option>
                                                    <option value="GU">Guam</option>
                                                    <option value="GT">Guatemala</option>
                                                    <option value="GG">Guernsey</option>
                                                    <option value="GN">Guinea</option>
                                                    <option value="GW">Guinea-Bissau</option>
                                                    <option value="GY">Guyana</option>
                                                    <option value="HT">Haiti</option>
                                                    <option value="HM">Heard Island and McDonald Islands</option>
                                                    <option value="HN">Honduras</option>
                                                    <option value="HK">Hong Kong SAR China</option>
                                                    <option value="HU">Hungary</option>
                                                    <option value="IS">Iceland</option>
                                                    <option value="IN">India</option>
                                                    <option value="ID">Indonesia</option>
                                                    <option value="IR">Iran</option>
                                                    <option value="IQ">Iraq</option>
                                                    <option value="IE">Ireland</option>
                                                    <option value="IM">Isle of Man</option>
                                                    <option value="IL">Israel</option>
                                                    <option value="IT">Italy</option>
                                                    <option value="JM">Jamaica</option>
                                                    <option value="JP">Japan</option>
                                                    <option value="JE">Jersey</option>
                                                    <option value="JO">Jordan</option>
                                                    <option value="KZ">Kazakhstan</option>
                                                    <option value="KE">Kenya</option>
                                                    <option value="KI">Kiribati</option>
                                                    <option value="KW">Kuwait</option>
                                                    <option value="KG">Kyrgyzstan</option>
                                                    <option value="LA">Laos</option>
                                                    <option value="LV">Latvia</option>
                                                    <option value="LB">Lebanon</option>
                                                    <option value="LS">Lesotho</option>
                                                    <option value="LR">Liberia</option>
                                                    <option value="LY">Libya</option>
                                                    <option value="LI">Liechtenstein</option>
                                                    <option value="LT">Lithuania</option>
                                                    <option value="LU">Luxembourg</option>
                                                    <option value="MO">Macau SAR China</option>
                                                    <option value="MK">Macedonia</option>
                                                    <option value="MG">Madagascar</option>
                                                    <option value="MW">Malawi</option>
                                                    <option value="MY">Malaysia</option>
                                                    <option value="MV">Maldives</option>
                                                    <option value="ML">Mali</option>
                                                    <option value="MT">Malta</option>
                                                    <option value="MH">Marshall Islands</option>
                                                    <option value="MQ">Martinique</option>
                                                    <option value="MR">Mauritania</option>
                                                    <option value="MU">Mauritius</option>
                                                    <option value="YT">Mayotte</option>
                                                    <option value="MX">Mexico</option>
                                                    <option value="FM">Micronesia</option>
                                                    <option value="MD">Moldova</option>
                                                    <option value="MC">Monaco</option>
                                                    <option value="MN">Mongolia</option>
                                                    <option value="ME">Montenegro</option>
                                                    <option value="MS">Montserrat</option>
                                                    <option value="MA">Morocco</option>
                                                    <option value="MZ">Mozambique</option>
                                                    <option value="MM">Myanmar [Burma]</option>
                                                    <option value="NA">Namibia</option>
                                                    <option value="NR">Nauru</option>
                                                    <option value="NP">Nepal</option>
                                                    <option value="NL">Netherlands</option>
                                                    <option value="AN">Netherlands Antilles</option>
                                                    <option value="NC">New Caledonia</option>
                                                    <option value="NZ">New Zealand</option>
                                                    <option value="NI">Nicaragua</option>
                                                    <option value="NE">Niger</option>
                                                    <option value="NG">Nigeria</option>
                                                    <option value="NU">Niue</option>
                                                    <option value="NF">Norfolk Island</option>
                                                    <option value="MP">Northern Mariana Islands</option>
                                                    <option value="KP">North Korea</option>
                                                    <option value="NO">Norway</option>
                                                    <option value="OM">Oman</option>
                                                    <option value="PK">Pakistan</option>
                                                    <option value="PW">Palau</option>
                                                    <option value="PS">Palestinian Territories</option>
                                                    <option value="PA">Panama</option>
                                                    <option value="PG">Papua New Guinea</option>
                                                    <option value="PY">Paraguay</option>
                                                    <option value="PE">Peru</option>
                                                    <option value="PH">Philippines</option>
                                                    <option value="PN">Pitcairn Islands</option>
                                                    <option value="PL">Poland</option>
                                                    <option value="PT">Portugal</option>
                                                    <option value="PR">Puerto Rico</option>
                                                    <option value="QA">Qatar</option>
                                                    <option value="RE">Réunion</option>
                                                    <option value="RO">Romania</option>
                                                    <option value="RU">Russia</option>
                                                    <option value="RW">Rwanda</option>
                                                    <option value="BL">Saint Barthélemy</option>
                                                    <option value="SH">Saint Helena</option>
                                                    <option value="KN">Saint Kitts and Nevis</option>
                                                    <option value="LC">Saint Lucia</option>
                                                    <option value="MF">Saint Martin</option>
                                                    <option value="PM">Saint Pierre and Miquelon</option>
                                                    <option value="VC">Saint Vincent and the Grenadines</option>
                                                    <option value="WS">Samoa</option>
                                                    <option value="SM">San Marino</option>
                                                    <option value="ST">São Tomé and Príncipe</option>
                                                    <option value="SA">Saudi Arabia</option>
                                                    <option value="SN">Senegal</option>
                                                    <option value="RS">Serbia</option>
                                                    <option value="SC">Seychelles</option>
                                                    <option value="SL">Sierra Leone</option>
                                                    <option value="SG">Singapore</option>
                                                    <option value="SK">Slovakia</option>
                                                    <option value="SI">Slovenia</option>
                                                    <option value="SB">Solomon Islands</option>
                                                    <option value="SO">Somalia</option>
                                                    <option value="ZA">South Africa</option>
                                                    <option value="GS">South Georgia</option>
                                                    <option value="KR">South Korea</option>
                                                    <option value="ES">Spain</option>
                                                    <option value="LK">Sri Lanka</option>
                                                    <option value="SD">Sudan</option>
                                                    <option value="SR">Suriname</option>
                                                    <option value="SJ">Svalbard and Jan Mayen</option>
                                                    <option value="SZ">Swaziland</option>
                                                    <option value="SE">Sweden</option>
                                                    <option value="CH">Switzerland</option>
                                                    <option value="SY">Syria</option>
                                                    <option value="TW">Taiwan</option>
                                                    <option value="TJ">Tajikistan</option>
                                                    <option value="TZ">Tanzania</option>
                                                    <option value="TH">Thailand</option>
                                                    <option value="TL">Timor-Leste</option>
                                                    <option value="TG">Togo</option>
                                                    <option value="TK">Tokelau</option>
                                                    <option value="TO">Tonga</option>
                                                    <option value="TT">Trinidad and Tobago</option>
                                                    <option value="TN">Tunisia</option>
                                                    <option value="TR">Turkey</option>
                                                    <option value="TM">Turkmenistan</option>
                                                    <option value="TC">Turks and Caicos Islands</option>
                                                    <option value="TV">Tuvalu</option>
                                                    <option value="UG">Uganda</option>
                                                    <option value="UA">Ukraine</option>
                                                    <option value="AE">United Arab Emirates</option>
                                                    <option value="Uk">United Kingdom</option>
                                                    <option value="US" selected>United States</option>
                                                    <option value="UY">Uruguay</option>
                                                    <option value="UM">U.S. Minor Outlying Islands</option>
                                                    <option value="VI">U.S. Virgin Islands</option>
                                                    <option value="UZ">Uzbekistan</option>
                                                    <option value="VU">Vanuatu</option>
                                                    <option value="VA">Vatican City</option>
                                                    <option value="VE">Venezuela</option>
                                                    <option value="VN">Vietnam</option>
                                                    <option value="WF">Wallis and Futuna</option>
                                                    <option value="EH">Western Sahara</option>
                                                    <option value="YE">Yemen</option>
                                                    <option value="ZM">Zambia</option>
                                                    <option value="ZW">Zimbabwe</option>
                                </select>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Address Line 1<span>*</span></label>
                            <input class="form-control" type="text" name="address1" placeholder="123 Street" value="{{old('address1')}}" required>
                            @error('address1')
                                <span class='text-danger'>{{$message}}</span>
                            @enderror
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Address Line 2</label>
                            <input class="form-control" type="text" name="address2" placeholder="Apartment or suite" value="{{old('address2')}}">
                            @error('address2')
                                <span class='text-danger'>{{$message}}</span>
                            @enderror
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Postal Code</label>
                            <input class="form-control" type="text" name="post_code" placeholder="12345" value="{{old('post_code')}}">
                            @error('post_code')
                                <span class='text-danger'>{{$message}}</span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card border-secondary mb-5">
                    <div class="card-header bg-secondary border-0">
                        <h4 class="font-weight-semi-bold m-0">Order Summary</h4>
                    </div>
                    <div class="card-body">
                        <h5 class="font-weight-medium mb-3">Products</h5>
                        @foreach(Helper::getAllProductFromCart() as $cart)
                        <div class="d-flex justify-content-between">
                            <p>{{$cart->product->title}} (x{{$cart->quantity}})</p>
                            <p>${{number_format($cart->amount,2)}}</p>
                        </div>
                        @endforeach
                        <hr class="mt-0">
                        <div class="d-flex justify-content-between mb-3 pt-1">
                            <h6 class="font-weight-medium">Subtotal</h6>
                            <h6 class="font-weight-medium">${{number_format(Helper::totalCartPrice(),2)}}</h6>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-5 pt-1">
                            <h6 class="font-weight-medium mb-0 mr-3">Shipping</h6>
                            @if(count(Helper::shipping()) > 0 && Helper::cartCount() > 0)
                                <select name="shipping" class="form-control custom-select" required>
                                    <option value="" disabled selected>Select Shipping Method</option>
                                    @foreach(Helper::shipping() as $shipping)
                                        <option value="{{$shipping->id}}" data-price="{{$shipping->price}}">
                                            {{$shipping->type}} - ${{$shipping->price}}
                                        </option>
                                    @endforeach
                                </select>
                            @else 
                                <h6 class="font-weight-medium mb-0">Free</h6>
                            @endif
                        </div>

                        @if(session('coupon'))
                        <div class="d-flex justify-content-between">
                            <h6 class="font-weight-medium">Coupon Discount</h6>
                            <h6 class="font-weight-medium">-${{number_format(session('coupon')['value'],2)}}</h6>
                        </div>
                        @endif
                    </div>
                    <div class="card-footer border-secondary bg-transparent">
                        <div class="d-flex justify-content-between mt-2">
                            <h5 class="font-weight-bold">Total</h5>
                            <h5 class="font-weight-bold">${{number_format(Helper::totalCartPrice() - (session('coupon')['value'] ?? 0),2)}}</h5>
                        </div>
                    </div>
                </div>
                
                <div class="card border-secondary mb-5">
                    <div class="card-header bg-secondary border-0">
                        <h4 class="font-weight-semi-bold m-0">Payment</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <div class="custom-control custom-radio">
                                <input type="radio" class="custom-control-input" name="payment_method" id="cod" value="cod" required>
                                <label class="custom-control-label" for="cod">Cash On Delivery</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-radio">
                                <input type="radio" class="custom-control-input" name="payment_method" id="cardpay" value="cardpay">
                                <label class="custom-control-label" for="cardpay">Card Payment</label>
                            </div>
                            <!-- Payment Method Widget -->
                                <div class="single-widget payement mt-3">
                                    <div class="content">
                                        <img src="{{('backend/img/payment-method.png')}}" alt="#">
                                    </div>
                                </div>
                                <!--/ End Payment Method Widget --></div>
                            <div id="creditCardDetails" class="mt-3" style="display:none;">
                                <div class="form-group">
                                    <label>Card Number</label>
                                    <input type="text" class="form-control" name="card_number" maxlength="16">
                                </div>
                                <div class="form-group">
                                    <label>Name on Card</label>
                                    <input type="text" class="form-control" name="card_name">
                                </div>
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label>Expiration Date</label>
                                        <input type="text" class="form-control" name="expiration_date" placeholder="MM/YY" maxlength="5">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label>CVV</label>
                                        <input type="text" class="form-control" name="cvv" maxlength="3">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer border-secondary bg-transparent">
                        <button type="submit" class="btn btn-lg btn-block btn-primary font-weight-bold my-3 py-3">Place Order</button>
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
		<!-- Featured End -->

	<!-- Start Shop Newsletter  -->
	@include('frontend.layouts.newsletter')
	<!-- End Shop Newsletter -->
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

@endpush