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
                            <select name="status" class="form-control">
                                <option value="new" {{ ($order->status == 'delivered' || $order->status == 'process' || $order->status == 'cancel') ? 'disabled' : '' }}  {{ ($order->status == 'new') ? 'selected' : '' }}>Mới</option>
                                <option value="process" {{ ($order->status == 'delivered' || $order->status == 'cancel') ? 'disabled' : '' }}  {{ ($order->status == 'process') ? 'selected' : '' }}>Đang xử lý</option>
                                <option value="delivered" {{ ($order->status == 'cancel') ? 'disabled' : '' }}  {{ ($order->status == 'delivered') ? 'selected' : '' }}>Đã giao hàng</option>
                                <option value="cancel" {{ ($order->status == 'delivered') ? 'disabled' : '' }}  {{ ($order->status == 'cancel') ? 'selected' : '' }}>Hủy</option>
                            </select>
                            @error('status')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Nút cập nhật -->
                        <div class="form-group mb-3 d-flex justify-content-center">
                            <button type="submit" class="btn btn-success">Cập nhật</button>
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
    .order-info,.shipping-info{
        background:#ECECEC;
        padding:20px;
    }
    .order-info h4,.shipping-info h4{
        text-decoration: underline;
    }

</style>
@endpush
