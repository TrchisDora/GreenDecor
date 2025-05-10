@extends('user.layouts.master')

@section('title', 'Order Detail')
@section('main-content')
@php
  $shipping_fee = DB::table('shipping_fees')
      ->where('shipping_id', $order->shipping_id)
      ->first();
@endphp
  <div class="container-fluid px-4">
    <h1 class="mt-4">Chi tiết đơn hàng</h1>
    <ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="{{ route('user.order.index') }}">Trang đơn hàng</a></li>
    <li class="breadcrumb-item active">Chi tiết đơn hàng</li>
    </ol>
    <div class="row">
    <div class="col-md-12 grid-margin stretch-card">
      <div class="card">
      <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
        <h6 class="m-0">Thông tin đơn hàng</h6>
        <a href="{{ route('order.pdf', $order->id) }}" class="btn btn-primary btn-sm float-right"
        data-toggle="tooltip" data-placement="bottom" title=""><i class="fas fa-download"></i> Xuất PDF</a>
      </div>
      </div>
    </div>
    </div>
    <div class="card mb-4">
    <div class="card-body">
      @if($order)
      <div class="table-responsive">
      <table class="table table-striped table-borderless" id="order-dataTable" width="100%" cellspacing="0">
      <thead class="table-success">
      <tr>
        <th>#</th>
        <th>Mã đơn</th>
        <th>Họ tên</th>
        <th>Email</th>
        <th>Số lượng</th>
        <th>Phí vận chuyển</th>
        <th>Tổng cộng</th>
        <th>Trạng thái</th>
        <th>Hành động</th>
      </tr>
      </thead>
      <tbody>
      <tr>
        <td>{{ $order->id }}</td>
        <td>{{ $order->order_number }}</td>
        <td>{{ $order->first_name }} {{ $order->last_name }}</td>
        <td>{{ $order->email }}</td>
        <td>{{ $order->quantity }}</td>
        <td>$ {{ number_format($shipping_fee->price ?? 0, 2) }}</td>
        <td>${{ number_format($order->total_amount, 2) }}</td>
        <td>
        
        @if($order->status == 'new')
      <span class="badge badge-primary">Mới</span>
    @elseif($order->status == 'process')
    <span class="badge badge-warning">Xác nhận đơn hàng</span>
  @elseif($order->status == 'shipping')
  <span class="badge badge-info">Đang giao hàng</span>
@elseif($order->status == 'delivered')
  <span class="badge badge-success">Đã giao</span>
@elseif($order->status == 'cancel_requested')
  <span class="badge badge-secondary">Yêu cầu hủy đơn hàng</span>
@elseif($order->status == 'cancelled')
  <span class="badge badge-danger">Đã hủy</span>
@elseif($order->status == 'failed_delivery')
  <span class="badge badge-danger">Giao hàng thất bại</span>
@elseif($order->status == 'out_of_stock')
  <span class="badge badge-dark">Hết hàng</span>
@elseif($order->status == 'store_payment')
  <span class="badge badge-info">Thanh toán tại cửa hàng</span>
@else
  <span class="badge badge-secondary">{{ $order->status }}</span>
