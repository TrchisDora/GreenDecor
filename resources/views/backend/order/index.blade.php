@extends('backend.layouts.master')

@section('main-content')
<div class="container-fluid">
    <div class="row mb-3">
        <div class="col-md-12">
            @include('backend.layouts.notification')
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                    <h6 class="m-0">Danh sách Đơn hàng</h6>
                    <a href="#" class="btn btn btn-sm float-right" data-toggle="tooltip"data-placement="bottom" title=""><i class="fas fa-star" style="color:#55AC49;"></i></a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-body-table">
                    <div class="table-responsive">
                        @if(count($orders) > 0)
                            <table class="table table-striped table-borderless" id="order-dataTable" width="100%" cellspacing="0">
                                <thead class="table-success">
                                    <tr>
                                        <th>#</th>
                                        <th>Mã Đơn hàng</th>
                                        <th>Tên</th>
                                        <th>Email</th>
                                        <th>Số lượng</th>
                                        <th>Phí vận chuyển</th>
                                        <th>Tổng cộng</th>
                                        <th>Trạng thái</th>
                                        <th>Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($orders as $order)
                                        @php
                                            $shipping_charge = DB::table('shipping_fees')->where('id', $order->shipping_id)->value('price');
                                        @endphp
                                        <tr id="order-{{ $order->id }}">
                                            <td>{{ $order->id }}</td>
                                            <td>{{ $order->order_number }}</td>
                                            <td>{{ $order->first_name }} {{ $order->last_name }}</td>
                                            <td>{{ $order->email }}</td>
                                            <td>{{ $order->quantity }}</td>
                                            <td>$ {{ number_format($shipping_charge, 2) }}</td>
                                            <td>$ {{ number_format($order->total_amount, 2) }}</td>
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
                                                @else
                                                    <span class="badge badge-secondary">{{ $order->status }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('order.show', $order->id) }}" class="btn btn-warning btn-sm" data-toggle="tooltip" title="Xem"><i class="fas fa-eye"></i></a>
                                                <a href="{{ route('order.edit', $order->id) }}" class="btn btn-primary btn-sm" data-toggle="tooltip" title="Chỉnh sửa"><i class="fas fa-edit"></i></a>
                                                <button class="btn btn-danger btn-sm delete-order" data-id="{{ $order->id }}" data-toggle="tooltip" title="Xóa"><i class="fas fa-trash-alt"></i></button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <h6 class="text-center">Không có đơn hàng nào! Vui lòng đặt hàng sản phẩm.</h6>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link href="{{ asset('backend/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.css">
@endpush

@push('scripts')
<script src="{{ asset('backend/vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('backend/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<script>
    $(document).ready(function () {
        $('#order-dataTable').DataTable({
            "columnDefs": [{
                "orderable": false,
                "targets": [8]
            }]
        });

        $('.delete-order').click(function () {
            var order_id = $(this).data('id');
            var row = $("#order-" + order_id);
            
            swal({
                title: "Bạn có chắc chắn?",
                text: "Đơn này sẽ yêu cầu người bán hủy, hãy chờ đợi nhé!",
                icon: "warning",
                buttons: ["Quay lại", "Hủy ngay"],
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        url: '{{ route("order.destroy", ":id") }}'.replace(':id', order_id),
                        type: 'POST',
                        data: {
                            _method: 'DELETE',
                            _token: '{{ csrf_token() }}'
                        },
                        success: function (response) {
                            if (response.status == 'success') {
                                row.fadeOut(500, function () {
                                    row.remove();
                                });
                                swal("Xóa thành công!", {
                                    icon: "success",
                                });
                            } else {
                                swal("Lỗi khi xóa!", {
                                    icon: "error",
                                });
                            }
                        },
                        error: function () {
                            swal("Đã xảy ra lỗi, vui lòng thử lại!", {
                                icon: "error",
                            });
                        }
                    });
                }
            });
        });
    });
</script>
@endpush
