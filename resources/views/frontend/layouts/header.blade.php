<style>
    .logo img {
        height: 80px;
        object-fit: contain;
    }

    .logo a {
        font-weight: bold;
        font-size: 20px;
        color: #28a745 !important; /* Màu xanh lá */
        display: flex;
        align-items: center;
        gap: 10px;
        text-decoration: none;
    }

    .logo a:hover {
        color: #218838;
    }

    .search-bar,
    .right-bar,
    .search-top {
        display: flex;
        align-items: center;
        justify-content: center;
        height: 100%;
    }

    .search-form input {
        height: 40px;
        padding: 5px 10px;
    }

    .search-form button {
        height: 40px;
    }

    .shopping-item {
        z-index: 999;
    }

    .single-icon {
        display: flex;
        align-items: center;
        gap: 5px;
    }
</style>

<header class="header shop">
    <!-- Topbar Start -->
    <div class="container-fluid">
        <div class="row bg-secondary py-2 px-xl-5">
            <div class="col-lg-6 d-none d-lg-block">
                <div class="d-inline-flex align-items-center">
                    <!-- Top Left -->
                    <div class="top-left">
                        <ul class="list-unstyled d-flex align-items-center mb-0">
                            @php $settings = DB::table('settings')->get(); @endphp
                            <li class="me-3 mr-5"><i class="ti-headphone-alt me-1"></i> @foreach($settings as $data) {{$data->phone}} @endforeach</li>
                            <li><i class="ti-email me-1"></i> @foreach($settings as $data) {{$data->email}} @endforeach</li>
                        </ul>
                    </div>
                    <!--/ End Top Left -->
                </div>
            </div>
            <div class="col-lg-6 text-center text-lg-right">
                <div class="d-inline-flex align-items-center">
                    <!-- Top Right -->
                    <div class="right-content">
                        <ul class="list-unstyled d-flex align-items-center justify-content-end mb-0">
                            @auth
                                @if(Auth::user()->role=='admin')
                                    <li class="me-3 ml-5"><i class="fa fa-truck me-1"></i> <a href="{{route('order.track')}}">Track Order</a></li>
                                    <li class="me-3 ml-5"><i class="ti-user me-1"></i> <a href="{{route('admin')}}" target="_blank">Dashboard</a></li>
                                @else
                                    <li class="me-3 ml-5"><i class="fa fa-truck me-1"></i> <a href="{{route('order.track')}}">Track Order</a></li>
                                    <li class="me-3 ml-5"><i class="ti-user me-1"></i> <a href="{{route('user')}}" target="_blank">Dashboard</a></li>
                                @endif
                                <li><i class="ti-power-off me-1 ml-5"></i> <a href="{{route('user.logout')}}">Logout</a></li>
                            @else
                                <li><i class="fa fa-sign-in me-1 ml-5"></i><a href="{{route('login.form')}}">Login /</a> <a href="{{route('register.form')}}">Register</a></li>
                            @endauth
                        </ul>
                    </div>
                    <!-- End Top Right -->
                </div>
            </div>
        </div>
    </div>
        <div class="row align-items-center py-3 px-xl-5">
            <div class="col-lg-3 d-none d-lg-block">
                <!-- Logo -->
                <div class="logo">
                    @php
                        $settings = DB::table('settings')->get();
                    @endphp                    
                    <a href="{{ route('home') }}">
                        <img src="@foreach($settings as $data){{ $data->logo }}@endforeach" alt="logo">
                        GREENDECOR
                    </a>
                </div>
                <!--/ End Logo -->
            </div>
            <div class="col-lg-6 col-6 text-left">
                <form method="POST" action="{{ route('product.search') }}">
                    @csrf
                    <div class="input-group">
                        {{-- Ô tìm kiếm --}}
                        <input name="search" value="{{ old('search') }}" type="search" class="form-control border-primary" placeholder="Search for products">
                        {{-- Nút tìm kiếm --}}
                        <div class="input-group-append">
                            <button class="btn btn-success" type="submit">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="col-lg-3 col-6 text-right">
                <!-- Wishlist -->
                <div class="btn-group">
                    <a href="{{ route('wishlist') }}" class="btn border position-relative">
                        <i class="fas fa-heart text-primary"></i>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger text-white">
                            {{ Helper::wishlistCount() }}
                        </span>
                    </a>
                    @auth
                        <div class="dropdown-menu p-3" style="min-width: 300px;">
                            <h6 class="dropdown-header">{{ count(Helper::getAllProductFromWishlist()) }} items in Wishlist</h6>
                            <div class="list-group list-group-flush">
                                @foreach(Helper::getAllProductFromWishlist() as $item)
                                    @php $photo = explode(',', $item->product['photo']); @endphp
                                    <div class="list-group-item d-flex align-items-start">
                                        <img src="{{ $photo[0] }}" alt="wishlist-img" class="me-2" width="50">
                                        <div class="flex-fill">
                                            <a href="{{ route('product-detail', $item->product['slug']) }}" class="fw-bold" target="_blank">{{ $item->product['title'] }}</a>
                                            <p class="mb-0">{{ $item->quantity }} × ${{ number_format($item->price, 2) }}</p>
                                        </div>
                                        <a href="{{ route('wishlist-delete', $item->id) }}" class="text-danger ms-2"><i class="fa fa-times"></i></a>
                                    </div>
                                @endforeach
                            </div>
                            <div class="dropdown-divider"></div>
                            <div class="d-flex justify-content-between px-2">
                                <strong>Total:</strong>
                                <span>${{ number_format(Helper::totalWishlistPrice(), 2) }}</span>
                            </div>
                            <div class="text-end mt-2">
                                <a href="{{ route('cart') }}" class="btn btn-sm btn-outline-primary">Go to Cart</a>
                            </div>
                        </div>
                    @endauth
                </div>

                <!-- Cart -->
                <div class="btn-group">
                    <a href="{{ route('cart') }}" class="btn border position-relative">
                        <i class="fas fa-shopping-cart text-primary"></i>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger text-white">
                            {{ Helper::cartCount() }}
                        </span>
                    </a>

                    @auth
                        <div class="dropdown-menu p-3" style="min-width: 300px;">
                            <h6 class="dropdown-header">{{ count(Helper::getAllProductFromCart()) }} items in Cart</h6>
                            <div class="list-group list-group-flush">
                                @foreach(Helper::getAllProductFromCart() as $item)
                                    @php $photo = explode(',', $item->product['photo']); @endphp
                                    <div class="list-group-item d-flex align-items-start">
                                        <img src="{{ $photo[0] }}" alt="cart-img" class="me-2" width="50">
                                        <div class="flex-fill">
                                            <a href="{{ route('product-detail', $item->product['slug']) }}" class="fw-bold" target="_blank">{{ $item->product['title'] }}</a>
                                            <p class="mb-0">{{ $item->quantity }} × ${{ number_format($item->price, 2) }}</p>
                                        </div>
                                        <a href="{{ route('cart-delete', $item->id) }}" class="text-danger ms-2"><i class="fa fa-times"></i></a>
                                    </div>
                                @endforeach
                            </div>
                            <div class="dropdown-divider"></div>
                            <div class="d-flex justify-content-between px-2">
                                <strong>Total:</strong>
                                <span>${{ number_format(Helper::totalCartPrice(), 2) }}</span>
                            </div>
                            <div class="text-end mt-2">
                                <a href="{{ route('checkout') }}" class="btn btn-sm btn-outline-success">Checkout</a>
                            </div>
                        </div>
                    @endauth
                </div>
            </div>
        </div>

    <!-- Topbar End -->
    <!-- Navbar Start -->
    <div class="container-fluid mb-5">
        <div class="row border-top px-xl-5">
           <div class="col-lg-3 px-0 d-none d-lg-block position-relative">
                <a class="btn shadow-none d-flex align-items-center justify-content-between bg-primary text-white w-100"
                data-toggle="collapse"
                href="#navbar-vertical"
                style="height: 65px; margin-top: -1px; padding: 0 30px;">
                    <h6 class="m-0">Danh mục sản phẩm</h6>
                    <i class="fa fa-angle-down text-dark"></i>
                </a>
                <nav class="collapse navbar navbar-vertical navbar-light align-items-start p-0 border border-top-0 border-bottom-0 position-absolute w-100 bg-white {{ Request::is('/') ? 'show' : '' }}"
                    id="navbar-vertical"
                    style="z-index: 999; top: 100%; left: 0;">
                    <div class="navbar-nav w-100 overflow-hidden" style="height: 410px;">
                        @php
                            $categories = App\Models\Category::whereNull('parent_id')->get();
                        @endphp
                        @foreach($categories as $category)
                            <div class="nav-item dropdown d-flex align-items-center justify-content-between px-4 py-2">
                                <a href="{{ route('product-grids-cat', $category->slug) }}" class="nav-link">
                                    {{ $category->title }}
                                </a>
                                <a href="#" class="nav-link px-1" data-toggle="dropdown">
                                            <i class="fa fa-angle-down"></i>
                                        </a>
                                <div class="dropdown-menu position-absolute border-0 rounded-0 w-100 m-0">
                                    @foreach($category->child_cat as $sub_category)
                                        <a href="{{ route('product-grids-sub-cat', [$category->slug, $sub_category->slug]) }}" class="dropdown-item">
                                            {{ $sub_category->title }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach

                    </div>
                </nav>            
            </div>
            <div class="col-lg-9">
                <nav class="navbar navbar-expand-lg bg-light navbar-light py-3 py-lg-0 px-0">
                    <div class="logo d-block d-lg-none">
                        @php
                            $settings = DB::table('settings')->get();
                        @endphp                    
                        <a href="{{ route('home') }}">
                            <img src="@foreach($settings as $data){{ $data->logo }}@endforeach" alt="logo">
                            GREENDECOR
                        </a>
                    </div>
                    <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                        <div class="navbar-nav mr-auto py-0">
                            <ul class="nav navbar-nav">
                                <li class="nav-item {{Request::path() == 'home' ? 'active' : ''}}">
                                    <a href="{{route('home')}}" class="nav-link">Home</a>
                                </li>

                                <li class="nav-item {{Request::path() == 'about-us' ? 'active' : ''}}">
                                    <a href="{{route('about-us')}}" class="nav-link">About Us</a>
                                </li>

                                <li class="nav-item {{Request::path() == 'product-grids' || Request::path() == 'product-lists' ? 'active' : ''}}">
                                    <a href="{{route('product-grids')}}" class="nav-link">Products</a>
                                </li>

                                <li class="nav-item {{Request::path() == 'blog' ? 'active' : ''}}">
                                    <a href="{{route('blog')}}" class="nav-link">Blog</a>
                                </li>

                                <li class="nav-item {{Request::path() == 'contact' ? 'active' : ''}}">
                                    <a href="{{route('contact')}}" class="nav-link">Contact Us</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
    </div>
    <!-- Navbar End -->
</header>