@endif
       
        </td>
        <td class="d-flex">
        <form method="POST" action="">
        @csrf
        @method('delete')
        <button class="btn btn-sm btn-danger">
        <i class="fas fa-trash-alt"></i>
        </button>
        </form>
        </td>
      </tr>
      </tbody>
      </table>
      </div>

      <div class="row mt-4">
      <div class="col-md-6">
      <div class="card">
      <div class="card-header">Thông tin đơn hàng</div>
      <div class="card-body">
        <table class="table table-borderless">
        <tr>
        <td>Mã đơn:</td>
        <td>{{ $order->order_number }}</td>
        </tr>
        <tr>
        <td>Ngày đặt:</td>
        <td>{{ $order->created_at->format('d/m/Y - H:i') }}</td>
        </tr>
        <tr>
        <td>Số lượng:</td>
        <td>{{ $order->quantity }}</td>
        </tr>
        <tr>
        <td>Trạng thái:</td>
        <td>{{ $order->status }}</td>
        </tr>
        <tr>
        <td>Phí vận chuyển:</td>
        <td>$ {{ number_format($shipping_fee->price ?? 0, 2) }}</td>
        </tr>
        <tr>
        <td>Mã giảm giá:</td>
        <td>${{ number_format($order->coupon, 2) }}</td>
        </tr>
        <tr>
        <td>Tổng tiền:</td>
        <td>${{ number_format($order->total_amount, 2) }}</td>
        </tr>
        <tr>
        <td>Phương thức thanh toán:</td>
        <td>
        @if($order->payment_method == 'cod') Thanh toán khi nhận hàng
    @elseif($order->payment_method == 'paypal') PayPal
  @elseif($order->payment_method == 'cardpay') Thẻ tín dụng
@endif
        </td>
        </tr>
        <tr>
        <td>Trạng thái thanh toán:</td>
        <td>
        @if($order->payment_status == 'paid')
      <span class="badge badge-success">Đã thanh toán</span>
    @elseif($order->payment_status == 'unpaid')
    <span class="badge badge-danger">Chưa thanh toán</span>
  @else
  {{ $order->payment_status }}
