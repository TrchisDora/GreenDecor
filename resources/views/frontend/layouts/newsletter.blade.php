
<!-- Start Shop Newsletter  -->
<section class="shop-newsletter section">
<!-- Subscribe Start -->
<div class="container-fluid bg-secondary">
    <div class="row justify-content-md-center py-5 px-xl-5">
        <div class="col-md-6 col-12 py-5">
            <div class="text-center mb-2 pb-2">
                <h2 class="section-title px-5 mb-3"><span class="bg-secondary px-2">Cập nhật mới nhất</span></h2>
                <p>Đăng ký nhận bản tin của chúng tôi để theo dõi những tin tức, những bài học kinh nghiệm, những ưu đãi mới hấp dẫn</p>
            </div>
            <!-- Hiển thị thông báo thành công hoặc lỗi -->
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @elseif(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                <!-- Form đăng ký -->
                <form action="{{ route('subscribe') }}" method="POST">
                    @csrf
                    <div class="input-group input-group-lg shadow-sm">
                        <input type="email" name="email" class="form-control rounded-start" placeholder="Nhập địa chỉ email của bạn" required>
                        <button type="submit" class="btn btn-primary rounded-end">Đăng ký</button>
                    </div>
                </form>
        </div>
    </div>
</div>

<!-- Subscribe End -->
</section>
<!-- End Shop Newsletter -->