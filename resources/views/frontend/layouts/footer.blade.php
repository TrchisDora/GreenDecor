
	<!-- Footer Start -->
<div class="container-fluid bg-secondary text-dark pt-5">
    <div class="row px-xl-5 pt-5">
        <!-- Logo + Giới thiệu + Liên hệ nhanh -->
        <div class="col-lg-4 col-md-12 mb-5 pr-3 pr-xl-5">
        <div class="logo mb-4">
                    @php
                        $settings = DB::table('settings')->get();
                    @endphp                    
                    <a href="{{ route('home') }}">
                        <img src="@foreach($settings as $data){{ $data->logo }}@endforeach" alt="logo">
                        GREENDECOR
                    </a>
                </div>
            <p class="text">@foreach($settings as $data) {{$data->short_des}} @endforeach</p>
            <p class="mb-2"><i class="fa fa-map-marker-alt text-primary mr-2"></i>@foreach($settings as $data) {{$data->address}} @endforeach</p>
            <p class="mb-2"><i class="fa fa-envelope text-primary mr-2"></i>@foreach($settings as $data) {{$data->email}} @endforeach</p>
            <p class="mb-0"><i class="fa fa-phone-alt text-primary mr-2"></i>@foreach($settings as $data) {{$data->phone}} @endforeach</p>
        </div>

        <!-- Links: Information -->
        <div class="col-lg-2 col-md-6 mb-5">
            <h5 class="font-weight-bold text-dark mb-4">Information</h5>
            <div class="d-flex flex-column justify-content-start">
                <a class="text-dark mb-2" href="{{route('about-us')}}"><i class="fa fa-angle-right mr-2"></i>About Us</a>
                <a class="text-dark mb-2" href="#"><i class="fa fa-angle-right mr-2"></i>Faq</a>
                <a class="text-dark mb-2" href="#"><i class="fa fa-angle-right mr-2"></i>Terms & Conditions</a>
                <a class="text-dark mb-2" href="{{route('contact')}}"><i class="fa fa-angle-right mr-2"></i>Contact Us</a>
                <a class="text-dark" href="#"><i class="fa fa-angle-right mr-2"></i>Help</a>
            </div>
        </div>

        <!-- Links: Customer Service -->
        <div class="col-lg-2 col-md-6 mb-5">
            <h5 class="font-weight-bold text-dark mb-4">Customer Service</h5>
            <div class="d-flex flex-column justify-content-start">
                <a class="text-dark mb-2" href="#"><i class="fa fa-angle-right mr-2"></i>Payment Methods</a>
                <a class="text-dark mb-2" href="#"><i class="fa fa-angle-right mr-2"></i>Money-back</a>
                <a class="text-dark mb-2" href="#"><i class="fa fa-angle-right mr-2"></i>Returns</a>
                <a class="text-dark mb-2" href="#"><i class="fa fa-angle-right mr-2"></i>Shipping</a>
                <a class="text-dark" href="#"><i class="fa fa-angle-right mr-2"></i>Privacy Policy</a>
            </div>
        </div>

        <!-- Contact + Social -->
        <div class="col-lg-4 col-md-12 mb-5">
            <h5 class="font-weight-bold text-dark mb-4">Get In Touch</h5>
            <p>Got Question? Call us 24/7</p>
            <p><strong><a href="tel:{{ $settings[0]->phone ?? '' }}">{{ $settings[0]->phone ?? '' }}</a></strong></p>
            <div class="mt-3">
                <div class="sharethis-inline-follow-buttons"></div>
            </div>
        </div>
    </div>

    <!-- Copyright -->
    <div class="row border-top border-light mx-xl-5 py-4">
        <div class="col-md-6 px-xl-0 text-center text-md-left">
            <p class="mb-md-0 text-dark">
                &copy; {{date('Y')}} Developed By Prajwal Rai - All Rights Reserved.
            </p>
        </div>
        <div class="col-md-6 px-xl-0 text-center text-md-right">
            <img class="img-fluid" src="{{asset('backend/img/payments.png')}}" alt="Payments">
        </div>
    </div>
</div>
<!-- Footer End -->

 <!-- JavaScript Libraries -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- jQuery CDN -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script> <!-- Bootstrap Bundle (gồm Popper) -->
<script src="{{ asset('frontend/lib/easing/easing.min.js') }}"></script> <!-- Easing dùng cho hiệu ứng scroll -->
<script src="{{ asset('frontend/lib/owlcarousel/owl.carousel.min.js') }}"></script> <!-- Owl Carousel -->

<!-- Contact JavaScript (nếu có dùng form liên hệ) -->
<script src="{{ asset('frontend/mail/jqBootstrapValidation.min.js') }}"></script>
<script src="{{ asset('frontend/mail/contact.js') }}"></script>

<!-- Main Template JS -->
<script src="{{ asset('frontend/js/main.js') }}"></script>

	

 
	@stack('scripts')
	<script>
		setTimeout(function(){
		  $('.alert').slideUp();
		},5000);
		$(function() {
		// ------------------------------------------------------- //
		// Multi Level dropdowns
		// ------------------------------------------------------ //
			$("ul.dropdown-menu [data-toggle='dropdown']").on("click", function(event) {
				event.preventDefault();
				event.stopPropagation();

				$(this).siblings().toggleClass("show");


				if (!$(this).next().hasClass('show')) {
				$(this).parents('.dropdown-menu').first().find('.show').removeClass("show");
				}
				$(this).parents('li.nav-item.dropdown.show').on('hidden.bs.dropdown', function(e) {
				$('.dropdown-submenu .show').removeClass("show");
				});

			});
		});
	  </script>