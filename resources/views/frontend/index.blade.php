@extends('frontend.layouts.master')
@section('title','Ecommerce Laravel || HOME PAGE')
@section('main-content')
<!-- Slider Area -->
<div class="container-fluid mb-4">
    <div class="row px-xl-5">
       <!-- Cột trái: Danh mục sản phẩm -->
<div class="col-lg-3 d-none d-lg-block">
</div>

        <!-- Cột phải: Carousel slider -->
        <div class="col-lg-9">
        @if(count($banners) > 0)
<section id="header-carousel" class="carousel slide" data-ride="carousel">
    <!-- Indicators -->
    <ol class="carousel-indicators">
        @foreach($banners as $key => $banner)
            <li data-target="#header-carousel" data-slide-to="{{ $key }}" class="{{ $key == 0 ? 'active' : '' }}"></li>
        @endforeach
    </ol>

    <!-- Slides -->
    <div class="carousel-inner">
        @foreach($banners as $key => $banner)
        <div class="carousel-item {{ $key == 0 ? 'active' : '' }}" style="height: 410px;">
            <img class="img-fluid w-100 h-100" style="object-fit: cover;" src="{{ $banner->photo }}" alt="Slide {{ $key+1 }}">
            <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                <div class="p-3 text-center" style="max-width: 700px;">
                    <h4 class="text-light text-uppercase font-weight-medium mb-3">{{ $banner->title }}</h4>
                    <h3 class="display-4 text-white font-weight-semi-bold mb-4">{!! html_entity_decode($banner->description) !!}</h3>
                    <a href="{{ route('product-grids') }}" class="btn btn-light py-2 px-3">Shop Now</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Controls -->
    <a class="carousel-control-prev" href="#header-carousel" data-slide="prev">
        <div class="btn btn-dark" style="width: 45px; height: 45px;">
            <span class="carousel-control-prev-icon mb-n2"></span>
        </div>
    </a>
    <a class="carousel-control-next" href="#header-carousel" data-slide="next">
        <div class="btn btn-dark" style="width: 45px; height: 45px;">
            <span class="carousel-control-next-icon mb-n2"></span>
        </div>
    </a>
</section>
@endif

        </div>
    </div>
</div>


<!--/ End Slider Area -->

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
<!-- Danh mục sản phẩm -->
@php
    $category_lists = DB::table('categories')
        ->where('status', 'active')
        ->where('is_parent', 1)
        ->get();
@endphp
<div class="container-fluid pt-5">
    <div class="d-flex justify-content-center flex-wrap">
        @foreach($category_lists as $index => $cat)
        @php
        // Lấy danh sách ID của loại con
        $childCategoryIDs = DB::table('categories')
            ->where('parent_id', $cat->id)
            ->pluck('id')
            ->toArray();

        // Đếm loại con
        $childCount = count($childCategoryIDs);

        // Đếm sản phẩm thuộc loại cha hoặc loại con
        $productCount = DB::table('products')
            ->where(function ($query) use ($cat, $childCategoryIDs) {
                $query->where('cat_id', $cat->id);
                if (!empty($childCategoryIDs)) {
                    $query->orWhereIn('child_cat_id', $childCategoryIDs);
                }
            })
            ->count();
    @endphp
            <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4 {{ $index >= 8 ? 'extra-category d-none' : '' }}">
                <div class="cat-item d-flex flex-column border p-3 h-100 rounded-3 text-center">
                <p class="text-muted mb-1">{{ $childCount }} loại, {{ $productCount }} sản phẩm</p>
                    <a href="{{ route('product-grids-cat', $cat->slug) }}" class="cat-img mb-3 d-block">
                        <img src="{{ $cat->photo ?? 'https://via.placeholder.com/600x370' }}" style="width: 100% ; height: 253px; overflow: hidden;" class="img-fluid rounded" alt="{{ $cat->title }}">
                    </a>
                    <h6 class="fw-semibold mb-2">{{ $cat->title }}</h6>
                    <a href="{{ route('product-grids-cat', $cat->slug) }}" class="btn btn-sm btn-outline-primary mx-auto">Khám phá ngay</a>
                </div>
            </div>
        @endforeach
    </div>

    @if(count($category_lists) > 8)
        <div class="row">
            <div class="col-12 text-center">
                <button class="btn btn-primary mt-3" id="toggle-category-btn">
                    Xem thêm danh mục
                </button>
            </div>
        </div>
    @endif
