@extends('frontend.layouts.master')

@section('main-content')
<!-- Page Header Start -->
<div class="container-fluid bg-secondary mb-5">
	<div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
		<h1 class="font-weight-semi-bold text-uppercase mb-3">Contact</h1>
		<div class="d-inline-flex">
			<p class="m-0"><a href="{{ route('home') }}" class="text-dark">Home</a></p>
			<p class="m-0 px-2">-</p>
			<p class="m-0">Contact</p>
		</div>
	</div>
</div>
<!-- Page Header End -->

<!-- Start Contact -->
<section id="contact-us" class="contact-us section py-5">
    <div class="container">
        <div class="row">
            <!-- Contact Form -->
            <div class="col-lg-8">
                <div class="card shadow-sm border-0 p-4">
                    <div class="mb-4">
                        @php $settings = DB::table('settings')->get(); @endphp
                        <h4>Get in touch</h4>
                        <h5>Write us a message @auth @else <span class="text-danger" style="font-size:12px;">[You need to login first]</span> @endauth</h5>
                    </div>
                    <form method="post" action="{{route('contact.store')}}" id="contactForm" class="row g-3 needs-validation" novalidate>
                        @csrf
                        <div class="col-md-6">
                            <label for="name" class="form-label">Your Name<span class="text-danger">*</span></label>
                            <input type="text" name="name" id="name" class="form-control" placeholder="Enter your name" required>
                        </div>
                        <div class="col-md-6">
                            <label for="subject" class="form-label">Your Subject<span class="text-danger">*</span></label>
                            <input type="text" name="subject" id="subject" class="form-control" placeholder="Enter Subject" required>
                        </div>
                        <div class="col-md-6">
                            <label for="email" class="form-label">Your Email<span class="text-danger">*</span></label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="Enter email address" required>
                        </div>
                        <div class="col-md-6">
                            <label for="phone" class="form-label">Your Phone<span class="text-danger">*</span></label>
                            <input type="number" name="phone" id="phone" class="form-control" placeholder="Enter your phone" required>
                        </div>
                        <div class="col-12">
                            <label for="message" class="form-label">Your Message<span class="text-danger">*</span></label>
                            <textarea name="message" id="message" rows="5" class="form-control" placeholder="Enter Message" required></textarea>
                        </div>
                        <div class="col-12 text-end">
                            <button type="submit" class="btn btn-primary">Send Message</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Contact Info -->
            <div class="col-lg-4 mt-5 mt-lg-0">
                <div class="card border-0 shadow-sm p-4">
                    <div class="mb-4">
                        <h5><i class="fa fa-phone me-2 text-primary"></i> Call Us Now:</h5>
                        <p>@foreach($settings as $data) {{$data->phone}} @endforeach</p>
                    </div>
                    <div class="mb-4">
                        <h5><i class="fa fa-envelope-open me-2 text-primary"></i> Email:</h5>
                        <p><a href="mailto:info@yourwebsite.com">@foreach($settings as $data) {{$data->email}} @endforeach</a></p>
                    </div>
                    <div>
                        <h5><i class="fa fa-location-arrow me-2 text-primary"></i> Our Address:</h5>
                        <p>@foreach($settings as $data) {{$data->address}} @endforeach</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Contact -->

<!-- Map Section -->
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


<!-- Newsletter -->
@include('frontend.layouts.newsletter')

<!-- Success Modal -->
<div class="modal fade" id="success" tabindex="-1" aria-labelledby="successLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content border-success">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">Thank you!</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-success">
                Your message is successfully sent.
            </div>
        </div>
    </div>
</div>

<!-- Error Modal -->
<div class="modal fade" id="error" tabindex="-1" aria-labelledby="errorLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content border-warning">
            <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title">Sorry!</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-warning">
                Something went wrong.
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

<!-- Load Google Maps JavaScript API -->
<script async defer
    src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&callback=initMap">
</script>

@endpush
