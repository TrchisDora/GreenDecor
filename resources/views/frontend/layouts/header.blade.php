<header class="header shop">
    <!-- Topbar -->
    <div class="topbar">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-12 col-12">
                    <!-- Top Left -->
                    <div class="top-left">
                        <ul class="list-main">
                            @php
                                $settings=DB::table('settings')->get();
                                
                            @endphp
                            <li><i class="ti-headphone-alt"></i>@foreach($settings as $data) {{$data->phone}} @endforeach</li>
                            <li><i class="ti-email"></i> @foreach($settings as $data) {{$data->email}} @endforeach</li>
                        </ul>
                    </div>
                    <!--/ End Top Left -->
                </div>
                <div class="col-lg-6 col-md-12 col-12">
                    <!-- Top Right -->
                    <div class="right-content">
                        <ul class="list-main">
                            {{-- <li><i class="ti-alarm-clock"></i> <a href="#">Daily deal</a></li> --}}
                            @auth 
                                @if(Auth::user()->role=='admin')
                                <li><i class="fa fa-truck"></i> <a href="{{route('order.track')}}">Track Order</a></li>

                                    <li><i class="ti-user"></i> <a href="{{route('admin')}}"  target="_blank">Dashboard</a></li>
                                @else 
                                <li><i class="fa fa-truck"></i> <a href="{{route('order.track')}}">Track Order</a></li>

                                    <li><i class="ti-user"></i> <a href="{{route('user')}}"  target="_blank">Dashboard</a></li>
                                @endif
                                <li><i class="ti-power-off"></i> <a href="{{route('user.logout')}}">Logout</a></li>

                            @else
                                <li><i class="fa fa-sign-in"></i><a href="{{route('login.form')}}">Login /</a> <a href="{{route('register.form')}}">Register</a></li>
                            @endauth
                        </ul>
                    </div>
                    <!-- End Top Right -->
                </div>
            </div>
        </div>
    </div>
    <div class="middle-inner">
    <div class="container">
        <div class="row align-items-center justify-content-center text-center">
            <div class="col-12 col-lg-8 order-1 order-lg-2 mb-3 mb-lg-0">
                <div class="row align-items-center">
                    <div class="col-12 col-md-8 col-lg-6 mb-3 mb-lg-0">
                        <div class="search-bar">
                            <select>
                                <option>All Category</option>
                                @foreach(Helper::getAllCategory() as $cat)
                                    <option>{{$cat->title}}</option>
                                @endforeach
                            </select>
                            <form method="POST" action="{{route('product.search')}}">
                                @csrf
                                <input name="search" placeholder="Search Products Here....." type="search">
                                <button class="btnn" type="submit"><i class="ti-search"></i></button>
                            </form>
                        </div>
                    </div>
                    <div class="col-12 col-md-4 col-lg-6 d-flex justify-content-center justify-content-lg-end">
                        <div class="right-bar d-flex align-items-center gap-3 flex-wrap">

                            <!-- Wishlist -->
                            <div class="sinlge-bar shopping">
                                @php 
                                    $total_prod = 0;
                                    $total_amount = 0;
                                @endphp
                                @if(session('wishlist'))
                                    @foreach(session('wishlist') as $wishlist_items)
                                        @php
                                            $total_prod += $wishlist_items['quantity'];
                                            $total_amount += $wishlist_items['amount'];
                                        @endphp
                                    @endforeach
                                @endif
                                <a href="{{route('wishlist')}}" class="single-icon">
                                    <i class="fa fa-heart-o"></i>
                                    <span class="total-count">{{Helper::wishlistCount()}}</span>
                                </a>

                                @auth
                                    <div class="shopping-item">
                                        <div class="dropdown-cart-header">
                                            <span>{{count(Helper::getAllProductFromWishlist())}} Items</span>
                                            <a href="{{route('wishlist')}}">View Wishlist</a>
                                        </div>
                                        <ul class="shopping-list">
                                            @foreach(Helper::getAllProductFromWishlist() as $data)
                                                @php $photo = explode(',', $data->product['photo']); @endphp
                                                <li>
                                                    <a href="{{route('wishlist-delete',$data->id)}}" class="remove" title="Remove this item"><i class="fa fa-remove"></i></a>
                                                    <a class="cart-img" href="#"><img src="{{$photo[0]}}" alt="{{$photo[0]}}"></a>
                                                    <h4><a href="{{route('product-detail',$data->product['slug'])}}" target="_blank">{{$data->product['title']}}</a></h4>
                                                    <p class="quantity">{{$data->quantity}} x - <span class="amount">${{number_format($data->price,2)}}</span></p>
                                                </li>
                                            @endforeach
                                        </ul>
                                        <div class="bottom">
                                            <div class="total">
                                                <span>Total</span>
                                                <span class="total-amount">${{number_format(Helper::totalWishlistPrice(),2)}}</span>
                                            </div>
                                            <a href="{{route('cart')}}" class="btn animate">Cart</a>
                                        </div>
                                    </div>
                                @endauth
                            </div>

                            <!-- Cart -->
                            <div class="sinlge-bar shopping">
                                <a href="{{route('cart')}}" class="single-icon">
                                    <i class="ti-bag"></i> 
                                    <span class="total-count">{{Helper::cartCount()}}</span>
                                </a>
                                @auth
                                    <div class="shopping-item">
                                        <div class="dropdown-cart-header">
                                            <span>{{count(Helper::getAllProductFromCart())}} Items</span>
                                            <a href="{{route('cart')}}">View Cart</a>
                                        </div>
                                        <ul class="shopping-list">
                                            @foreach(Helper::getAllProductFromCart() as $data)
                                                @php $photo = explode(',', $data->product['photo']); @endphp
                                                <li>
                                                    <a href="{{route('cart-delete',$data->id)}}" class="remove" title="Remove this item"><i class="fa fa-remove"></i></a>
                                                    <a class="cart-img" href="#"><img src="{{$photo[0]}}" alt="{{$photo[0]}}"></a>
                                                    <h4><a href="{{route('product-detail',$data->product['slug'])}}" target="_blank">{{$data->product['title']}}</a></h4>
                                                    <p class="quantity">{{$data->quantity}} x - <span class="amount">${{number_format($data->price,2)}}</span></p>
                                                </li>
                                            @endforeach
                                        </ul>
                                        <div class="bottom">
                                            <div class="total">
                                                <span>Total</span>
                                                <span class="total-amount">${{number_format(Helper::totalCartPrice(),2)}}</span>
                                            </div>
                                            <a href="{{route('checkout')}}" class="btn animate">Checkout</a>
                                        </div>
                                    </div>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-4 order-2 order-lg-1 text-center text-lg-start">
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
                <div class="mobile-nav"></div>
            </div>
        </div>
    </div>