</div>

@php
$newProducts = DB::table('products')
    ->where('status', 'active')
    ->where('condition', 'hot')
    ->orderByDesc('id')
    ->get();
@endphp
<!-- New Products Start -->
<div class="container-fluid pt-5">
    <div class="text-center mb-4">
        <h2 class="section-title px-5"><span class="px-2">Sản phẩm mới</span></h2>
    </div>
       <div class="row px-xl-5 pb-3" id="product-list">
       @foreach($newProducts as $key => $product)
    @php
        $discounted = $product->price - ($product->price * $product->discount / 100);
    @endphp
    <div class="col-lg-3 col-md-6 col-sm-12 pb-1 product-item-wrapper" style="{{ $key >= 8 ? 'display:none;' : '' }}">
        <div class="card product-item border-0 mb-4">
            {{-- Badge Giảm giá --}}
            @if($product->discount > 0)
                <span class="position-absolute bg-danger text-white px-3 py-2 rounded-pill shadow"
                      style="top: 15px; left: 15px; font-size: 1rem; font-weight: bold; z-index: 10;">
                    -{{ $product->discount }}%
                </span>
            @endif
            <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                <img class="img-fluid w-100" style="width:426px; height:426px; object-fit:cover;" src="{{ $product->photo }}" alt="{{ $product->title }}">
            </div>
            <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
            <a href="{{ url('/product-detail/' . $product->slug) }}" class="btn btn-sm text-dark p-0">
            <h6 class="text-truncate mb-3">{{ $product->title }}</h6>
                </a>
                <div class="d-flex justify-content-center">
                    <h6>{{ number_format($discounted, 0, ',', '.') }}đ</h6>
                    @if ($product->discount > 0)
                        <h6 class="text-muted ml-2"><del>{{ number_format($product->price, 0, ',', '.') }}đ</del></h6>
                    @endif
                </div>
            </div>
            <div class="card-footer bg-white border-top p-3">
    {{-- Nhóm nút Xem nhanh + Yêu thích --}}
    <div class="d-flex mb-3 flex-wrap justify-content-between btn-group-spaced">
    <a data-toggle="modal" data-target="#quickView{{ $product->id }}" class="btn btn-sm text-dark p-0" title="Quick View" href="#">
                    <i class="ti-eye text-primary mr-1"></i>Xem nhanh
                </a>
                <a title="Wishlist" href="{{ route('add-to-wishlist', $product->slug) }}" class="btn btn-sm text-dark p-0" data-id="{{ $product->id }}">
										<i class="ti-heart text-danger"></i> Yêu thích
									</a>
    </div>

    {{-- Nút Thêm vào giỏ --}}
    <a href="{{ route('add-to-cart', $product->slug) }}" 
      class="btn btn-success btn-block d-flex align-items-center justify-content-center py-3 rounded-pill font-weight-bold btn-fade"
       title="Thêm vào giỏ">
        <i class="fas fa-shopping-cart mr-2"></i> Thêm vào giỏ
    </a>
</div>
        </div>
    </div>
@endforeach

    </div>

    @if($newProducts->count() > 8)
    <div class="text-center mt-3">
        <button id="loadMoreNewBtn" class="btn btn-primary">Xem thêm</button>
    </div>
    @endif
</div>
<!-- New Products End -->

