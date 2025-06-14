@extends('frontend.layouts.master')

@section('title','Ecommerce Laravel || PRODUCT PAGE')

@section('main-content')
	
<!-- Page Header Start -->
<div class="container-fluid bg-secondary mb-5">
    <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
        <h1 class="font-weight-semi-bold text-uppercase mb-3">Cửa hàng của chúng tôi</h1>
        <div class="d-inline-flex">
            <p class="m-0"><a href="{{ route('home') }}" class="text-dark">Trang chủ</a></p>
            <p class="m-0 px-2">-</p>
            <p class="m-0">Cửa hàng của chúng tôi</p>
        </div>
    </div>
</div>
<!-- Page Header End -->
    <!-- Shop Start -->
<div class="container-fluid pt-5">
    <div class="row px-xl-5">
<div class="col-lg-2 col-md-12 col-12">
            <aside class="shop-sidebar">
                {{-- Categories --}}
                <div class="card mb-4 shadow-sm border-0 rounded" style="border-radius: 20px;">
                    <div class="card-header bg-primary text-white font-weight-bold">
                        <i class="fa fa-list"></i> Loại sản phẩm
                    </div>
                    <ul class="list-group list-group-flush bg-secondary">
                        @php $menu = App\Models\Category::getAllParentWithChild(); @endphp
                        @if($menu)
                            @foreach($menu as $cat_info)
                                @if($cat_info->child_cat->count() > 0)
                                    <li class="list-group-item bg-secondary border-0">
                                        <a href="{{ route('product-lists-cat', $cat_info->slug) }}" class="nav-link font-weight-bold d-block">{{ $cat_info->title }}</a>
                                        <ul class="pl-3 mt-1">
                                            @foreach($cat_info->child_cat as $sub_menu)
                                                <li>
                                                    <a href="{{ route('product-lists-sub-cat', [$cat_info->slug, $sub_menu->slug]) }}" class="nav-link font-weight-bold d-block">{{ $sub_menu->title }}</a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </li>
                                @else
                                    <li class="list-group-item bg-secondary border-0">
                                        <a href="{{ route('product-lists-cat', $cat_info->slug) }}" class="nav-link font-weight-bold d-block">{{ $cat_info->title }}</a>
                                    </li>
                                @endif
                            @endforeach
                        @endif
                    </ul>
                </div>

                {{-- Brands --}}
                <div class="card mb-4 shadow-sm border-0 rounded" style="border-radius: 20px;">
                    <div class="card-header bg-primary text-white font-weight-bold">
                        <i class="fa fa-tags"></i> Thương hiệu
                    </div>
                    <ul class="list-group list-group-flush">
                        @php
                            $brands = DB::table('brands')->where('status', 'active')->orderBy('title')->get();
                            $currentBrands = request()->has('brand') ? explode(',', request()->brand) : [];
                            $currentQuery = request()->except('brand');
                        @endphp
                        @foreach($brands as $brand)
                            @php
                                $updatedBrands = $currentBrands;
                                if (in_array($brand->slug, $currentBrands)) {
                                    $updatedBrands = array_diff($currentBrands, [$brand->slug]); 
                                } else {
                                    $updatedBrands[] = $brand->slug;
                                }

                                // Chỉ thêm brand vào mà không thay đổi thứ tự
                                $query = array_merge($currentQuery, ['brand' => implode(',', $updatedBrands)]);
                            @endphp
                            <li class="list-group-item bg-secondary border-0">
                                <a href="{{ url()->current() . '?' . http_build_query($query) }}"
                                    class="{{ in_array($brand->slug, $currentBrands) ? 'font-weight-bold text-info' : '' }}">
                                    {{ $brand->title }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="card mb-4 shadow-sm border-0" style="border-radius: 20px;">
                    <div class="card-header bg-primary text-white font-weight-bold">
                        <i class="fa fa-tags"></i> Giá
                    </div>
                    <ul class="list-group list-group-flush">
                        @php
                            // Lấy các mức giá lọc
                            $priceRanges = [
                                '0-10000' => 'Under 10.000đ',
                                '10000-50000' => '10.000đ - 50.000đ',
                                '50000-100000' => '50.000đ - 100.000đ',
                                '100000-500000' => '100.000đ - 500.000đ',
                                '500000-1000000' => '500.000đ - 1.000.000đ'
                            ];
                            // Lấy mức giá hiện tại từ URL
                            $currentPrice = request()->has('price') ? request()->price : null;
                            $currentQuery = request()->except('price');
                        @endphp

                        @foreach($priceRanges as $range => $label)
                            @php
                                // Lấy phạm vi giá để lọc
                                $priceFilter = $currentPrice == $range ? null : $range;
                                // Cập nhật URL query string
                                $query = array_merge($currentQuery, ['price' => $priceFilter]);
                            @endphp
                            <li class="list-group-item bg-secondary border-0">
                                <a href="{{ url()->current() . '?' . http_build_query($query) }}"
                                class="nav-link {{ $currentPrice == $range ? 'font-weight-bold text-info' : '' }}">
                                    {{ $label }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
                {{-- Recently Added --}}
                <div class="card mb-4 shadow-sm border-0 rounded" style="border-radius: 20px;">
                    <div class="card-header bg-primary text-white font-weight-bold">
                        <i class="fa fa-clock"></i> Sản phẩm thêm gần đây
                    </div>
                    <div class="card-body bg-secondary">
                        @foreach($recent_products as $product)
                            @php 
                                $photo = explode(',', $product->photo);
                                $org = ($product->price - ($product->price * $product->discount) / 100);
                            @endphp
                            <div class="media mb-3 border-bottom pb-2">
                                <img src="{{ $photo[0] }}" alt="{{ $product->title }}" class="mr-3" style="width: 60px;">
                                <div class="media-body">
                                    <h6 class="mt-0 mb-1"><a href="{{ route('product-detail', $product->slug) }}" class="nav-link p-0">{{ $product->title }}</a></h6>
                                    <small>
                                        <del class="text-muted">{{ number_format($product->price) }} đ</del>
                                        <span class="text-danger">{{ number_format($org) }} đ</span>
                                    </small>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </aside>
        </div>
        <div class="col-lg-10 col-md-12 col-12">
            <form method="GET" action="{{ url()->current() }}">
                <div class="row mb-4">
                    <div class="col-12 d-flex flex-wrap justify-content-between align-items-center">
                        <div class="form-inline mb-2 mb-md-0">
                            <label class="mr-2">Hiển thị:</label>
                            <select class="form-control form-control-sm mr-3" name="show" onchange="this.form.submit();">
                                <option value="">Mặc định</option>
                                <option value="9" {{ request('show') == '9' ? 'selected' : '' }}>09</option>
                                <option value="15" {{ request('show') == '15' ? 'selected' : '' }}>15</option>
                                <option value="21" {{ request('show') == '21' ? 'selected' : '' }}>21</option>
                                <option value="30" {{ request('show') == '30' ? 'selected' : '' }}>30</option>
                            </select>

                            <label class="mr-2">Sắp xếp theo:</label>
                            <select class="form-control form-control-sm" name="sortBy" onchange="this.form.submit();">
                                <option value="">Mặc định</option>
                                <option value="title" {{ request('sortBy') == 'title' ? 'selected' : '' }}>Tên</option>
                                <option value="price" {{ request('sortBy') == 'price' ? 'selected' : '' }}>Giá</option>
                                <option value="category" {{ request('sortBy') == 'category' ? 'selected' : '' }}>Danh mục</option>
                                <option value="brand" {{ request('sortBy') == 'brand' ? 'selected' : '' }}>Thương hiệu</option>
                            </select>
                        </div>
                        @php
                            $currentPath = request()->path();
                            $gridPath = str_replace('product-lists', 'product-grids', $currentPath);
                            $fullGridUrl = url($gridPath) . '?' . http_build_query(request()->query());
                        @endphp
                        <ul class="nav">
                            <li class="nav-item">
                                <a href="{{ $fullGridUrl }}" class="nav-link">
                                    <i class="fa fa-th-large"></i>
                                </a>
                            </li>
                            <li class="nav-item active">
                                <a href="javascript:void(0)" class="nav-link">
                                    <i class="fa fa-th-list"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- Thêm các tham số khác vào form để giữ lại chúng -->
                <input type="hidden" name="brand" value="{{ request('brand') }}">
                <button type="submit" style="display: none;"></button>          
            </form>
            <div class="row">
                @if(count($products))
                    @foreach($products as $product)
                        <div class="col-12 mb-4">
                            <div class="card shadow-sm">
                                <div class="row no-gutters">
                                    <div class="col-md-4 position-relative">
                                        {{-- Badge Giảm giá --}}
                                        @if($product->discount > 0)
                                            <span class="position-absolute bg-danger text-white px-3 py-2 rounded-pill shadow"
                                                style="top: 15px; left: 15px; font-size: 1rem; font-weight: bold; z-index: 10;">
                                                -{{ $product->discount }}%
                                            </span>
                                        @endif
                                        <a href="{{ route('product-detail', $product->slug) }}">
                                            @php $photo = explode(',', $product->photo); @endphp
                                            <img src="{{ $photo[0] }}" alt="{{ $product->title }}"
                                                class="img-fluid w-100"
                                                style="height: 426px; object-fit: cover;">
                                        </a>
                                    </div>

                                    <div class="col-md-8 d-flex flex-column justify-content-between p-3">
                                        <div>
                                            <h5>
                                                <a href="{{ route('product-detail', $product->slug) }}" class="nav-link p-0 font-weight-bold d-block">
                                                    {{ $product->title }}
                                                </a>
                                            </h5>

                                            @php
                                                $after_discount = $product->price - ($product->price * $product->discount / 100);
                                                $rate = DB::table('product_reviews')->where('product_id', $product->id)->avg('rate');
                                            @endphp

                                            <div class="mb-2">
                                                <span class="text-primary h6">
                                                    {{ number_format($after_discount) }} đ
                                                </span>
                                                <del class="text-muted ml-2">
                                                    {{ number_format($product->price) }} đ
                                                </del>
                                            </div>

                                            <div class="mb-2">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <i class="fa fa-star {{ $rate >= $i ? 'text-warning' : 'text-muted' }}"></i>
                                                @endfor
                                                <small class="ml-2 text-muted">({{ number_format($rate, 1) }}/5)</small>
                                            </div>

                                            <p class="text-muted">
                                                {!! Str::limit(strip_tags($product->summary), 100) !!}
                                            </p>
                                        </div>

                                        <div class="d-flex flex-wrap mt-3">
                                            <a href="{{ route('add-to-wishlist', $product->slug) }}"
                                            class="btn btn-outline-danger btn-sm mr-2 mb-2">
                                                <i class="ti-heart"></i> Yêu thích
                                            </a>
                                            <a href="{{ route('add-to-cart', $product->slug) }}"
                                            class="btn btn-outline-primary btn-sm mr-2 mb-2">
                                                <i class="fas fa-shopping-cart"></i> Thêm vào giỏ
                                            </a>
                                            <a data-toggle="modal" data-target="#quickView{{ $product->id }}"
                                            class="btn btn-outline-primary btn-sm mb-2">
                                                <i class="ti-eye"></i> Xem nhanh
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="col-12 text-center">
                        <h4 class="text-danger my-5">
                            Rất tiếc, không tìm thấy sản phẩm nào phù hợp.
                        </h4>
                    </div>
                @endif
            </div>
            <div class="row mt-4">
                <div class="col-md-12 d-flex justify-content-center">
                    {{-- {{ $products->appends($_GET)->links() }} --}}
                </div>
            </div>
        </div>
    </div>
</div>
    <!-- Shop End -->
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
@push ('styles')
<style>
	 .pagination{
        display:inline-flex;
    }
	.filter_button{
        /* height:20px; */
        text-align: center;
        background:#8c52ff;
        padding:8px 16px;
        margin-top:10px;
        color: white;
    }
</style>
@endpush
@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

    {{-- <script>
        $('.cart').click(function(){
            var quantity=1;
            var pro_id=$(this).data('id');
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
							// document.location.href=document.location.href;
						}); 
                    }
                }
            })
        });
	</script> --}}
	<script>
        $(document).ready(function(){
        /*----------------------------------------------------*/
        /*  Jquery Ui slider js
        /*----------------------------------------------------*/
        if ($("#slider-range").length > 0) {
            const max_value = parseInt( $("#slider-range").data('max') ) || 500;
            const min_value = parseInt($("#slider-range").data('min')) || 0;
            const currency = $("#slider-range").data('currency') || '';
            let price_range = min_value+'-'+max_value;
            if($("#price_range").length > 0 && $("#price_range").val()){
                price_range = $("#price_range").val().trim();
            }
            
            let price = price_range.split('-');
            $("#slider-range").slider({
                range: true,
                min: min_value,
                max: max_value,
                values: price,
                slide: function (event, ui) {
                    $("#amount").val(currency + ui.values[0] + " -  "+currency+ ui.values[1]);
                    $("#price_range").val(ui.values[0] + "-" + ui.values[1]);
                }
            });
            }
        if ($("#amount").length > 0) {
            const m_currency = $("#slider-range").data('currency') || '';
            $("#amount").val(m_currency + $("#slider-range").slider("values", 0) +
                "  -  "+m_currency + $("#slider-range").slider("values", 1));
            }
        })
    </script>

@endpush