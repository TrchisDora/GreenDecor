@extends('user.layouts.master')

@section('main-content')
<div class="container-fluid">
    <div class="row mb-3">
        <div class="col-md-12">
            @include('user.layouts.notification')
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                    <h6 class="m-0">Danh sách Đánh giá sản phẩm</h6>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-body-table">
                    <div class="table-responsive">
                        @if(count($reviews) > 0)
                            <table class="table table-striped table-borderless" id="review-dataTable" width="100%" cellspacing="0">
                                <thead class="table-success">
                                    <tr>
                                        <th>#</th>
                                        <th>Người đánh giá</th>
                                        <th>Sản phẩm</th>
                                        <th>Đánh giá</th>
                                        <th>Sao</th>
                                        <th>Thời gian</th>
                                        <th>Trạng thái</th>
                                        <th>Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($reviews as $review)
                                        <tr class="@if($review->status == 'active') border-left-success @else bg-light border-left-warning @endif">
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{$review->user_info['name']}}</td>
                                            <td>{{$review->product->title}}</td>
                                            <td>{{$review->review}}</td>
                                            <td>
                                                <ul style="list-style:none" class="d-flex m-0 p-0">
                                                    @for($i=1; $i<=5; $i++)
                                                        <li style="color:#F7941D;">
                                                            @if($review->rate >= $i)
                                                                <i class="fa fa-star"></i>
                                                            @else
                                                                <i class="far fa-star"></i>
                                                            @endif
                                                        </li>
                                                    @endfor
                                                </ul>
                                            </td>
                                            <td>{{$review->created_at->format('d/m/Y H:i A')}}</td>
                                            <td>
                                                @if($review->status == 'active')
                                                    <span class="badge badge-success">{{$review->status}}</span>
                                                @else
                                                    <span class="badge badge-warning">{{$review->status}}</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{route('user.productreview.edit',$review->id)}}" class="btn btn-primary btn-sm"
                                                    style="height:30px; width:30px" data-toggle="tooltip" title="Sửa"
                                                    data-placement="bottom"><i class="fas fa-edit"></i></a>
                                                <form method="POST" action="{{route('user.productreview.delete',[$review->id])}}" class="d-inline">
                                                    @csrf
                                                    @method('delete')
                                                    <button class="btn btn-danger btn-sm dltBtn"
                                                        data-id="{{$review->id}}" style="height:30px; width:30px"
                                                        data-toggle="tooltip" data-placement="bottom"
                                                        title="Xóa"><i class="fas fa-trash-alt"></i></button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <h6 class="text-center">Không có đánh giá nào!</h6>
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
@endpush

@push('scripts')
  <script src="{{asset('backend/vendor/datatables/jquery.dataTables.min.js')}}"></script>
  <script src="{{asset('backend/vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

  <script>
    $(document).ready(function() {
        var table = $('#review-dataTable').DataTable({
            "columnDefs": [
                {
                    "orderable": false,
                    "targets": [7]
                }
            ]
        });

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