@if($featured)
    <div class="container-fluid pt-5">
        <div class="row">
            @foreach($featured as $key => $data)
                @php
                    $photo = explode(',', $data->photo);
                    $isEven = $key % 2 == 0;
                @endphp

                <div class="col-12 col-md-6 pb-4">
                    <div class="row bg-secondary text-white rounded-4 overflow-hidden align-items-stretch h-100 g-0">
                        @if($isEven)
                            <!-- Image left -->
                            <div class="col-12 col-md-6 p-0">
                                <img src="{{ $photo[0] }}" class="img-fluid w-100 h-100" style="object-fit: cover; max-height: 300px;" />
                            </div>
                            <!-- Text right -->
                            <div class="col-12 col-md-6 d-flex flex-column justify-content-center text-center text-md-start p-4">
                                <h5 class="text-uppercase text-primary mb-2">{{ $data->cat_info['title'] }}</h5>
                                <h2 class="mb-3 text-dark h4">{{ $data->title }}<br><span class="text-warning">Up to {{ $data->discount }}%</span></h2>
                                <a href="{{ route('product-detail', $data->slug) }}" class="btn btn-outline-primary py-md-2 px-md-3">Shop Now</a>
                            </div>
                        @else
                            <!-- Text left -->
                            <div class="col-12 col-md-6 d-flex flex-column justify-content-center text-center text-md-end p-4 order-2 order-md-1">
                                <h5 class="text-uppercase text-primary mb-2">{{ $data->cat_info['title'] }}</h5>
                                <h2 class="mb-3 text-dark h4">{{ $data->title }}<br><span class="text-warning">Up to {{ $data->discount }}%</span></h2>
                                <a href="{{ route('product-detail', $data->slug) }}" class="btn btn-outline-primary py-md-2 px-md-3">Shop Now</a>
                            </div>
                            <!-- Image right -->
                            <div class="col-12 col-md-6 p-0 order-1 order-md-2">
                                <img src="{{ $photo[0] }}" class="img-fluid w-100 h-100" style="object-fit: cover; max-height: 300px;" />
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endif


@php
$products = DB::table('products')
    ->where('status', 'active')
    ->where('is_featured', 1)
    ->orderByDesc('id')
    ->get();
@endphp
<!-- Products Start -->
<div class="container-fluid pt-5">
    <div class="text-center mb-4">
        <h2 class="section-title px-5"><span class="px-2">Sản phẩm nổi bật</span></h2>
    </div>
    <div class="row px-xl-5 pb-3" id="product-list">
    @foreach($products as $key => $product)
    @php
        $discounted = $product->price - ($product->price * $product->discount / 100);
    @endphp
    <div class="col-lg-3 col-md-6 col-sm-12 pb-1 product-item-wrapper" style="{{ $key >= 8 ? 'display:none;' : '' }}">
        <div class="card product-item border-0 mb-4">
            {{-- Badge Giảm giá --}}
            @if($product->discount > 0)
                <span class="position-absolute bg-danger text-white px-3 py-2 rounded-pill shadow"
                      style="top: 15px; left: 15px; font-size: 1rem; font-weight: bold; z-index: 10;">
                    -{{ $product->discount }}%
                </span>
            @endif
            <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                <img class="img-fluid w-100" style="width:426px; height:426px; object-fit:cover;" src="{{ $product->photo }}" alt="{{ $product->title }}">
            </div>
            <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
            <a href="{{ url('/product-detail/' . $product->slug) }}" class="btn btn-sm text-dark p-0">
            <h6 class="text-truncate mb-3">{{ $product->title }}</h6>
                </a>
                <div class="d-flex justify-content-center">
                    <h6>{{ number_format($discounted, 0, ',', '.') }}đ</h6>
                    @if ($product->discount > 0)
                        <h6 class="text-muted ml-2"><del>{{ number_format($product->price, 0, ',', '.') }}đ</del></h6>
                    @endif
                </div>
            </div>
