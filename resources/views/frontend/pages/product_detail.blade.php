@extends('frontend.layouts.master')

@section('meta')
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name='copyright' content=''>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="keywords" content="online shop, purchase, cart, ecommerce site, best online shopping">
	<meta name="description" content="{{$product_detail->summary}}">
	<meta property="og:url" content="{{route('product-detail',$product_detail->slug)}}">
	<meta property="og:type" content="article">
	<meta property="og:title" content="{{$product_detail->title}}">
	<meta property="og:image" content="{{$product_detail->photo}}">
	<meta property="og:description" content="{{$product_detail->description}}">
@endsection
@section('title','Ecommerce Laravel || PRODUCT DETAIL')
@section('main-content')

<!-- Page Header Start -->
<div class="container-fluid bg-secondary mb-5">
    <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
        <h1 class="font-weight-semi-bold text-uppercase mb-3">Chi tiết sản phẩm</h1>
        <div class="d-inline-flex">
            <p class="m-0"><a href="{{ route('home') }}" class="text-dark">Trang chủ</a></p>
            <p class="m-0 px-2">-</p>
            <p class="m-0">Chi tiết sản phẩm</p>
        </div>
    </div>	
</div>
<!-- Page Header End -->
		<!-- Shop Single -->
		<section class="shop single section">
					<div class="container">
						<!-- Breadcrumb -->
						<nav aria-label="breadcrumb" class="mb-4">
							<ol class="breadcrumb bg-light p-3 rounded">
								<li class="breadcrumb-item"><a href="/">Home</a></li>
								<li class="breadcrumb-item">
									<a href="{{ route('product-lists', $product_detail->cat_info['slug']) }}">
										{{ $product_detail->cat_info['title'] }}
									</a>
								</li>
								@if($product_detail->sub_cat_info)
									<li class="breadcrumb-item">
										<a href="{{ route('product-lists', [$product_detail->cat_info['slug'], $product_detail->sub_cat_info['slug']]) }}">
											{{ $product_detail->sub_cat_info['title'] }}
										</a>
									</li>
								@endif
								<li class="breadcrumb-item active" aria-current="page">{{ $product_detail->title }}</li>
							</ol>
						</nav>
						<div class="row"> 
							<div class="col-12">
							<div class="row mb-5">
								<!-- Hình ảnh -->
								<div class="col-lg-6 mb-4">
									<div class="product-gallery">
										<div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
											<div class="product-image-wrapper {{ $product_detail->stock <= 0 ? 'out-of-stock' : '' }}">
												<img src="{{ $product_detail->photo }}" alt="Sản phẩm">
												<div class="product-overlay"></div>
												@if($product_detail->stock <= 0)
													<div class="out-of-stock-badge">Hết hàng</div>
												@endif
											</div>

											<a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-bs-slide="prev">
												<span class="carousel-control-prev-icon" aria-hidden="true"></span>
											</a>
											<a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-bs-slide="next">
												<span class="carousel-control-next-icon" aria-hidden="true"></span>
											</a>
										</div>
									</div>
								</div>
								<!-- Chi tiết sản phẩm -->
								<div class="col-md-6">
									<div class="border rounded-3 shadow-sm p-4 bg-white h-100 d-flex flex-column justify-content-between">
										<div>
											<!-- Tên sản phẩm -->
											<h2 class="fw-bold text-dark">{{ $product_detail->title }}</h2>
											<!-- Đánh giá -->
											<div class="mb-3">
												<ul class="list-inline text-warning fs-5 d-inline">
													@php $rate = ceil($product_detail->getReview->avg('rate')); @endphp
													@for($i = 1; $i <= 5; $i++)
														<li class="list-inline-item">
															<i class="fa {{ $rate >= $i ? 'fa-star' : 'fa-star-o' }}"></i>
														</li>
													@endfor
												</ul>
												<span class="text-muted ms-2">({{ $product_detail['getReview']->count() }} đánh giá)</span>
											</div>

											<!-- Giá sản phẩm -->
											@php 
												$after_discount = $product_detail->price - (($product_detail->price * $product_detail->discount) / 100);
											@endphp
											<p class="h4 text-danger fw-semibold mb-2">
												{{ number_format($after_discount) }} đ
												@if($product_detail->discount > 0)
													<small class="text-muted ms-2"><s>{{ number_format($product_detail->price) }} đ</s></small>
												@endif
											</p>

											<!-- Mô tả ngắn -->
											<p class="text-muted">{!! $product_detail->summary !!}</p>

											<!-- Kích cỡ -->
											@if($product_detail->size)
												<div class="mt-3">
													<label class="fw-semibold mb-2">Chọn kích cỡ:</label>
													@php $sizes = explode(',', $product_detail->size); @endphp
													<div class="d-flex flex-wrap gap-2">
														@foreach($sizes as $key => $size)
															<div class="form-check form-check-inline">
																<input class="form-check-input" type="radio" name="size" id="size{{ $key }}" value="{{ $size }}" {{ $key == 0 ? 'checked' : '' }}>
																<label class="form-check-label" for="size{{ $key }}">{{ $size }}</label>
															</div>
														@endforeach
													</div>
												</div>
											@endif
										</div>
										<!-- Mua hàng -->
										<form action="{{ route('single-add-to-cart') }}" method="POST" class="mt-4">
											@csrf
											<input type="hidden" name="slug" value="{{ $product_detail->slug }}">
											<div class="mb-3">
												<label for="quantity" class="form-label fw-semibold">Số lượng còn:</label>
												<div class="input-group" style="max-width: 140px;">
													@if ($product_detail->stock > 0)
													<span class="text-success">Còn {{ $product_detail->stock }} sản phẩm trong kho</span>
													@else
														<span class="text-danger">Hết hàng</span>
													@endif
												</div>
											</div>
											<!-- Số lượng -->
											<div class="mb-3">
												<label for="quantity" class="form-label fw-semibold">Số lượng:</label>
												<div class="input-group" style="max-width: 140px;">
													<input type="number" name="quant[1]" id="quantity"
														class="form-control text-center border-primary shadow-sm"
														value="1" min="1" max="1000">
												</div>
											</div>

											<!-- Nút hành động chiếm 100% chiều ngang -->
											<div class="row g-2 mt-3">
												<!-- Nút thêm vào giỏ hàng chiếm 70% -->
												<div class="col-12 col-md-8 pr-0">
													@if ($product_detail->stock > 0)
														<button type="submit" class="btn btn-primary w-100 justify-content-center align-items-center py-3">
															<i class="fas fa-shopping-cart me-2 mr-2"></i> Thêm vào giỏ hàng
														</button>
													@else
														<button type="submit" disabled class="btn btn-primary w-100 justify-content-center align-items-center py-3">
															<i class="fas fa-shopping-cart me-2 mr-2"></i> Hết hàng
														</button>
													@endif

												</div>

												<!-- Nút yêu thích (icon trái tim) chiếm 30% -->
												<div class="col-12 col-md-4  pl-0">
													<a href="{{ route('add-to-wishlist', $product_detail->slug) }}"
													class="btn btn-outline-danger w-100 justify-content-center align-items-center py-3"
													title="Thêm vào yêu thích">
														<i class="ti-heart"></i>
													</a>
												</div>
										</div>

										</form>

										<!-- Thông tin bổ sung -->
										<div class="mt-4 small text-muted">
											<p class="mb-1">Danh mục: 
												<a href="{{ route('product-lists', $product_detail->cat_info['slug']) }}" class="nav-link text-decoration-underline text-primary">
													{{ $product_detail->cat_info['title'] }}
												</a>
											</p>
											@if($product_detail->sub_cat_info)
											<p class="mb-1">Danh mục phụ: 
												<a href="{{ route('product-lists', [$product_detail->cat_info['slug'], $product_detail->sub_cat_info['slug']]) }}" class="nav-link text-decoration-underline text-primary">
													{{ $product_detail->sub_cat_info['title'] }}
												</a>
											</p>
											@endif
											
										</div>
									</div>
								</div>
							</div>
							<div class="row mb-5">
								<div class="col-12">
									<div class="product-info">
										<div class="nav-main">
											<!-- Tab Nav -->
											<ul class="nav nav-tabs" id="myTab" role="tablist">
												<li class="nav-item">
													<a class="nav-link active" id="description-tab" data-toggle="tab" href="#description" role="tab">Mô tả</a>
												</li>
												<li class="nav-item">
													<a class="nav-link" id="reviews-tab" data-toggle="tab" href="#reviews" role="tab">Đánh giá</a>
												</li>
											</ul>
											<!--/ End Tab Nav -->
										</div>

										<div class="tab-content mt-4" id="myTabContent">
											<!-- Description Tab -->
											<div class="tab-pane fade show active" id="description" role="tabpanel">
												<div class="tab-single">
													<div class="row">
														<div class="col-12">
															<div class="single-des">
																<p>{!! $product_detail->description !!}</p>
															</div>
														</div>
													</div>
												</div>
											</div>
											<!--/ End Description Tab -->

											<!-- Reviews Tab -->
											<div class="tab-pane fade" id="reviews" role="tabpanel">
												<div class="row">
													<!-- Reviews Section -->
													<div class="col-md-6">
														<h4 class="mb-4">{{ $product_detail->getReview->count() }} đánh giá cho "{{ $product_detail->title }}"</h4>
														<div class="review-container" id="reviews-container">
														@foreach($product_detail->getReview as $review)
															<div class="media mb-4">
																<img src="{{ $review->user_info['photo'] ? $review->user_info['photo'] : asset('backend/img/avatar.png') }}" alt="Image" class="img-fluid mr-3 mt-1" style="width: 50px;">
																<div class="media-body">
																	<h6>{{ $review->user_info['name'] }}<small> - <i>{{ $review->created_at->format('d M Y') }}</i></small></h6>
																	<div class="text-primary mb-2">
																		@for($i = 1; $i <= 5; $i++)
																			<i class="fas fa-star{{ $review->rate >= $i ? '' : '-o' }}"></i>
																		@endfor
																	</div>
																	<p>{{ $review->review }}</p>
																</div>
															</div>
														@endforeach
														</div>
													</div>

													<!-- Review Form Section -->
													<div class="col-md-6">
														<h4 class="mb-4">Để lại đánh giá</h4>
														@auth
															<!-- Review Form -->
															<form class="form" method="post" action="{{ route('review.store', $product_detail->slug) }}">
																@csrf

																<!-- Rating Section -->
																<div class="form-group">
																	<label>Đánh giá của bạn <span class="text-danger">*</span></label>
																	<div class="star-rating" id="star-rating">
																		<div class="star-rating__wrap">
																			<input class="star-rating__input" id="star-rating-1" type="radio" name="rate" value="1" hidden>
																			<label class="star-rating__ico fa fa-star-o" for="star-rating-1" title="1 trong 5 sao">
																				<i class="far fa-star"></i>
																			</label>
																			<input class="star-rating__input" id="star-rating-2" type="radio" name="rate" value="2" hidden>
																			<label class="star-rating__ico fa fa-star-o" for="star-rating-2" title="2 trong 5 sao">
																				<i class="far fa-star"></i>
																			</label>
																			<input class="star-rating__input" id="star-rating-3" type="radio" name="rate" value="3" hidden>
																			<label class="star-rating__ico fa fa-star-o" for="star-rating-3" title="3 trong 5 sao">
																				<i class="far fa-star"></i>
																			</label>
																			<input class="star-rating__input" id="star-rating-4" type="radio" name="rate" value="4" hidden>
																			<label class="star-rating__ico fa fa-star-o" for="star-rating-4" title="4 trong 5 sao">
																				<i class="far fa-star"></i>
																			</label>
																			<input class="star-rating__input" id="star-rating-5" type="radio" name="rate" value="5" hidden>
																			<label class="star-rating__ico fa fa-star-o" for="star-rating-5" title="5 trong 5 sao">
																				<i class="far fa-star"></i>
																			</label>
																		</div>
																	</div>
																	@error('rate')
																		<span class="text-danger">{{ $message }}</span>
																	@enderror
																</div>

																<!-- Review Text Area -->
																<div class="form-group">
																	<label for="review">Đánh giá của bạn <span class="text-danger">*</span></label>
																	<textarea name="review" id="review" class="form-control" required rows="5" placeholder="Viết đánh giá của bạn ở đây..."></textarea>
																</div>

																<!-- Name Input -->
																<div class="form-group">
																	<label for="name">Tên của bạn <span class="text-danger">*</span></label>
																	<input type="text" class="form-control" id="name" name="name" value="{{ auth()->user()->name }}" required>
																</div>

																<!-- Email Input -->
																<div class="form-group">
																	<label for="email">Email của bạn <span class="text-danger">*</span></label>
																	<input type="email" class="form-control" id="email" name="email" value="{{ auth()->user()->email }}" required>
																</div>

																<!-- Submit Button -->
																<div class="form-group mb-0">
																	<button type="submit" class="btn btn-primary px-3">Để lại đánh giá của bạn</button>
																</div>
															</form>

														@else
														<div class="alert-warning text-center p-4 rounded-3 shadow-sm">
															Bạn cần 
															<a href="{{ route('login.form') }}" class="btn btn-sm btn-outline-primary ms-2 me-2">Đăng nhập</a> 
															hoặc 
															<a href="{{ route('register.form') }}" class="btn btn-sm btn-outline-success">Đăng ký</a> 
															để để lại nhận xét.
														</div>
														@endauth
													</div>

												</div>
											</div>
											<!--/ End Reviews Tab -->
										</div>
									</div>
								</div>
							</div>
						</div>
				</div>
			</div>
		</section>
		<!--/ End Shop Single -->
		<!-- Visit 'codeastro' for more projects -->
		<!-- Start Most Popular -->
		<div class="product-area most-popular related-product section">
			<!-- Related Products Start -->
			<div class="container-fluid pt-5">
				<div class="text-center mb-4">
					<h2 class="section-title px-5"><span class="px-2">Sản phẩm liên quan</span></h2>
				</div>
				<div class="row px-xl-5 pb-3" id="related-product-list">
					@foreach($product_detail->rel_prods as $key => $product)
						@if($product->id !== $product_detail->id)
							@php
								$discounted = $product->price - ($product->price * $product->discount / 100);
								$photo = explode(',', $product->photo);
							@endphp
							<div class="col-lg-3 col-md-6 col-sm-12 pb-1 related-product-item-wrapper" style="{{ $key >= 8 ? 'display:none;' : '' }}">
								<div class="card product-item border-0 mb-4">
									@if($product->discount > 0)
										<span class="position-absolute bg-danger text-white px-3 py-2 rounded-pill shadow"
											style="top: 15px; left: 15px; font-size: 1rem; font-weight: bold; z-index: 10;">
											-{{ $product->discount }}%
										</span>
									@endif
									<div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
										<img class="img-fluid w-100" style="width:426px; height:426px; object-fit:cover;" src="{{ $photo[0] }}" alt="{{ $product->title }}">
									</div>
									<div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
										<a href="{{ route('product-detail', $product->slug) }}" class="btn btn-sm text-dark p-0">
											<h6 class="text-truncate mb-3">{{ $product->title }}</h6>
										</a>
										<div class="d-flex justify-content-center">
											<h6>{{ number_format($discounted, 0, ',', '.') }} đ</h6>
											@if($product->discount > 0)
												<h6 class="text-muted ml-2"><del>{{ number_format($product->price, 0, ',', '.') }} đ</del></h6>
											@endif
										</div>
									</div>
									<div class="card-footer bg-white border-top p-3">
										<div class="d-flex mb-3 flex-wrap justify-content-between btn-group-spaced">
											<a data-toggle="modal" data-target="#quickView{{ $product->id }}" class="btn btn-sm text-dark p-0" title="Quick View" href="#">
												<i class="ti-eye text-primary mr-1"></i> Xem nhanh
											</a>
											<a title="Wishlist" href="{{ route('add-to-wishlist', $product->slug) }}" class="btn btn-sm text-dark p-0" data-id="{{ $product->id }}">
												<i class="ti-heart text-danger"></i> Yêu thích
											</a>
										</div>
										<a href="{{ route('add-to-cart', $product->slug) }}"
										class="btn btn-success btn-block d-flex align-items-center justify-content-center py-3 rounded-pill font-weight-bold btn-fade"
										title="Thêm vào giỏ">
											<i class="fas fa-shopping-cart mr-2"></i> Thêm vào giỏ
										</a>
									</div>
								</div>
							</div>
						@endif
					@endforeach
				</div>

				@if($product_detail->rel_prods->count() > 8)
					<div class="text-center mt-3">
						<button id="loadMoreRelatedBtn" class="btn btn-primary">Xem thêm</button>
					</div>
				@endif
			</div>
			<!-- Related Products End -->

			<script>
				// Nút xem thêm cho sản phẩm liên quan
				document.getElementById('loadMoreRelatedBtn')?.addEventListener('click', function () {
					const hiddenItems = document.querySelectorAll('.related-product-item-wrapper[style*="display:none"]');
					hiddenItems.forEach((item, index) => {
						if (index < 8) {
							item.style.display = 'block';
						}
					});
					if (hiddenItems.length <= 8) {
						this.style.display = 'none';
					}
				});
			</script>

	   </div>
	   <!-- End Most Popular Area -->
 <!-- Phần modal tách riêng sau danh sách sản phẩm -->
 @foreach($product_detail->rel_prods as $product)
    <!-- Quick View Modal -->
    <div class="modal fade" id="quickView{{ $product->id }}" tabindex="-1" role="dialog" aria-labelledby="quickViewLabel{{ $product->id }}" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content border-0">
                <div class="modal-header border-0">
                    <h5 class="modal-title" id="quickViewLabel{{ $product->id }}">{{ $product->title }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span>&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="row">
                        {{-- Image --}}
                        <div class="col-md-6">
                            @php $photo = explode(',', $product->photo); @endphp
                            <img src="{{ $photo[0] }}" class="img-fluid w-100" style="height: 400px; object-fit: cover;" alt="{{ $product->title }}">
                        </div>

                        {{-- Product Info --}}
                        <div class="col-md-6">
                            <h4>{{ $product->title }}</h4>

                            @php $after_discount = $product->price - ($product->price * $product->discount / 100); @endphp
                            <h5 class="text-primary">{{ number_format($after_discount, 0, ',', '.') }}đ
                                @if ($product->discount > 0)
                                    <del class="text-muted ml-2">{{ number_format($product->price, 0, ',', '.') }}đ</del>
                                @endif
                            </h5>

                            {{-- Rating --}}
                            @php
                                $rate = DB::table('product_reviews')->where('product_id', $product->id)->avg('rate');
                            @endphp
                            <div class="rating mb-3">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($rate >= $i)
                                        <i class="fa fa-star text-warning"></i>
                                    @else
                                        <i class="fa fa-star text-secondary"></i>
                                    @endif
                                @endfor
                                <small class="ml-2 text-muted">({{ number_format($rate, 1) }}/5)</small>
                            </div>

                            {{-- Description --}}
                            <p>{!! $product->summary !!}</p>

                            {{-- Add to cart --}}
                            <form action="{{ route('single-add-to-cart') }}" method="POST" class="mt-3">
                                @csrf
                                <input type="hidden" name="slug" value="{{ $product->slug }}">
                                <input type="hidden" name="quant[1]" value="1">
                                <button type="submit" class="btn btn-outline-success">
                                    <i class="fa fa-shopping-cart mr-1"></i> Thêm vào giỏ
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> 
@endforeach

@endsection
@push('styles')
<style>
/* Rating stars style */

.star-rating__wrap {
    display: flex;
    flex-direction: row;
}

.star-rating__input {
    display: none;
}

.star-rating__ico i {
    font-size: 30px;
    color: #55ac49;
    cursor: pointer;
    margin: 0 5px;
    transition: color 0.3s ease;
}

/* Hover effect: chỉ thay đổi màu sắc của các sao trong vùng hover */
.star-rating__ico i:hover,
.star-rating__input:checked ~ .star-rating__wrap .star-rating__ico i:hover {
    color: #55ac49; /* Màu hover */
}

/* Highlight stars up to the selected one */
.star-rating__input:checked ~ .star-rating__wrap .star-rating__ico i {
    color: #55ac49; /* Màu sao đã được chọn */
}

/* Ensure checked stars stay yellow after selection */
.star-rating__input:checked + .star-rating__ico i {
    color: #55ac49; /* Giữ màu vàng khi đã chọn */
}
.review-container {
    max-height: 500px; /* Giới hạn chiều cao */
    overflow-y: auto;  /* Thanh cuộn dọc nếu có nhiều bình luận */
}


</style>
@endpush

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

    {{-- <script>
        $('.cart').click(function(){
            var quantity=$('#quantity').val();
            var pro_id=$(this).data('id');
            // alert(quantity);
            $.ajax({
                url:"{{route('add-to-cart')}}",
                type:"POST",
                data:{
                    _token:"{{csrf_token()}}",
                    quantity:quantity,
                    pro_id:pro_id
                },
                success:function(response){
                    console.log(response);
					if(typeof(response)!='object'){
						response=$.parseJSON(response);
					}
					if(response.status){
						swal('success',response.msg,'success').then(function(){
							document.location.href=document.location.href;
						});
					}
					else{
                        swal('error',response.msg,'error').then(function(){
							document.location.href=document.location.href;
						});
                    }
                }
            })
        });
    </script> --}}

@endpush
@push('scripts')
<script>
	document.addEventListener('DOMContentLoaded', function () {
    const stars = document.querySelectorAll('.star-rating__input');
    const icons = document.querySelectorAll('.star-rating__ico i'); // Lấy tất cả các phần tử <i>

    // Lắng nghe sự kiện change trên các input radio
    stars.forEach(star => {
        star.addEventListener('change', function () {
            const ratingValue = this.value;
            updateStars(ratingValue);
        });
    });

    // Cập nhật các phần tử <i> sao cho đúng với giá trị đã chọn
    function updateStars(ratingValue) {
        icons.forEach(icon => {
            const starValue = icon.closest('label').getAttribute('for').split('-')[2]; // Lấy giá trị từ id của radio
            if (starValue <= ratingValue) {
                icon.classList.remove('far');
                icon.classList.add('fas'); // Đổi thành sao đầy
            } else {
                icon.classList.remove('fas');
                icon.classList.add('far'); // Đổi thành sao rỗng
            }
        });
    }
});

</script>
@endpush
