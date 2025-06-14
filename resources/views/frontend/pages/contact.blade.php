@extends('frontend.layouts.master')

@section('main-content')
<!-- Header Trang Liên Hệ -->
<div class="container-fluid bg-secondary mb-5">
    <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
        <h1 class="font-weight-semi-bold text-uppercase mb-3">Liên Hệ Với Chúng Tôi</h1>
        <div class="d-inline-flex">
            <p class="m-0"><a href="{{ route('home') }}" class="text-dark">Trang Chủ</a></p>
            <p class="m-0 px-2">-</p>
            <p class="m-0">Liên Hệ</p>
        </div>
    </div>
</div>
<!-- Header Trang Liên Hệ Kết Thúc -->

<!-- Liên Hệ Bắt Đầu -->
<div class="container-fluid pt-5">
    <div class="text-center mb-4">
        <h2 class="section-title px-5"><span class="px-2">Liên Hệ Nếu Bạn Có Thắc Mắc</span></h2>
    </div>
    <div class="row px-xl-5">
        <div class="col-lg-7 mb-5">
            <div class="contact-form">
                <div class="mb-4">
                    <h5>Gửi tin nhắn cho chúng tôi @auth @else <span class="text-danger" style="font-size:12px;">[Bạn cần đăng nhập trước]</span> @endauth</h5>
                </div>
                <form method="post" action="{{route('contact.store')}}" id="contactForm" novalidate>
                    @csrf
                    <div class="control-group">
                        <input type="text" name="name" class="form-control" id="name" placeholder="Tên Của Bạn" required="required" />
                        <p class="help-block text-danger"></p>
                    </div>
                    <div class="control-group">
                        <input type="email" name="email" class="form-control" id="email" placeholder="Email Của Bạn" required="required" />
                        <p class="help-block text-danger"></p>
                    </div>
                    <div class="control-group">
                        <input type="text" name="subject" class="form-control" id="subject" placeholder="Chủ Đề" required="required" />
                        <p class="help-block text-danger"></p>
                    </div>
                    <div class="control-group">
                        <input type="number" name="phone" class="form-control" id="phone" placeholder="Số Điện Thoại Của Bạn" required="required" />
                        <p class="help-block text-danger"></p>
                    </div>
                    <div class="control-group">
                        <textarea class="form-control" rows="6" name="message" id="message" placeholder="Tin Nhắn" required="required"></textarea>
                        <p class="help-block text-danger"></p>
                    </div>
                    <div>
                        <button class="btn btn-primary py-2 px-4" type="submit">Gửi Tin Nhắn</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-lg-5 mb-5">
            @php $settings = DB::table('settings')->get(); @endphp
            <h5 class="font-weight-semi-bold mb-3">Liên Hệ Với Chúng Tôi</h5>
            <div class="d-flex flex-column mb-3">
                <h5 class="font-weight-semi-bold mb-3">Thông Tin Liên Hệ</h5>
                <p class="mb-2"><i class="fa fa-phone-alt text-primary mr-3"></i>
                    @foreach($settings as $data) {{$data->phone}} @endforeach
                </p>
                <p class="mb-2"><i class="fa fa-envelope text-primary mr-3"></i>
                    @foreach($settings as $data)<a href="mailto:{{$data->email}}"> {{$data->email}} @endforeach</a>
                </p>
                <p class="mb-2"><i class="fa fa-map-marker-alt text-primary mr-3"></i>
                    @foreach($settings as $data) {{$data->address}} @endforeach
                </p>
            </div>
        </div>
    </div>
</div>
<!-- Liên Hệ Kết Thúc -->

<!-- Phần Bản Đồ -->
<div class="map-section">
    <iframe
        src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d15697.457837688724!2d105.760343!3d10.041972!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31a089c7ffbeb6a3%3A0x74076f3e63b8e3cd!2sGreenDecor!5e0!3m2!1svi!2s!4v1714123456789!5m2!1svi!2s"
        width="100%" 
        height="450" 
        style="border:0;" 
        allowfullscreen="" 
        loading="lazy" 
        referrerpolicy="no-referrer-when-downgrade">
    </iframe>
</div>

<!-- Bản Tin -->
@include('frontend.layouts.newsletter')

<!-- Modal Thành Công -->
<div class="modal fade" id="success" tabindex="-1" aria-labelledby="successLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content border-success">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">Cảm ơn bạn!</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-success">
                Tin nhắn của bạn đã được gửi thành công.
            </div>
        </div>
    </div>
</div>

<!-- Modal Lỗi -->
<div class="modal fade" id="error" tabindex="-1" aria-labelledby="errorLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content border-warning">
            <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title">Xin lỗi!</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-warning">
                Đã có lỗi xảy ra.
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .map-section iframe {
        width: 100%;
        height: 450px;
        border: none;
    }
</style>
@endpush

@push('scripts')
<script src="{{ asset('frontend/js/jquery.form.js') }}"></script>
<script src="{{ asset('frontend/js/jquery.validate.min.js') }}"></script>
<script src="{{ asset('frontend/js/contact.js') }}"></script>
<script>
    function initMap() {
        const greendecor = { lat: 10.041972, lng: 105.760343 };
        const map = new google.maps.Map(document.getElementById("map"), {
            zoom: 16,
            center: greendecor,
        });

        const marker = new google.maps.Marker({
            position: greendecor,
            map: map,
            title: "GreenDecor",
        });
    }
</script>

<!-- Tải API JavaScript của Google Maps -->
<script async defer
    src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&callback=initMap">
</script>

@endpush
