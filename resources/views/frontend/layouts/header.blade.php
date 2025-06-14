<style>
    .logo img {
        height: 80px;
        object-fit: contain;
    }

    .logo a {
        font-weight: bold;
        font-size: 45px;
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
    <div class="row py-2 px-xl-5 border-bottom border-secondary">
            <div class="col-lg-6 d-none d-lg-block">
                <div class="d-inline-flex align-items-center">
                    <!-- Top Left -->
                    <div class="top-left">
                        <ul class="list-unstyled d-flex align-items-center mb-0">
                            @php $settings = DB::table('settings')->get(); @endphp
                            <li class="me-3 mr-5"><i class="fa fa-phone fa-sm fa-fw me-2 text-gray-400"></i> @foreach($settings as $data) {{$data->phone}} @endforeach</li>
                            <li><i class="fa fa-envelope fa-sm fa-fw me-2 text-gray-400"></i> @foreach($settings as $data) {{$data->email}} @endforeach</li>
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
                        <li>
                            <a class="text-dark px-2" href="https://www.facebook.com/TrChisnguyen1807">
                                <iconify-icon icon="simple-icons:facebook" width="24" height="24"></iconify-icon>
                            </a>
                        </li>
                        <li>
                            <a class="text-dark px-2" href="https://www.instagram.com/trchisdora/">
                                <iconify-icon icon="simple-icons:instagram" width="24" height="24"></iconify-icon>
                            </a>
                        </li>
                        <li>
                            <a class="text-dark px-2" href="https://zalo.me/0395517801">
                                <iconify-icon icon="simple-icons:zalo" width="24" height="24"></iconify-icon>
                            </a>
                        </li>
                        <li>
                            <a class="text-dark px-2" href="https://www.youtube.com/@trichinguyen7578">
                                <iconify-icon icon="simple-icons:youtube" width="24" height="24"></iconify-icon>
                            </a>
                        </li>
                        <li>
                            <a class="text-dark px-2" href="https://www.tiktok.com/@thenknge?lang=vi-VN">
                                <iconify-icon icon="simple-icons:tiktok" width="24" height="24"></iconify-icon>
                            </a>
                        </li>
                        <li>
                            <a class="text-dark px-2" href="https://shopee.vn/luatraon_offcial?entryPoint=ShopBySearch&searchKeyword=l%C3%BAa%20tr%C3%A0%20%C3%B4n">
                                <iconify-icon icon="simple-icons:shopee" width="24" height="24"></iconify-icon>
                            </a>
                        </li>
                    </ul>
                    </div>
                    <!-- End Top Right -->
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row align-items-center py-1 px-xl-5">
            <div class="col-lg-3 d-none d-lg-block">
                <!-- Logo -->
                <div class="logo">
                    @php
                        $settings = DB::table('settings')->get();
                    @endphp                    
                    <a href="{{ route('home') }}">
                        <img src="@foreach($settings as $data){{ Helper::fixStoragePath($data->logo) }}@endforeach" alt="logo" style="object-fit: cover; width: 80px; height: 80px;" >
                        GreenDecor
                    </a>
                </div>
                <!--/ End Logo -->
            </div>
            <div class="col-lg-6 col-6 text-left">
                <form method="POST" action="{{ route('product.search') }}">
                    @csrf
                    <div class="input-group">
                        {{-- Ô tìm kiếm --}}
                        <input name="search" value="{{ old('search') }}" type="search" class="form-control border-primary" placeholder="Nhập sản phẩm muốn tìm kiếm">
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
                    <a href="{{ route('wishlist') }}" class="btn btn-lg position-relative">
                        <i class="fas fa-heart text-primary"></i>
                        @if(Helper::wishlistCount() > 0)
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger text-white">
                                {{ Helper::wishlistCount() }}
                            </span>
                        @endif
                    </a>
                    @auth
                        <div class="dropdown-menu p-3" style="min-width: 300px;">
                            <h6 class="dropdown-header">{{ count(Helper::getAllProductFromWishlist()) }} sản phẩm trong Yêu thích</h6>
                            <div class="list-group list-group-flush">
                                @foreach(Helper::getAllProductFromWishlist() as $item)
                                    @php $photo = explode(',', $item->product['photo']); @endphp
                                    <div class="list-group-item d-flex align-items-start">
                                        <img src="{{ Helper::fixStoragePath($photo[0]) }}" alt="wishlist-img" class="me-2 mr-3" width="50">
                                        <div class="flex-fill">
                                            <a href="{{ route('product-detail', $item->product['slug']) }}" class="fw-bold" target="_blank">{{ $item->product['title'] }}</a>
                                            <p class="mb-0">{{ $item->quantity }} × {{ number_format($item->price) }} đ</p>
                                        </div>
                                        <a href="{{ route('wishlist-delete', $item->id) }}" class="text-danger ms-2"><i class="fa fa-times"></i></a>
                                    </div>
                                @endforeach
                            </div>
                            <div class="dropdown-divider"></div>
                            <div class="d-flex justify-content-between px-2">
                                <strong>Tổng cộng:</strong>
                                <span>{{ number_format(Helper::totalWishlistPrice()) }} đ</span>
                            </div>
                            <div class="text-end mt-2">
                                <a href="{{ route('cart') }}" class="btn btn-block btn-primary my-3 py-3">Thêm vào giỏ hàng</a>
                            </div>
                        </div>
                    @endauth
                </div>

                <!-- Cart -->
                <div class="btn-group">
                    <a href="{{ route('cart') }}" class="btn btn-lg position-relative">
                        <i class="fas fa-shopping-cart text-primary"></i>
                         @if(Helper::cartCount() > 0)
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger text-white">
                                {{ Helper::cartCount() }}
                            </span>
                        @endif
                    </a>
                    @auth
                        <div class="dropdown-menu p-3" style="min-width: 300px;">
                            <h6 class="dropdown-header">{{ count(Helper::getAllProductFromCart()) }} sản phẩm trong Giỏ hàng</h6>
                            <div class="list-group list-group-flush">
                                @foreach(Helper::getAllProductFromCart() as $item)
                                    @php $photo = explode(',', $item->product['photo']); @endphp
                                    <div class="list-group-item d-flex align-items-start">
                                        <img src="{{ Helper::fixStoragePath($photo[0]) }}" alt="cart-img" class="me-2 mr-3" width="50">
                                        <div class="flex-fill">
                                            <a href="{{ route('product-detail', $item->product['slug']) }}" class="fw-bold" target="_blank">{{ $item->product['title'] }}</a>
                                            <p class="mb-0">{{ $item->quantity }} × {{ number_format($item->price) }} đ</p>
                                        </div>
                                        <a href="{{ route('cart-delete', $item->id) }}" class="text-danger ms-2"><i class="fa fa-times"></i></a>
                                    </div>
                                @endforeach
                            </div>
                            <div class="dropdown-divider"></div>
                            <div class="d-flex justify-content-between px-2">
                                <strong>Tổng cộng:</strong>
                                <span>{{ number_format(Helper::totalCartPrice()) }} đ</span>
                            </div>
                            <div class="text-end mt-2">
                                <a href="{{ route('checkout') }}" class="btn btn-block btn-primary my-3 py-3">Thanh toán ngay</a>
                            </div>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </div>
    <!-- Topbar End -->
    <!-- Navbar Start -->
    <div class="container-fluid">
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
            <nav class="navbar navbar-expand-lg bg-light navbar-light py-3 py-lg-0 px-3 px-lg-0">
                    <div class="container-fluid justify-content-between align-items-center">
                        <!-- Logo + nút toggle (chỉ hiện trên màn hình nhỏ) -->
                        <div class="d-flexjustify-content-between align-items-center d-lg-none">
                            <div class="logo">
                                @php
                                    $settings = DB::table('settings')->get();
                                @endphp
                                <a href="{{ route('home') }}">
                                    <img src="@foreach($settings as $data){{ Helper::fixStoragePath($data->logo) }}@endforeach" alt="logo" height="30">
                                    GreenDecor
                                </a>
                            </div>
                        </div>
                        {{-- Phần bên phải của màn hình nhỏ: toggle + user --}}
                        <div class="d-flex align-items-center d-lg-none ms-auto">
                            {{-- Menu user bản mobile --}}
                            <ul class="list-unstyled d-flex align-items-center mb-0 me-2">
                            {{-- Toggle menu --}}
                            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse">
                                <span class="navbar-toggler-icon"></span>
                            </button>
                            @auth
                                    <li class="nav-item dropdown no-arrow">
                                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" data-toggle="dropdown">
                                            <span class="me-2 text-gray-600 small mr-2">{{ Auth()->user()->name }}</span>
                                            @if(Auth()->user()->photo)
                                                <img class="img-fluid rounded-circle" src="{{ Helper::fixStoragePath(Auth()->user()->photo) }}" style="object-fit: cover; width: 50px; height: 50px;" alt="User Photo">
                                            @else
                                                <img class="img-fluid rounded-circle" src="{{ asset('backend/img/avatar.png') }}" style="object-fit: cover; width: 50px; height: 50px;" alt="Default Avatar">
                                            @endif  
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                            <a class="dropdown-item" href="{{route('user-profile')}}">
                                                <i class="fas fa-user fa-sm fa-fw me-2 text-gray-400"></i> Profile
                                            </a>
                                            <a class="dropdown-item" href="{{route('order.track')}}">
                                                <i class="fa fa-truck fa-sm fa-fw me-2 text-gray-400"></i> Track Order
                                            </a>
                                            <a class="dropdown-item" href="{{route('admin')}}" target="_blank">
                                                <i class="ti-user fa-sm fa-fw me-2 text-gray-400"></i> Dashboard
                                            </a>
                                            <a class="dropdown-item" href="{{route('user.change.password.form')}}">
                                                <i class="fas fa-key fa-sm fa-fw me-2 text-gray-400"></i> Change Password
                                            </a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="{{ route('logout') }}"
                                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                                <i class="fas fa-sign-out-alt fa-sm fa-fw me-2 text-gray-400"></i> Logout
                                            </a>
                                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
                                        </div>
                                    </li>
                                @else
                                    <li class="ms-3">
                                        <i class="fa fa-sign-in me-1"></i>
                                        <a href="{{route('login.form')}}">Login /</a>
                                        <a href="{{route('register.form')}}">Register</a>
                                    </li>
                                @endauth
                            </ul>
                        </div>
                        {{-- Nội dung chính: collapse --}}
                        <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                            {{-- Menu chính bên trái --}}
                            <ul class="navbar-nav mr-auto py-0">
                                <li class="nav-item {{Request::path() == 'home' ? 'active' : ''}}">
                                    <a href="{{route('home')}}" class="nav-link">Trang chủ</a>
                                </li>
                                <li class="nav-item {{Request::path() == 'about-us' ? 'active' : ''}}">
                                    <a href="{{route('about-us')}}" class="nav-link">Về chúng tôi</a>
                                </li>
                                <li class="nav-item {{Request::path() == 'product-grids' || Request::path() == 'product-lists' ? 'active' : ''}}">
                                    <a href="{{route('product-grids')}}" class="nav-link">Sản phẩm</a>
                                </li>
                                <li class="nav-item {{Request::path() == 'blog' ? 'active' : ''}}">
                                    <a href="{{route('blog')}}" class="nav-link">Bài viết</a>
                                </li>
                                <li class="nav-item {{Request::path() == 'contact' ? 'active' : ''}}">
                                    <a href="{{route('contact')}}" class="nav-link">Liên hệ</a>
                                </li>
                            </ul>

                            {{-- Menu user desktop bên phải --}}
                            <ul class="list-unstyled d-none d-lg-flex align-items-center mb-0">
                                @auth
                                    <li class="nav-item dropdown no-arrow">
                                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" data-toggle="dropdown">
                                            <span class="me-2 mr-2 text-gray-600 small">{{ Auth()->user()->name }}</span>
                                            @if(Auth()->user()->photo)
                                                <img class="img-fluid rounded-circle" src="{{ Helper::fixStoragePath(Auth()->user()->photo) }}" style="object-fit: cover; width: 50px; height: 50px;" alt="User Photo">
                                            @else
                                                <img class="img-fluid rounded-circle" src="{{ asset('backend/img/avatar.png') }}" style="object-fit: cover; width: 50px; height: 50px;" alt="Default Avatar">
                                            @endif
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                            <a class="dropdown-item" href="{{route('user-profile')}}">
                                                <i class="fas fa-user fa-sm fa-fw me-2 text-gray-400"></i> Thông tin cá nhân
                                            </a>
                                            <a class="dropdown-item" href="{{route('order.track')}}">
                                                <i class="fa fa-truck fa-sm fa-fw me-2 text-gray-400"></i> Theo dỗi đơn hàng
                                            </a>
                                            <a class="dropdown-item" href="{{route('admin')}}" target="_blank">
                                                <i class="ti-user fa-sm fa-fw me-2 text-gray-400"></i> Bảng điều kiển
                                            </a>
                                            <a class="dropdown-item" href="{{route('user.change.password.form')}}">
                                                <i class="fas fa-key fa-sm fa-fw me-2 text-gray-400"></i> Thay đổi mật khẩu
                                            </a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="{{ route('logout') }}"
                                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                                <i class="fas fa-sign-out-alt fa-sm fa-fw me-2 text-gray-400"></i> Đăng xuất
                                            </a>
                                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
                                        </div>
                                    </li>
                                @else
                                    <li class="ms-3">
                                        <i class="fa fa-sign-in me-1"></i>
                                        <a href="{{ route('login.form') }}" class="text-decoration-none">
                                            <i class="fas fa-sign-out-alt fa-sm fa-fw me-2 text-gray-400 mr-2"></i>Đăng nhập /
                                        </a>
                                        <a href="{{ route('register.form') }}" class="text-decoration-none">Đăng ký</a>
                                    </li>
                                @endauth
                            </ul>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
    </div>
    <!-- Navbar End -->
</header>