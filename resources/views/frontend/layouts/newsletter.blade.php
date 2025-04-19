
<!-- Start Shop Newsletter  -->
<section class="shop-newsletter section">
    <!-- Subscribe Start -->
<div class="container-fluid bg-secondary">
    <div class="row justify-content-md-center py-5 px-xl-5">
        <div class="col-md-6 col-12 py-5">
            <div class="text-center mb-2 pb-2">
                <h2 class="section-title px-5 mb-3"><span class="bg-secondary px-2">Stay Updated</span></h2>
                <p>Subscribe to our newsletter and get <span>10%</span> off your first purchase.</p>
            </div>
            <form action="{{route('subscribe')}}" method="post">
                @csrf
                <div class="input-group">
                    <input name="email" type="email" class="form-control border-white p-4" placeholder="Your email address" required>
                    <div class="input-group-append">
                        <button class="btn btn-primary px-4" type="submit">Subscribe</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Subscribe End -->
</section>
<!-- End Shop Newsletter -->