</div>
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


    <!-- Header Inner -->
    <div class="header-inner">
        <div class="container">
            <div class="cat-nav-head">
                <div class="row">
                    <div class="col-lg-12 col-12">
                        <div class="menu-area">
                            <!-- Main Menu -->
                            <nav class="navbar navbar-expand-lg">
                                <div class="navbar-collapse">	
                                    <div class="nav-inner">	
                                        <ul class="nav main-menu menu navbar-nav">
                                            <li class="{{Request::path()=='home' ? 'active' : ''}}"><a href="{{route('home')}}">Home</a></li>
                                            <li class="{{Request::path()=='about-us' ? 'active' : ''}}"><a href="{{route('about-us')}}">About Us</a></li>
                                            <li class="@if(Request::path()=='product-grids'||Request::path()=='product-lists')  active  @endif"><a href="{{route('product-grids')}}">Products</a><span class="new">New</span></li>												
                                                {{Helper::getHeaderCategory()}}
                                            <li class="{{Request::path()=='blog' ? 'active' : ''}}"><a href="{{route('blog')}}">Blog</a></li>									
                                               
                                            <li class="{{Request::path()=='contact' ? 'active' : ''}}"><a href="{{route('contact')}}">Contact Us</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </nav>
                            <!--/ End Main Menu -->	
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/ End Header Inner -->
</header>