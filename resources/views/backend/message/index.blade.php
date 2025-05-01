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
                    <h6 class="m-0">Danh sách Tin nhắn</h6>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-body-table">
                    <div class="table-responsive">
                        @if(count($messages) > 0)
                            <table class="table table-striped table-borderless" id="message-dataTable" width="100%" cellspacing="0">
                                <thead class="table-success">
                                    <tr>
                                        <th>#</th>
                                        <th>Thời gian</th>
                                        <th>Người gửi</th>
                                        <th>Tiêu đề</th>
                                        <th>Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($messages as $message)
                                        <tr class="@if(!$message->read_at) bg-light border-left-warning @else border-left-success @endif">
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $message->created_at->format('d/m/Y H:i A') }}</td>
                                            <td>{{ $message->name }}</td>
                                            <td>{{ $message->subject }}</td>
                                            <td>
                                                <a href="{{ route('message.show', $message->id) }}" class="btn btn-primary btn-sm"
                                                    style="height:30px; width:30px" data-toggle="tooltip" title="Xem"
                                                    data-placement="bottom"><i class="fas fa-eye"></i></a>
                                                <form method="POST" action="{{ route('message.destroy', $message->id) }}" class="d-inline">
                                                    @csrf
                                                    @method('delete')
                                                    <button class="btn btn-danger btn-sm dltBtn"
                                                        data-id="{{ $message->id }}" style="height:30px; width:30px"
                                                        data-toggle="tooltip" title="Xóa"
                                                        data-placement="bottom"><i class="fas fa-trash-alt"></i></button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <div class="mt-3">
                                {{ $messages->links() }}
                            </div>
                        @else
                            <h6 class="text-center">Không có tin nhắn nào!</h6>
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
    $(document).ready(function () {
        $('#message-dataTable').DataTable({
            "columnDefs": [
                {
                    "orderable": false,
                    "targets": [4]
                }
            ]
        });

        $(document).on('click', '.dltBtn', function (e) {
            e.preventDefault();
            var form = $(this).closest('form');
            var dataID = $(this).data('id');

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
