@extends('backend.layouts.master')
@section('title','Ecommerce Laravel || Comment Page')
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
                    <h6 class="m-0">Danh sách Bình luận</h6>
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
                            <table class="table table-striped table-borderless" id="order-dataTable" width="100%" cellspacing="0">
                                <thead class="table-success">
                                    <tr>
                                        <th>#</th>
                                        <th>Tác giả</th>
                                        <th>Tiêu đề bài viết</th>
                                        <th>Thông điệp</th>
                                        <th>Ngày</th>
                                        <th>Trạng thái</th>
                                        <th>Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($comments as $comment)
                                        <tr>
                                            <td>{{$comment->id}}</td>
                                            <td>{{$comment->user_info['name']}}</td>
                                            <td>{{$comment->post->title}}</td>
                                            <td>{{$comment->comment}}</td>
                                            <td>{{$comment->created_at->format('M d D, Y g: i a')}}</td>
                                            <td>
                                                @if($comment->status == 'active')
                                                    <span class="badge badge-success">Hoạt động</span>
                                                @else
                                                    <span class="badge badge-warning">Không hoạt động</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{route('comment.edit',$comment->id)}}" class="btn btn-primary btn-sm float-left mr-1" style="height:30px; width:30px" data-toggle="tooltip" title="Chỉnh sửa" data-placement="bottom"><i class="fas fa-edit"></i></a>
                                                <form method="POST" action="{{route('comment.destroy',[$comment->id])}}">
                                                    @csrf
                                                    @method('delete')
                                                    <button class="btn btn-danger btn-sm dltBtn" data-id={{$comment->id}} style="height:30px; width:30px" data-toggle="tooltip" data-placement="bottom" title="Xóa"><i class="fas fa-trash-alt"></i></button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <span style="float:right">{{$comments->links()}}</span>
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
                    "targets":[5,6]
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
