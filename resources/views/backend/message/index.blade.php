@extends('backend.layouts.master')

@section('main-content')'

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
        <h6 class="m-0">Tin nhắn</h6>
      </div>
      </div>
    </div>
    </div>

    <div class="row">
    <div class="col-md-12">
      <div class="card shadow-sm">
      <div class="card-body-table">
        <h5 class="card-header">Messages</h5>
        <div class="card-body">
        <!-- Kiểm tra nếu có message -->
        @if(count($messages) > 0)
      <!-- Bảng danh sách Messages -->
      <div class="table-responsive">
        <table class="table table-striped table-borderless" id="message-dataTable" width="100%" cellspacing="0">
        <thead class="table-success">
        <tr>
        <th scope="col">ID</th>
        <th scope="col">Name</th>
        <th scope="col">Subject</th>
        <th scope="col">Date</th>
        <th scope="col">Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($messages as $message)
      <tr class="@if($message->read_at) border-left-success @else bg-light border-left-warning @endif">
      <td scope="row">{{$loop->index + 1}}</td>
      <td>{{$message->name}} {{$message->read_at}}</td>
      <td>{{$message->subject}}</td>
      <td>{{$message->created_at->format('F d, Y h:i A')}}</td>
      <td>
        <!-- Xem chi tiết -->
        <a href="{{ route('message.show', $message->id) }}" class="btn btn-primary btn-sm float-left mr-1"
        style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" title="View"
        data-placement="bottom">
        <i class="fas fa-eye"></i>
        </a>

        <!-- Xóa message -->
        <form method="POST" action="{{ route('message.destroy', [$message->id]) }}">
        @csrf
        @method('delete')
        <button class="btn btn-danger btn-sm dltBtn" data-id="{{$message->id}}"
        style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" title="Delete"
        data-placement="bottom">
        <i class="fas fa-trash-alt"></i>
        </button>
        </form>
      </td>
      </tr>
    @endforeach
        </tbody>
        </table>

        <!-- Phân trang -->
        <nav class="blog-pagination justify-content-center d-flex">
        {{$messages->links()}}
        </nav>
      </div>
    @else
    <h2 class="text-center">Không có tin nhắn !</h2>
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
  <!-- Các plugin cần thiết -->
  <script src="{{ asset('backend/vendor/datatables/jquery.dataTables.min.js') }}"></script>
  <script src="{{ asset('backend/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

  <!-- Tùy chỉnh DataTables -->
  <script src="{{ asset('backend/js/demo/datatables-demo.js') }}"></script>

  <script>
    // Khởi tạo DataTables
    $('#message-dataTable').DataTable({
    "columnDefs": [
      {
      "orderable": false,
      "targets": [4] // Cấm sắp xếp cho cột "Action"
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
    $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
    });
  </script>
@endpush