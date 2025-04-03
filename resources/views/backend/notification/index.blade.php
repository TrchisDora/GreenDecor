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
                    <h6 class="m-0">Danh sách Thông báo</h6>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-body-table">
                    <div class="table-responsive">
                        @if(count(Auth::user()->Notifications) > 0)
                            <table class="table table-striped table-borderless" id="notification-dataTable" width="100%" cellspacing="0">
                                <thead class="table-success">
                                    <tr>
                                        <th>#</th>
                                        <th>Thời gian</th>
                                        <th>Tiêu đề</th>
                                        <th>Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach(Auth::user()->Notifications as $notification)
                                        <tr class="@if($notification->unread()) bg-light border-left-light @else border-left-success @endif">
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{$notification->created_at->format('d/m/Y H:i A')}}</td>
                                            <td>{{$notification->data['title']}}</td>
                                            <td>
                                                <a href="{{route('admin.notification', $notification->id)}}" class="btn btn-primary btn-sm"
                                                    style="height:30px; width:30px" data-toggle="tooltip" title="Xem"
                                                    data-placement="bottom"><i class="fas fa-eye"></i></a>
                                                <form method="POST" action="{{ route('notification.delete', $notification->id) }}" class="d-inline">
                                                    @csrf
                                                    @method('delete')
                                                    <button class="btn btn-danger btn-sm dltBtn"
                                                        data-id={{$notification->id}} style="height:30px; width:30px"
                                                        data-toggle="tooltip" data-placement="bottom"
                                                        title="Xóa"><i class="fas fa-trash-alt"></i></button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <h6 class="text-center">Không có thông báo nào!</h6>
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
        var table = $('#notification-dataTable').DataTable({
            "columnDefs": [
                {
                    "orderable": false,
                    "targets": [3]
                }
            ]
        });

        // Sweet alert cho xác nhận xóa (Fix lỗi không hoạt động ở trang 2 trở đi)
        $(document).on('click', '.dltBtn', function(e) {
            var form = $(this).closest('form');
            var dataID = $(this).data('id');
            e.preventDefault();

            // Lấy trang hiện tại từ URL
            var currentPage = getParameterByName('page') || 1; 

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
                    // Giữ lại trang hiện tại sau khi xóa
                    setTimeout(function() {
                        window.location.search = window.location.search.replace(/page=\d+/, 'page=' + currentPage);
                    }, 1000);  // Thời gian đợi để form submit và load lại trang
                } else {
                    swal("Dữ liệu của bạn vẫn an toàn!");
                }
            });
        });

        // Hàm lấy tham số từ URL
        function getParameterByName(name) {
            name = name.replace(/[[]/, '\\[').replace(/[\]]/, '\\]');
            var regex = new RegExp('[?&]' + name + '=([^&#]*)'),
                results = regex.exec(location.search);
            return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
        }
    });
  </script>
@endpush
