@extends('backend.layouts.master')
@section('main-content')
<div class="container-fluid">
     <div class="row  mb-3">
         <div class="col-md-12">
            @include('backend.layouts.notification')
         </div>
     </div>
    <div class="row">
      <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
          <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
            <h6 class="m-0">Danh sách Banner</h6>
            <a href="{{route('banner.create')}}" class="btn btn-primary btn-sm float-right" data-toggle="tooltip"
              data-placement="bottom" title="Thêm Banner"><i class="fas fa-plus"></i> Thêm Banner</a>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="card shadow-sm">
          <div class="card-body-table">
            <div class="table-responsive">
              @if(count($banners) > 0)
                <table class="table table-striped table-borderless" id="banner-dataTable" width="100%" cellspacing="0">
                  <thead class="table-success">
                    <tr>
                      <th>ID</th>
                      <th>Tiêu đề</th>
                      <th>Đường dẫn</th>
                      <th>Hình ảnh</th>
                      <th>Trạng thái</th>
                      <th>Hành động</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($banners as $banner)
                      <tr>
                        <td>{{$banner->id}}</td>
                        <td>{{$banner->title}}</td>
                        <td>{{$banner->slug}}</td>
                        <td>
                          @if($banner->photo)
                            <img src="{{$banner->photo}}" class="img-fluid zoom" style="max-width:80px"
                              alt="{{$banner->photo}}">
                          @else
                            <img src="{{asset('backend/img/thumbnail-default.jpg')}}" class="img-fluid zoom"
                              style="max-width:100%" alt="avatar.png">
                          @endif
                        </td>
                        <td>
                          @if($banner->status == 'active')
                            <span class="badge badge-success">Hoạt động</span>
                          @else
                            <span class="badge badge-warning">Không hoạt động</span>
                          @endif
                        </td>
                        <td>
                          <a href="{{route('banner.edit', $banner->id)}}" class="btn btn-primary btn-sm float-left mr-1"
                            style="height:30px; width:30px" data-toggle="tooltip" title="Chỉnh sửa"
                            data-placement="bottom"><i class="fas fa-edit"></i></a>
                          <form method="POST" action="{{route('banner.destroy', [$banner->id])}}">
                            @csrf
                            @method('delete')
                            <button class="btn btn-danger btn-sm dltBtn" data-id={{$banner->id}}
                              style="height:30px; width:30px" data-toggle="tooltip" data-placement="bottom"
                              title="Xóa"><i class="fas fa-trash-alt"></i></button>
                          </form>
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              @else
                <h6 class="text-center">Không có banner nào! Vui lòng thêm banner mới.</h6>
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
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="{{ asset('backend/vendor/datatables/jquery.dataTables.min.js') }}"></script>
  <script src="{{ asset('backend/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
  <script>
      $(document).ready(function() {
          $('#banner-dataTable').DataTable({
              "columnDefs": [
                  {
                      "orderable": false,
                      "targets": [5] // Đặt cột Hành động không thể sắp xếp
                  }
              ]
          });

          // Sweet alert cho xác nhận xóa (Fix lỗi không hoạt động ở trang 2 trở đi)
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
