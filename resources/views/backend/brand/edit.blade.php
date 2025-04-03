@extends('backend.layouts.master')
@section('title','Ecommerce Laravel || Brand Edit')
@section('main-content')

<div class="container-fluid">
    <div class="row mb-3">
        <div class="col-md-12">
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                    <h6 class="m-0">Sửa Thương Hiệu</h6>
                    <a href="{{ route('brand.index') }}" class="btn btn-primary btn-sm float-right" data-toggle="tooltip"
                        data-placement="bottom" title="Quay lại danh sách thương hiệu">
                        <i class="fas fa-back"></i> Quay lại
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-header">Thông Tin Thương Hiệu</h5>
                    <form method="post" action="{{ route('brand.update', $brand->id) }}">
                        @csrf
                        @method('PATCH')

                        <!-- Tiêu đề -->
                        <div class="form-group mb-3">
                            <label for="inputTitle" class="col-form-label">Tiêu Đề <span class="text-danger">*</span></label>
                            <input id="inputTitle" type="text" name="title" placeholder="Nhập tiêu đề" value="{{ $brand->title }}" class="form-control">
                            @error('title')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Trạng thái -->
                        <div class="form-group mb-3">
                            <label for="status" class="col-form-label">Trạng Thái <span class="text-danger">*</span></label>
                            <select name="status" class="form-control">
                                <option value="active" {{ $brand->status == 'active' ? 'selected' : '' }}>Kích hoạt</option>
                                <option value="inactive" {{ $brand->status == 'inactive' ? 'selected' : '' }}>Không kích hoạt</option>
                            </select>
                            @error('status')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Nút submit -->
                        <div class="form-group mb-3 d-flex justify-content-center">
                            <button class="btn btn-success mx-2" type="submit">Cập nhật</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection

@push('styles')
<link rel="stylesheet" href="{{asset('backend/summernote/summernote.min.css')}}">
@endpush
@push('scripts')
<script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
<script src="{{asset('backend/summernote/summernote.min.js')}}"></script>
<script>
    $('#lfm').filemanager('image');

    $(document).ready(function() {
    $('#description').summernote({
      placeholder: "Write short description.....",
        tabsize: 2,
        height: 150
    });
    });
</script>
@endpush