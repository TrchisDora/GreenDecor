@extends('backend.layouts.master')
@section('main-content')
    <div class="container-fluid">
        <div class="row mb-3">
            <div class="col-md-12">
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                        <h6 class="m-0">Chỉnh Sửa Đơn Hàng</h6>
                        <a href="{{ route('order.index') }}" class="btn btn-danger btn-sm float-right" data-toggle="tooltip"
                            data-placement="bottom" title="Quay lại danh sách đơn hàng">
                            <i class="fas fa-back"></i> Quay lại
                        </a>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('order.update', $order->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                          <!-- Trạng thái đơn hàng -->
<div class="form-group mb-3">
    <label for="status">Trạng Thái Đơn Hàng:</label>
    <select name="status" class="form-control" {{ in_array($order->status, ['delivered', 'store_payment', 'cancelled', 'failed_delivery', 'out_of_stock']) ? 'disabled' : '' }}>
        @if($order->status == 'new')
            <option value="process" {{ old('status', $order->status) == 'process' ? 'selected' : '' }}>Đã xử lý đơn hàng</option>
            <option value="out_of_stock" {{ old('status', $order->status) == 'out_of_stock' ? 'selected' : '' }}>Hết hàng</option>
        @elseif($order->status == 'cancel_requested')
            <option value="cancel_requested" {{ old('status', $order->status) == 'cancel_requested' ? 'selected' : '' }}>Xác nhận yêu cầu hủy đơn</option>
        @elseif($order->status == 'process')
            <option value="shipping" {{ old('status', $order->status) == 'shipping' ? 'selected' : '' }}>Đang giao hàng</option>
        @elseif($order->status == 'shipping')
            <option value="delivered" {{ old('status', $order->status) == 'delivered' ? 'selected' : '' }}>Giao hàng thành công</option>
            <option value="failed_delivery" {{ old('status', $order->status) == 'failed_delivery' ? 'selected' : '' }}>Giao hàng thất bại</option>
        @endif
    </select>
    @error('status')
        <span class="text-danger small">{{ $message }}</span>
    @enderror
</div>

<!-- Cập nhật trạng thái cho payment_status khi giao hàng thành công hoặc thanh toán tại cửa hàng -->
@if(in_array($order->status, ['delivered', 'store_payment']))
    <input type="hidden" name="payment_status" value="paid">
@endif

<div class="form-group mb-3 d-flex justify-content-center">
    <button type="submit" class="btn btn-success">Cập nhật trạng thái</button>
</div>

                        </form>
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