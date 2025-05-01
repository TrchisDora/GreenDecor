@extends('user.layouts.master')
@section('title','E-SHOP || Comment Page')
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
                    <h6 class="m-0">Danh Sách Bình Luận</h6>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-body-table">
                    <div class="table-responsive">
                        @if(count($comments) > 0)
                            <table class="table table-striped table-borderless" id="comment-dataTable" width="100%" cellspacing="0">
                                <thead class="table-success">
                                    <tr>
                                        <th>#</th>
                                        <th>Người bình luận</th>
                                        <th>Tiêu đề bài viết</th>
                                        <th>Thông điệp</th>
                                        <th>Ngày đăng</th>
                                        <th>Trạng thái</th>
                                        <th>Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($comments as $comment)
                                        <tr class="@if($comment->status == 'active') border-left-success @else bg-light border-left-warning @endif">
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{$comment->user_info['name']}}</td>
                                            <td>{{$comment->post->title}}</td>
                                            <td>{{$comment->comment}}</td>
                                            <td>{{$comment->created_at->format('d/m/Y H:i A')}}</td>
                                            <td>
                                                @if($comment->status == 'active')
                                                    <span class="badge badge-success">{{$comment->status}}</span>
                                                @else
                                                    <span class="badge badge-warning">{{$comment->status}}</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{route('user.post-comment.edit',$comment->id)}}" class="btn btn-primary btn-sm"
                                                    style="height:30px; width:30px" data-toggle="tooltip" title="Sửa"
                                                    data-placement="bottom"><i class="fas fa-edit"></i></a>
                                                <form method="POST" action="{{route('user.post-comment.delete',[$comment->id])}}" class="d-inline">
                                                    @csrf
                                                    @method('delete')
                                                    <button class="btn btn-danger btn-sm dltBtn"
                                                        data-id="{{$comment->id}}" style="height:30px; width:30px"
                                                        data-toggle="tooltip" data-placement="bottom"
                                                        title="Xóa"><i class="fas fa-trash-alt"></i></button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <h6 class="text-center">Không có bình luận nào!</h6>
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
        var table = $('#comment-dataTable').DataTable({
            "columnDefs": [
                {
                    "orderable": false,
                    "targets": [6]
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
