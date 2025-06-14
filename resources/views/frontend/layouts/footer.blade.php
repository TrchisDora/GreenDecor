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
                    <img src="@foreach($settings as $data){{ Helper::fixStoragePath($data->logo) }}@endforeach" alt="logo">
                    GREENDECOR
                </a>
            </div>
            <p class="text">@foreach($settings as $data) {{ strip_tags($data->short_des) }} @endforeach</p>
            <p class="mb-2"><i class="fa fa-map-marker-alt text-primary mr-2"></i>@foreach($settings as $data) {{$data->address}} @endforeach</p>
            <p class="mb-2"><i class="fa fa-envelope text-primary mr-2"></i>@foreach($settings as $data) {{$data->email}} @endforeach</p>
            <p class="mb-0"><i class="fa fa-phone-alt text-primary mr-2"></i>@foreach($settings as $data) {{$data->phone}} @endforeach</p>
        </div>
        <!-- Links: Thông tin -->
        <div class="col-lg-2 col-md-6 mb-5">
            <h5 class="font-weight-bold text-dark mb-4">Thông tin</h5>
            <div class="d-flex flex-column justify-content-start">
                <a class="text-dark mb-2" href="{{route('about-us')}}"><i class="fa fa-angle-right mr-2"></i>Về chúng tôi</a>
                <a class="text-dark mb-2" href="#"><i class="fa fa-angle-right mr-2"></i>Câu hỏi thường gặp</a>
                <a class="text-dark mb-2" href="#"><i class="fa fa-angle-right mr-2"></i>Điều khoản & Điều kiện</a>
                <a class="text-dark mb-2" href="{{route('contact')}}"><i class="fa fa-angle-right mr-2"></i>Liên hệ</a>
                <a class="text-dark" href="#"><i class="fa fa-angle-right mr-2"></i>Trợ giúp</a>
            </div>
        </div>

        <!-- Links: Dịch vụ khách hàng -->
        <div class="col-lg-2 col-md-6 mb-5">
            <h5 class="font-weight-bold text-dark mb-4">Dịch vụ khách hàng</h5>
            <div class="d-flex flex-column justify-content-start">
                <a class="text-dark mb-2" href="#"><i class="fa fa-angle-right mr-2"></i>Phương thức thanh toán</a>
                <a class="text-dark mb-2" href="#"><i class="fa fa-angle-right mr-2"></i>Hoàn tiền</a>
                <a class="text-dark mb-2" href="#"><i class="fa fa-angle-right mr-2"></i>Trả hàng</a>
                <a class="text-dark mb-2" href="#"><i class="fa fa-angle-right mr-2"></i>Giao hàng</a>
                <a class="text-dark" href="#"><i class="fa fa-angle-right mr-2"></i>Chính sách bảo mật</a>
            </div>
        </div>

        <!-- Liên hệ + Mạng xã hội -->
        <div class="col-lg-4 col-md-12 mb-5">
            <h5 class="font-weight-bold text-dark mb-4">Liên hệ với chúng tôi</h5>
            <p>Cần hỗ trợ ?</p>
            <p>Gọi ngay cho chúng tôi 24/7</p>
            <p><strong><a href="tel:{{ $settings[0]->phone ?? '' }}">{{ $settings[0]->phone ?? '' }}</a></strong></p>
            <div class="mt-3">
                @if (Request::is('blog-detail/*'))
                    <div class="sharethis-inline-follow-buttons"></div>
                @endif
            </div>
        </div>
    </div>

    <!-- Bản quyền -->
    <div class="row border-top border-light mx-xl-5 py-4">
        <div class="col-md-6 px-xl-0 text-center text-md-left">
            <p class="mb-md-0 text-dark">
                &copy; {{date('Y')}} Phát triển bởi GREENDECOR - Đã đăng ký bản quyền.
            </p>
        </div>
        <div class="col-md-6 px-xl-0 text-center text-md-right">
            <img class="img-fluid" src="{{asset('backend/img/payments.png')}}" alt="Thanh toán">
        </div>
    </div>
</div>
<!-- Footer End -->

<!-- JavaScript Libraries -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('frontend/lib/easing/easing.min.js') }}"></script>
<script src="{{ asset('frontend/lib/owlcarousel/owl.carousel.min.js') }}"></script>
<script src="{{ asset('frontend/mail/jqBootstrapValidation.min.js') }}"></script>
<script src="{{ asset('frontend/mail/contact.js') }}"></script>
<script src="{{ asset('frontend/js/main.js') }}"></script>
@stack('scripts')
<script>
    setTimeout(function(){
        $('.alert').slideUp();
    }, 5000);

    $(function() {
        // ------------------------------------------------------- //
        // Dropdown đa cấp
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
