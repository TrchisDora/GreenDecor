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
                        <h6 class="m-0">Danh sách Đánh Giá</h6>
                        
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
                            @if(count($reviews) > 0)
                                <table class="table table-striped table-borderless" id="review-dataTable" width="100%"
                                    cellspacing="0">
                                    <thead class="table-success">
                                        <tr>
                                            <th>#</th>
                                            <th>Người Đánh Giá</th>
                                            <th>Sản Phẩm</th>
                                            <th>Nội Dung</th>
                                            <th>Đánh Giá</th>
                                            <th>Ngày</th>
                                            <th>Trạng Thái</th>
                                            <th>Hành Động</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($reviews as $review)
                                            <tr>
                                                <td>{{$review->id}}</td>
                                                <td>{{$review->user_info['name']}}</td>
                                                <td>{{ $review->product ? $review->product->title : 'Không tìm thấy' }}</td>
                                                <td>{{$review->review}}</td>
                                                <td>
                                                    <ul class="rating-stars">

                                                        <i class="fa fa-star"></i> {{ $review->rate }}

                                                    </ul>
                                                </td>

                                                <td>{{$review->created_at->format('d-m-Y H:i')}}</td>
                                                <td>
                                                    @if($review->status == 'active')
                                                        <span class="badge badge-success">Hoạt động</span>
                                                    @else
                                                        <span class="badge badge-warning">Không hoạt động</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{route('review.edit', $review->id)}}" class="btn btn-primary btn-sm"
                                                        data-toggle="tooltip" title="Chỉnh sửa">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form method="POST" action="{{route('review.destroy', [$review->id])}}"
                                                        class="d-inline delete-form">
                                                        @csrf
                                                        @method('delete')
                                                        <button class="btn btn-danger btn-sm dltBtn" data-id="{{$review->id}}"
                                                            title="Xóa">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>
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

    <!-- Page level plugins -->
    <script src="{{asset('backend/vendor/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('backend/vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="{{asset('backend/js/demo/datatables-demo.js')}}"></script>
    <script>

        $('#review-dataTable').DataTable({
            "columnDefs": [
                {
                    "orderable": false,
                    "targets": [5, 6]
                }
            ]
        });

        // Sweet alert xác nhận xóa
        $(document).on('click', '.dltBtn', function (e) {
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
    </script>

@endpush