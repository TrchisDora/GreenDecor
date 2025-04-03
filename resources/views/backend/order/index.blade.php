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
                    <a href="{{route('order.create')}}" class="btn btn-primary btn-sm float-right" data-toggle="tooltip"
                    data-placement="bottom" title="Thêm Đơn hàng"><i class="fas fa-plus"></i> Thêm Đơn hàng</a>
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
                                            $shipping_charge = DB::table('shippings')->where('id', $order->shipping_id)->pluck('price');
                                        @endphp
                                        <tr>
                                            <td>{{$order->id}}</td>
                                            <td>{{$order->order_number}}</td>
                                            <td>{{$order->first_name}} {{$order->last_name}}</td>
                                            <td>{{$order->email}}</td>
                                            <td>{{$order->quantity}}</td>
                                            <td>
                                                @foreach($shipping_charge as $data) 
                                                    $ {{number_format($data, 2)}} 
                                                @endforeach
                                            </td>
                                            <td>${{number_format($order->total_amount, 2)}}</td>
                                            <td>
                                                @if($order->status == 'new')
                                                    <span class="badge badge-primary">Mới</span>
                                                @elseif($order->status == 'process')
                                                    <span class="badge badge-warning">Đang xử lý</span>
                                                @elseif($order->status == 'delivered')
                                                    <span class="badge badge-success">Đã giao</span>
                                                @else
                                                    <span class="badge badge-danger">{{$order->status}}</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{route('order.show', $order->id)}}" class="btn btn-warning btn-sm float-left mr-1" style="height:30px; width:30px data-toggle="tooltip" title="Xem" data-placement="bottom"><i class="fas fa-eye"></i></a>
                                                <a href="{{route('order.edit', $order->id)}}" class="btn btn-primary btn-sm float-left mr-1" style="height:30px; width:30px data-toggle="tooltip" title="Chỉnh sửa" data-placement="bottom"><i class="fas fa-edit"></i></a>
                                                <form method="POST" action="{{route('order.destroy', [$order->id])}}">
                                                    @csrf 
                                                    @method('delete')
                                                    <button class="btn btn-danger btn-sm dltBtn" data-id={{$order->id}} style="height:30px; width:30px data-toggle="tooltip" data-placement="bottom" title="Xóa"><i class="fas fa-trash-alt"></i></button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <span style="float:right">{{$orders->links()}}</span>
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
  <link href="{{asset('backend/vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
  <style>
      div.dataTables_wrapper div.dataTables_paginate{
          display: none;
      }
  </style>
@endpush

@push('scripts')

  <!-- Page level plugins -->
  <script src="{{asset('backend/vendor/datatables/jquery.dataTables.min.js')}}"></script>
  <script src="{{asset('backend/vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="{{asset('backend/js/demo/datatables-demo.js')}}"></script>
  <script>
      
      $('#order-dataTable').DataTable( {
            "columnDefs":[
                {
                    "orderable":false,
                    "targets":[8]
                }
            ]
        } );

        // Sweet alert

        function deleteData(id){
            
        }
  </script>
  <script>
      $(document).ready(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
          $('.dltBtn').click(function(e){
            var form=$(this).closest('form');
              var dataID=$(this).data('id');
              // alert(dataID);
              e.preventDefault();
              swal({
                    title: "Are you sure?",
                    text: "Once deleted, you will not be able to recover this data!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                       form.submit();
                    } else {
                        swal("Your data is safe!");
                    }
                });
          })
      })
  </script>
@endpush