@endif
        </td>
        </tr>
        </table>
      </div>
      </div>
      </div>

      <div class="col-md-6">
      <div class="card">
      <div class="card-header">Thông tin giao hàng</div>
      <div class="card-body">
        <table class="table table-borderless">
        <tr>
        <td>Họ tên:</td>
        <td>{{ $order->first_name }} {{ $order->last_name }}</td>
        </tr>
        <tr>
        <td>Email:</td>
        <td>{{ $order->email }}</td>
        </tr>
        <tr>
        <td>Điện thoại:</td>
        <td>{{ $order->phone }}</td>
        </tr>
        <tr>
        <td>Địa chỉ:</td>
        <td>{{ $order->address1 }}, {{ $order->address2 }}</td>
        </tr>
        <tr>
        <td>Quốc gia:</td>
        <td>{{ $order->country }}</td>
        </tr>
        <tr>
        <td>Mã bưu điện:</td>
        <td>{{ $order->post_code }}</td>
        </tr>
        </table>
      </div>
      </div>
      </div>
      </div>

    @endif
    </div>
    </div>
  </div>

  <div class="container-fluid">
    <div class="row">
    <div class="col-md-12 grid-margin stretch-card">
      <div class="card">
      <div class="card-body">

        <!-- Logo + Header -->
        <div class="row mt-5 mb-3">
        <div class="col-md-12 text-center">
          @php
        $settings = DB::table('settings')->get();
      @endphp
          @foreach($settings as $data)
        <img src="{{ $data->logo }}" alt="logo" width="150" height="150">
      @endforeach
          <h2 class="display-4 font-weight-bold">GREEN STORE</h2>
          <h4 class="h3 text-muted">CHI TIẾT ĐƠN HÀNG</h4>
        </div>
        </div>

        <!-- Thông tin đơn hàng & khách hàng -->
        <div class="row mb-3">
        <div class="col-md-6">
          <h5 class="mb-3">Thông tin đơn hàng</h5>
          <p><strong>Mã đơn hàng:</strong> {{ $order->order_number }}</p>
          <p><strong>Ngày đặt hàng:</strong> {{ $order->created_at->format('d/m/Y') }}</p>
          <p><strong>Phương thức thanh toán:</strong>
          @if($order->payment_method == 'cod') Thanh toán khi nhận hàng
      @elseif($order->payment_method == 'paypal') PayPal
    @elseif($order->payment_method == 'cardpay') Thẻ tín dụng
    @endif
          </p>
          <p><strong>Trạng thái thanh toán:</strong>
          @if($order->payment_status == 'paid') Đã thanh toán
      @elseif($order->payment_status == 'unpaid') Chưa thanh toán
    @else {{ $order->payment_status }}
    @endif
          </p>
        </div>

        @if($order->user)
      <div class="col-md-6">
        <h5 class="mb-3">Thông tin khách hàng</h5>
        <p><strong>Họ và tên:</strong>
        <span style="text-transform: capitalize;">{{ $order->user->name }}</span>
        </p>
        <p><strong>Email:</strong>
        <span style="text-transform: lowercase;">{{ $order->user->email }}</span>
        </p>
        <p><strong>SĐT:</strong> {{ $order->user->phone ?? 'Chưa có' }}</p>
      </div>
    @endif
        </div>

        <!-- Thông tin giao hàng -->
        <div class="row mb-3">
        <div class="col-md-12">
          <div class="border p-4 rounded shadow-sm badge-light">
          <h5 class="mb-3">Thông tin giao hàng</h5>
          <p><strong>Họ và tên:</strong> {{ $order->first_name }} {{ $order->last_name }}</p>
          <p><strong>SĐT:</strong> {{ $order->phone }}</p>
          <p><strong>Địa chỉ:</strong> {{ $order->address1 }}, {{ $order->address2 }}</p>
          <p><strong>Quốc gia:</strong> {{ $order->country }}</p>
          <p><strong>Mã bưu điện:</strong> {{ $order->post_code }}</p>
          <p><strong>Phí vận chuyển:</strong> $ {{ number_format($shipping_fee->price ?? 0, 2) }}</p>
          </div>
        </div>
        </div>

        <!-- Danh sách sản phẩm -->
        <div class="row mb-3">
        <div class="col-md-12">
          <div class="table-responsive">
          <h5 class="mb-3">Sản phẩm trong đơn</h5>
          <table class="table table-bordered table-striped">
            <thead class="thead-dark">
            <tr>
              <th>Tên sản phẩm</th>
              <th>Số lượng</th>
              <th>Giá</th>
              <th>Tổng</th>
            </tr>
            </thead>
            <tbody>
            @foreach($order->carts as $cart)
        <tr>
          <td>{{ $cart->product->title }}</td>
          <td>{{ $cart->quantity }}</td>
          <td>${{ number_format($cart->price, 0, ',', '.') }}</td>
          <td>${{ number_format($cart->amount, 0, ',', '.') }}</td>
        </tr>
      @endforeach
            </tbody>
          </table>
          </div>
        </div>
        </div>

        <!-- Tổng hóa đơn -->
        <div class="row mb-4">
        <div class="col-md-12 d-flex justify-content-between align-items-center">
          <div>
          <h4 class="font-weight-bold">Tổng hóa đơn: ${{ number_format($order->total_amount, 0, ',', '.') }}</h4>
          <em style="color: #555;">(Tổng hóa đơn bao gồm phí vận chuyển)</em>
          </div>
        </div>
        </div>

        <!-- Footer -->
        <div class="row pt-4 border-top badge-light">
        <div class="col-md-12 text-center">
          <h5>Green Store cam kết chịu trách nhiệm từ việc lập đơn, đóng gói đến vận chuyển hàng hóa.</h5>
          <p class="text-muted">
          Liên hệ qua số điện thoại: <strong>0788781116</strong> hoặc địa chỉ:
          <strong>12 Lương Định Của, TP. Cần Thơ</strong>
          </p>
          <small class="text-muted">&copy; {{ date('Y') }} Green Store. All Rights Reserved.</small>
        </div>
        </div>

      </div>
      </div>
    </div>
    </div>
  </div>

@endsection
@push('styles')
  <style>
    .order-info,
    .shipping-info {
    background: #ECECEC;
    padding: 20px;
    }

    .order-info h4,
    .shipping-info h4 {
    text-decoration: underline;
    }
  </style>
@endpush