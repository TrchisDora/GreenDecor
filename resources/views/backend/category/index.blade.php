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
                <div class="card-header d-flex justify-content-between align-items-center bg-success text-white">
                    <h6 class="m-0 font-weight-bold">Danh sách danh mục</h6>
                    <a href="{{ route('category.create') }}" class="btn btn-light btn-sm" title="Thêm danh mục">
                        <i class="fas fa-plus"></i> Thêm danh mục
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        @if(count($categories) > 0)
                            <table class="table table-striped table-hover" id="categoryTable">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>#</th>
                                        <th>Tiêu đề</th>
                                        <th>Slug</th>
                                        <th>Là danh mục cha</th>
                                        <th>Danh mục cha</th>
                                        <th>Hình ảnh</th>
                                        <th>Trạng thái</th>
                                        <th>Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($categories as $category)
                                        <tr>
                                            <td>{{ $category->id }}</td>
                                            <td>{{ $category->title }}</td>
                                            <td>{{ $category->slug }}</td>
                                            <td>{!! $category->is_parent ? '<span class="badge badge-success">Có</span>' : '<span class="badge badge-danger">Không</span>' !!}</td>
                                            <td>{{ $category->parent_info->title ?? '-' }}</td>
                                            <td>
                                                <img src="{{ $category->photo ?? asset('backend/img/thumbnail-default.jpg') }}" class="img-thumbnail" style="max-width: 60px;">
                                            </td>
                                            <td>
                                                <span class="badge badge-{{ $category->status == 'active' ? 'success' : 'warning' }}">{{ ucfirst($category->status) }}</span>
                                            </td>
                                            <td class="d-flex">
                                                <a href="{{ route('category.edit', $category->id) }}" class="btn btn-sm btn-info mx-1" title="Chỉnh sửa">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form method="POST" action="{{ route('category.destroy', $category->id) }}">
                                                    @csrf
                                                    @method('delete')
                                                    <button class="btn btn-sm btn-danger deleteBtn" data-id="{{ $category->id }}" title="Xóa">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="mt-3 float-right">{{ $categories->links() }}</div>
                        @else
                            <h6 class="text-center text-muted">Không có danh mục nào. Vui lòng tạo danh mục.</h6>
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
<style>
    .table td, .table th { vertical-align: middle !important; text-align: center; }
    .deleteBtn:hover { background-color: #dc3545; color: white; }
    .dataTables_wrapper .dataTables_filter input, .dataTables_wrapper .dataTables_length select {
        border: 1px solid #ced4da;
        border-radius: 4px;
        padding: 4px;
    }
</style>
@endpush

@push('scripts')
<script src="{{ asset('backend/vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('backend/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<script>
    $(document).ready(function () {
        $('.deleteBtn').click(function (e) {
            e.preventDefault();
            let form = $(this).closest('form');
            swal({
                title: "Bạn có chắc chắn không?",
                text: "Sau khi xóa, bạn không thể khôi phục danh mục này!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) form.submit();
            });
        });
    });
</script>
@endpush
