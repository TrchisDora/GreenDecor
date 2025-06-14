<ul class="navbar-nav bg-gradient-info sidebar sidebar-dark accordion" id="accordionSidebar">

  <!-- Mục - Trang chủ -->
  <li class="nav-item active">
    <a class="nav-link" href="{{ route('admin') }}">
      @php
        $settings = DB::table('settings')->first();
      @endphp

      <!-- Hiển thị logo -->
      @if ($settings && $settings->logo)
        <img src="{{ asset($settings->logo) }}" alt="logo" width="50" height="50">
      @else
        <img src="{{ asset('default_logo.png') }}" alt="logo" width="50" height="50">
      @endif
      <span>GreenDecor</span>
    </a>
  </li>

  <!-- Gạch ngang -->
  <hr class="sidebar-divider my-0">

  <!-- Trang tổng quan -->
  <li class="nav-item active">
    <a class="nav-link" href="{{route('admin')}}">
      <i class="fas fa-fw fa-tachometer-alt"></i>
      <span>Bảng điều khiển</span>
    </a>
  </li>

  <hr class="sidebar-divider">

  <!-- Tiêu đề -->
  <div class="sidebar-heading">
    Quản lý Banner
  </div>

  <!-- Quản lý media -->
  <li class="nav-item">
    <a class="nav-link" href="{{route('file-manager')}}">
      <i class="fas fa-fw fa-chart-area"></i>
      <span>Trình quản lý Media</span>
    </a>
  </li>

  <!-- Banner -->
  <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true"
      aria-controls="collapseTwo">
      <i class="fas fa-image"></i>
      <span>Banner</span>
    </a>
    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <h6 class="collapse-header">Tùy chọn Banner:</h6>
        <a class="collapse-item" href="{{route('banner.index')}}">Danh sách Banner</a>
        <a class="collapse-item" href="{{route('banner.create')}}">Thêm Banner</a>
      </div>
    </div>
  </li>

  <hr class="sidebar-divider">

  <div class="sidebar-heading">
    Cửa hàng
  </div>

  <!-- Danh mục -->
  <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#categoryCollapse" aria-expanded="true"
      aria-controls="categoryCollapse">
      <i class="fas fa-sitemap"></i>
      <span>Danh mục</span>
    </a>
    <div id="categoryCollapse" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <h6 class="collapse-header">Tùy chọn Danh mục:</h6>
        <a class="collapse-item" href="{{route('category.index')}}">Danh sách Danh mục</a>
        <a class="collapse-item" href="{{route('category.create')}}">Thêm Danh mục</a>
      </div>
    </div>
  </li>

  <!-- Sản phẩm -->
  <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#productCollapse" aria-expanded="true"
      aria-controls="productCollapse">
      <i class="fas fa-cubes"></i>
      <span>Sản phẩm</span>
    </a>
    <div id="productCollapse" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <h6 class="collapse-header">Tùy chọn Sản phẩm:</h6>
        <a class="collapse-item" href="{{route('product.index')}}">Danh sách Sản phẩm</a>
        <a class="collapse-item" href="{{route('product.create')}}">Thêm Sản phẩm</a>
      </div>
    </div>
  </li>

  <!-- Thương hiệu -->
  <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#brandCollapse" aria-expanded="true"
      aria-controls="brandCollapse">
      <i class="fas fa-table"></i>
      <span>Thương hiệu</span>
    </a>
    <div id="brandCollapse" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <h6 class="collapse-header">Tùy chọn Thương hiệu:</h6>
        <a class="collapse-item" href="{{route('brand.index')}}">Danh sách Thương hiệu</a>
        <a class="collapse-item" href="{{route('brand.create')}}">Thêm Thương hiệu</a>
      </div>
    </div>
  </li>

  <!-- Vận chuyển -->
  <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#shippingCollapse" aria-expanded="true"
      aria-controls="shippingCollapse">
      <i class="fas fa-truck"></i>
      <span>Vận chuyển</span>
    </a>
    <div id="shippingCollapse" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <h6 class="collapse-header">Tùy chọn Vận chuyển:</h6>
        <a class="collapse-item" href="{{route('shipping.index')}}">Danh sách Vận chuyển</a>
        <a class="collapse-item" href="{{route('shipping.create')}}">Thêm phương thức</a>
      </div>
    </div>
  </li>

  <!-- Đơn hàng -->
  <li class="nav-item">
    <a class="nav-link" href="{{route('order.index')}}">
      <i class="fas fa-cart-plus"></i>
      <span>Đơn hàng</span>
    </a>
  </li>

  <!-- Đánh giá -->
  <li class="nav-item">
    <a class="nav-link" href="{{route('review.index')}}">
      <i class="fas fa-comments"></i>
      <span>Đánh giá</span>
    </a>
  </li>

  <hr class="sidebar-divider">

  <div class="sidebar-heading">
    Bài viết
  </div>

  <!-- Bài viết -->
  <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#postCollapse" aria-expanded="true"
      aria-controls="postCollapse">
      <i class="fas fa-fw fa-folder"></i>
      <span>Bài viết</span>
    </a>
    <div id="postCollapse" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <h6 class="collapse-header">Tùy chọn Bài viết:</h6>
        <a class="collapse-item" href="{{route('post.index')}}">Danh sách Bài viết</a>
        <a class="collapse-item" href="{{route('post.create')}}">Thêm Bài viết</a>
      </div>
    </div>
  </li>

  <!-- Danh mục bài viết -->
  <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#postCategoryCollapse"
      aria-expanded="true" aria-controls="postCategoryCollapse">
      <i class="fas fa-sitemap fa-folder"></i>
      <span>Danh mục bài viết</span>
    </a>
    <div id="postCategoryCollapse" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <h6 class="collapse-header">Tùy chọn Danh mục:</h6>
        <a class="collapse-item" href="{{route('post-category.index')}}">Danh sách Danh mục</a>
        <a class="collapse-item" href="{{route('post-category.create')}}">Thêm Danh mục</a>
      </div>
    </div>
  </li>

  <!-- Thẻ -->
  <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#tagCollapse" aria-expanded="true"
      aria-controls="tagCollapse">
      <i class="fas fa-tags fa-folder"></i>
      <span>Thẻ (Tags)</span>
    </a>
    <div id="tagCollapse" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <h6 class="collapse-header">Tùy chọn Thẻ:</h6>
        <a class="collapse-item" href="{{route('post-tag.index')}}">Danh sách Thẻ</a>
        <a class="collapse-item" href="{{route('post-tag.create')}}">Thêm Thẻ</a>
      </div>
    </div>
  </li>

  <!-- Bình luận -->
  <li class="nav-item">
    <a class="nav-link" href="{{route('comment.index')}}">
      <i class="fas fa-comments fa-chart-area"></i>
      <span>Bình luận</span>
    </a>
  </li>

  <hr class="sidebar-divider d-none d-md-block">

  <div class="sidebar-heading">
    Cài đặt chung
  </div>

  <!-- Mã giảm giá -->
  <li class="nav-item">
    <a class="nav-link" href="{{route('coupon.index')}}">
      <i class="fas fa-table"></i>
      <span>Mã giảm giá</span>
    </a>
  </li>

  <!-- Người dùng -->
  <li class="nav-item">
    <a class="nav-link" href="{{route('users.index')}}">
      <i class="fas fa-users"></i>
      <span>Người dùng</span>
    </a>
  </li>

  <!-- Cài đặt hệ thống -->
  <li class="nav-item">
    <a class="nav-link" href="{{route('settings')}}">
      <i class="fas fa-cog"></i>
      <span>Cài đặt</span>
    </a>
  </li>

  <!-- Nút thu gọn -->
  <div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
  </div>

</ul>