<div class="card-footer bg-white border-top p-3">
    {{-- Nhóm nút Xem nhanh + Yêu thích --}}
    <div class="d-flex mb-3 flex-wrap justify-content-between btn-group-spaced">
    <a data-toggle="modal" data-target="#quickView{{ $product->id }}" class="btn btn-sm text-dark p-0" title="Quick View" href="#">
                    <i class="ti-eye text-primary mr-1"></i>Xem nhanh
                </a>
                <a title="Wishlist" href="{{ route('add-to-wishlist', $product->slug) }}" class="btn btn-sm text-dark p-0" data-id="{{ $product->id }}">
										<i class="ti-heart text-danger"></i> Yêu thích
									</a>
    </div>

    {{-- Nút Thêm vào giỏ --}}
    <a href="{{ route('add-to-cart', $product->slug) }}" 
       class="btn btn-success btn-block d-flex align-items-center justify-content-center py-3 rounded-pill font-weight-bold btn-fade"
       title="Thêm vào giỏ">
        <i class="fas fa-shopping-cart mr-2"></i> Thêm vào giỏ
    </a>
</div>

        </div>
    </div>
@endforeach

    </div>

    @if($products->count() > 8)
    <div class="text-center mt-3">
        <button id="loadMoreBtn" class="btn btn-primary">Xem thêm</button>
    </div>
    @endif
</div>

<!-- Products End -->

@include('frontend.layouts.newsletter')
<!-- Start Shop Blog -->
<section class="shop-blog section py-5 bg-light">
    <div class="container-fluid pt-5">
        <!-- Section Title -->
        <div class="row mb-5">
            <div class="col-12 text-center">
                <h2 class="section-title px-5"><span class="px-2">Từ Blog Của Chúng Tôi</span></h2>
                <p class="text-muted">Khám phá mẹo vặt, hướng dẫn và thông tin mới nhất từ blog.</p>
            </div>
        </div>

        <!-- Blog Posts -->
        <div class="row d-flex justify-content-center flex-wrap">
            @if($posts && count($posts) > 0)
                @foreach($posts->take(3) as $post)
                    <div class="col-lg-4 col-md-6">
                        <div class="card border-0 shadow-sm h-100 rounded-4 overflow-hidden">
                            <div class="position-relative">
                                <img src="{{ $post->photo }}" alt="{{ $post->title }}" class="card-img-top img-fluid" style="height: 300px; object-fit: cover;">
                                <span class="badge bg-primary position-absolute top-0 start-0 m-3 px-3 py-2 text-uppercase small">{{ $post->created_at->format('d M, Y') }}</span>
                            </div>
                            <div class="card-body d-flex flex-column p-4">
                                <h5 class="card-title mb-3">
                                    <a href="{{ route('blog.detail', $post->slug) }}" class="text-dark text-decoration-none fw-semibold hover-primary">
                                        {{ $post->title }}
                                    </a>
                                </h5>
                                <p class="card-text text-muted flex-grow-1">
                                    {{ \Illuminate\Support\Str::limit(strip_tags($post->summary), 100, '...') }}
                                </p>
                                <a href="{{ route('blog.detail', $post->slug) }}" class="btn btn-outline-primary mt-3 w-auto">
                                    Đọc tiếp <i class="fas fa-arrow-right ms-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="col-12 text-center">
                    <p class="text-muted">Không có bài viết nào được tìm thấy.</p>
                </div>
            @endif
        </div>

        <!-- Xem tất cả Blog -->
        <div class="row mt-4">
            <div class="col-12 text-center">
                <a href="{{ route('blog') }}" class="btn btn-primary px-4">
                    Xem tất cả Blog <i class="fas fa-chevron-right ms-1"></i>
                </a>
            </div>
        </div>
    </div>
</section>
<!-- End Shop Blog -->

