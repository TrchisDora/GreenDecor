@extends('frontend.layouts.master')
@section('title','GreenDecor || Yêu thích')
@section('main-content')
<!-- Page Header Start -->
<div class="container-fluid bg-secondary">
    <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
        <h1 class="font-weight-semi-bold text-uppercase mb-3">Danh sách yêu thích</h1>
        <div class="d-inline-flex">
            <p class="m-0"><a href="{{ route('home') }}" class="text-dark">Trang chủ</a></p>
            <p class="m-0 px-2">-</p>
            <p class="m-0">Danh sách yêu thích</p>
        </div>
    </div>  
</div>
<!-- End Breadcrumbs -->

<!-- Shopping Cart -->
<div class="container-fluid pt-5">
    <div class="row px-xl-5">
        <div class="table-responsive mb-5">
            <table class="table table-bordered text-center mb-0">
                <thead class="bg-secondary text-dark">
                    <tr class="main-hading">
                        <th></th>
                        <th>TÊN SẢN PHẨM</th>
                        <th class="text-center">TỔNG CỘNG</th> 
                        <th class="text-center">THÊM VÀO GIỎ</th> 
                        <th class="text-center"><i class="ti-trash remove-icon"></i></th>
                    </tr>  
                </thead>
                <tbody class="align-middle" id="cart_item_list">
                @if(Helper::getAllProductFromWishlist())
                    @foreach(Helper::getAllProductFromWishlist() as $key => $wishlist)
                        @php 
                            $photo = explode(',', $wishlist->product['photo']);
                        @endphp
                        <tr class="border-bottom">
                            <!-- Hình ảnh sản phẩm -->
                            <td class="text-center" style="width: 100px;">
                                <img src="{{$photo[0]}}" alt="{{$photo[0]}}" class="img-fluid rounded" style="max-height: 80px;">
                            </td>

                            <!-- Mô tả sản phẩm -->
                            <td>
                                <h6 class="mb-1">
                                    <a href="{{route('product-detail', $wishlist->product['slug'])}}" class="text-dark fw-semibold">
                                        {{$wishlist->product['title']}}
                                    </a>
                                </h6>
                                <small class="text-muted d-block">{!! number_format($wishlist['summary']) !!}</small>
                            </td>

                            <!-- Giá -->
                            <td class="text-nowrap">
                                <span class="fw-bold text-success">{{number_format($wishlist['amount'])}} đ</span>
                            </td>

                            <!-- Nút thêm vào giỏ -->
                            <td>
                                <a href="{{route('add-to-cart', $wishlist->product['slug'])}}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-cart-plus me-1"></i> Thêm vào giỏ
                                </a>
                            </td>

                            <!-- Nút xóa -->
                            <td class="text-center">
                                <a href="{{route('wishlist-delete', $wishlist->id)}}" class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa?')">
                                    <i class="fas fa-trash-alt"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="5" class="text-center">
                            <div class="alert alert-warning py-4 rounded shadow-sm">
                                Không có sản phẩm trong danh sách yêu thích của bạn. 
                                <a href="{{route('product-grids')}}" class="btn btn-sm btn-outline-success mt-2">Tiếp tục mua sắm</a>
                            </div>
                        </td>
                    </tr>
                @endif
            </tbody>

            </table>
        </div>
    </div>
</div>

	<!--/ End Shopping Cart -->
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
	
	@include('frontend.layouts.newsletter')
	
	
	
	<!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span class="ti-close" aria-hidden="true"></span></button>
                    </div>
                    <div class="modal-body">
                        <div class="row no-gutters">
                            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                <!-- Product Slider -->
									<div class="product-gallery">
										<div class="quickview-slider-active">
											<div class="single-slider">
												<img src="images/modal1.jpg" alt="#">
											</div>
											<div class="single-slider">
												<img src="images/modal2.jpg" alt="#">
											</div>
											<div class="single-slider">
												<img src="images/modal3.jpg" alt="#">
											</div>
											<div class="single-slider">
												<img src="images/modal4.jpg" alt="#">
											</div>
										</div>
									</div>
								<!-- End Product slider -->
                            </div>
                            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                <div class="quickview-content">
                                    <h2>Flared Shift Dress</h2>
                                    <div class="quickview-ratting-review">
                                        <div class="quickview-ratting-wrap">
                                            <div class="quickview-ratting">
                                                <i class="yellow fa fa-star"></i>
                                                <i class="yellow fa fa-star"></i>
                                                <i class="yellow fa fa-star"></i>
                                                <i class="yellow fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                            </div>
                                            <a href="#"> (1 customer review)</a>
                                        </div>
                                        <div class="quickview-stock">
                                            <span><i class="fa fa-check-circle-o"></i> in stock</span>
                                        </div>
                                    </div>
                                    <h3>$29.00</h3>
                                    <div class="quickview-peragraph">
                                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Mollitia iste laborum ad impedit pariatur esse optio tempora sint ullam autem deleniti nam in quos qui nemo ipsum numquam.</p>
                                    </div>
									<div class="size">
										<div class="row">
											<div class="col-lg-6 col-12">
												<h5 class="title">Size</h5>
												<select>
													<option selected="selected">s</option>
													<option>m</option>
													<option>l</option>
													<option>xl</option>
												</select>
											</div>
											<div class="col-lg-6 col-12">
												<h5 class="title">Color</h5>
												<select>
													<option selected="selected">orange</option>
													<option>purple</option>
													<option>black</option>
													<option>pink</option>
												</select>
											</div>
										</div>
									</div>
                                    <div class="quantity">
										<!-- Input Order -->
										<div class="input-group">
											<div class="button minus">
												<button type="button" class="btn btn-primary btn-number" disabled="disabled" data-type="minus" data-field="quant[1]">
													<i class="ti-minus"></i>
												</button>
											</div>
											<input type="text" name="quant[1]" class="input-number"  data-min="1" data-max="1000" value="1">
											<div class="button plus">
												<button type="button" class="btn btn-primary btn-number" data-type="plus" data-field="quant[1]">
													<i class="ti-plus"></i>
												</button>
											</div>
										</div>
										<!--/ End Input Order -->
									</div>
									<div class="add-to-cart">
										<a href="#" class="btn">Add to cart</a>
										<a href="#" class="btn min"><i class="ti-heart"></i></a>
										<a href="#" class="btn min"><i class="fa fa-compress"></i></a>
									</div>
                                    <div class="default-social">
										<h4 class="share-now">Share:</h4>
                                        <ul>
                                            <li><a class="facebook" href="#"><i class="fa fa-facebook"></i></a></li>
                                            <li><a class="twitter" href="#"><i class="fa fa-twitter"></i></a></li>
                                            <li><a class="youtube" href="#"><i class="fa fa-pinterest-p"></i></a></li>
                                            <li><a class="dribbble" href="#"><i class="fa fa-google-plus"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal end -->
	
@endsection
@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
@endpush