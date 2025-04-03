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
                    <h6 class="m-0">Coupon List</h6>
                    <a href="{{route('coupon.create')}}" class="btn btn-primary btn-sm float-right" data-toggle="tooltip" data-placement="bottom" title="Add Coupon"><i class="fas fa-plus"></i> Add Coupon</a>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-body-table">
                    <div class="table-responsive">
                        @if(count($coupons)>0)
                            <table class="table table-striped table-borderless" id="coupon-dataTable" width="100%" cellspacing="0">
                                <thead class="table-success">
                                    <tr>
                                        <th>#</th>
                                        <th>Coupon Code</th>
                                        <th>Type</th>
                                        <th>Value</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($coupons as $coupon)
                                        <tr>
                                            <td>{{$coupon->id}}</td>
                                            <td>{{$coupon->code}}</td>
                                            <td>
                                                @if($coupon->type=='fixed')
                                                    <span class="badge badge-primary">{{$coupon->type}}</span>
                                                @else
                                                    <span class="badge badge-warning">{{$coupon->type}}</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($coupon->type=='fixed')
                                                    ${{number_format($coupon->value,2)}}
                                                @else
                                                    {{$coupon->value}}%
                                                @endif
                                            </td>
                                            <td>
                                                @if($coupon->status=='active')
                                                    <span class="badge badge-success">{{$coupon->status}}</span>
                                                @else
                                                    <span class="badge badge-warning">{{$coupon->status}}</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{route('coupon.edit', $coupon->id)}}" class="btn btn-primary btn-sm float-left mr-1" style="height:30px; width:30px" data-toggle="tooltip" title="Edit" data-placement="bottom"><i class="fas fa-edit"></i></a>
                                                <form method="POST" action="{{route('coupon.destroy', [$coupon->id])}}">
                                                    @csrf
                                                    @method('delete')
                                                    <button class="btn btn-danger btn-sm dltBtn" data-id={{$coupon->id}} style="height:30px; width:30px" data-toggle="tooltip" data-placement="bottom" title="Delete"><i class="fas fa-trash-alt"></i></button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <span style="float:right">{{$coupons->links()}}</span>
                        @else
                            <h6 class="text-center">No Coupon found! Please create coupon</h6>
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
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
@endpush

@push('scripts')
  <script src="{{ asset('backend/vendor/datatables/jquery.dataTables.min.js') }}"></script>
  <script src="{{ asset('backend/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

  <script>
      $(document).ready(function() {
          $('#coupon-dataTable').DataTable({
              "columnDefs": [
                  {
                      "orderable": false,
                      "targets": [4] // Cột hành động không thể sắp xếp
                  }
              ]
          });

          // Sweet alert xác nhận xóa
          $(document).on('click', '.dltBtn', function(e) {
              var form = $(this).closest('form');
              var dataID = $(this).data('id');
              e.preventDefault();
              swal({
                  title: "Bạn có chắc chắn?",
                  text: "Sau khi xóa, bạn sẽ không thể khôi phục dữ liệu này!",
                  icon: "warning",
                  buttons: ["Hủy", "Xóa ngay"],
                  dangerMode: true,
              })
              .then((willDelete) => {
                  if (willDelete) {
                      form.submit();
                  } else {
                      swal("Dữ liệu của bạn vẫn an toàn!");
                  }
              });
          });
      });
  </script>
@endpush