<!-- Phần modal tách riêng sau danh sách sản phẩm -->
@foreach($products as $product)
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

                            {{-- Giá sau khi giảm --}}
                            @php $after_discount = $product->price - ($product->price * $product->discount / 100); @endphp
                            <h5 class="text-primary">{{ number_format($after_discount, 0, ',', '.') }}đ
                                @if ($product->discount > 0)
                                    <del class="text-muted ml-2">{{ number_format($product->price, 0, ',', '.') }}đ</del>
                                @endif
                            </h5>

                            {{-- Đánh giá sao --}}
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

                            {{-- Mô tả --}}
                            <p>{!! $product->summary !!}</p>

                            {{-- Nút mua --}}
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
        /* Banner Sliding */
        #Gslider .carousel-inner {
        background: #000000;
        color:black;
        }

        #Gslider .carousel-inner{
        height: 550px;
        }
        #Gslider .carousel-inner img{
            width: 100% !important;
            opacity: .8;
        }

        #Gslider .carousel-inner .carousel-caption {
        bottom: 60%;
        }

        #Gslider .carousel-inner .carousel-caption h1 {
        font-size: 50px;
        font-weight: bold;
        line-height: 100%;
        /* color: #F7941D; */
        color: #1e1e1e;
        }

        #Gslider .carousel-inner .carousel-caption p {
        font-size: 18px;
        color: black;
        margin: 28px 0 28px 0;
        }

        #Gslider .carousel-indicators {
        bottom: 70px;
        }
    </style>
@endpush

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script>

        /*==================================================================
        [ Isotope ]*/
        var $topeContainer = $('.isotope-grid');
        var $filter = $('.filter-tope-group');

        // filter items on button click
        $filter.each(function () {
            $filter.on('click', 'button', function () {
                var filterValue = $(this).attr('data-filter');
                $topeContainer.isotope({filter: filterValue});
            });

        });

        // init Isotope
        $(window).on('load', function () {
            var $grid = $topeContainer.each(function () {
                $(this).isotope({
                    itemSelector: '.isotope-item',
                    layoutMode: 'fitRows',
                    percentPosition: true,
                    animationEngine : 'best-available',
                    masonry: {
                        columnWidth: '.isotope-item'
                    }
                });
            });
        });

        var isotopeButton = $('.filter-tope-group button');

        $(isotopeButton).each(function(){
            $(this).on('click', function(){
                for(var i=0; i<isotopeButton.length; i++) {
                    $(isotopeButton[i]).removeClass('how-active1');
                }

                $(this).addClass('how-active1');
            });
        });
    </script>
    <script>
         function cancelFullScreen(el) {
            var requestMethod = el.cancelFullScreen||el.webkitCancelFullScreen||el.mozCancelFullScreen||el.exitFullscreen;
            if (requestMethod) { // cancel full screen.
                requestMethod.call(el);
            } else if (typeof window.ActiveXObject !== "undefined") { // Older IE.
                var wscript = new ActiveXObject("WScript.Shell");
                if (wscript !== null) {
                    wscript.SendKeys("{F11}");
                }
            }
        }

        function requestFullScreen(el) {
            // Supports most browsers and their versions.
            var requestMethod = el.requestFullScreen || el.webkitRequestFullScreen || el.mozRequestFullScreen || el.msRequestFullscreen;

            if (requestMethod) { // Native full screen.
                requestMethod.call(el);
            } else if (typeof window.ActiveXObject !== "undefined") { // Older IE.
                var wscript = new ActiveXObject("WScript.Shell");
                if (wscript !== null) {
                    wscript.SendKeys("{F11}");
                }
            }
            return false
        }
    </script>
    <script>
    let itemsToShow = 8;
    const loadMoreBtn = document.getElementById('loadMoreBtn');
    const products = document.querySelectorAll('.product-item-wrapper');

    loadMoreBtn.addEventListener('click', function () {
        let hiddenItems = Array.from(products).filter(p => p.style.display === 'none');
        for (let i = 0; i < 8 && i < hiddenItems.length; i++) {
            hiddenItems[i].style.display = 'block';
        }

        if (Array.from(products).filter(p => p.style.display === 'none').length === 0) {
            loadMoreBtn.style.display = 'none';
        }
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const toggleBtn = document.getElementById('toggle-category-btn');
        let expanded = false;

        toggleBtn.addEventListener('click', function () {
            const extras = document.querySelectorAll('.extra-category');
            extras.forEach(el => el.classList.toggle('d-none'));

            expanded = !expanded;
            toggleBtn.textContent = expanded ? 'Ẩn bớt danh mục' : 'Xem thêm danh mục';
        });
    });
</script>
@endpush
