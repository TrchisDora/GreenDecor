@extends('backend.layouts.master')
@section('title','Ecommerce Laravel || Brand Create')
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
                    <h6 class="m-0">Thêm Thương Hiệu</h6>
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
<form method="post" action="{{ route('brand.store') }}">
    {{ csrf_field() }}

    <!-- Tiêu đề -->
    <div class="form-group mb-3">
        <label for="inputTitle" class="col-form-label">Tiêu Đề <span class="text-danger">*</span></label>
        <input id="inputTitle" type="text" name="title" placeholder="Nhập tiêu đề" value="{{ old('title') }}" class="form-control">
        @error('title')
            <span class="text-danger small">{{ $message }}</span>
        @enderror
    </div>

    <!-- Ảnh -->
    <div class="form-group">
        <label for="inputPhoto" class="col-form-label">Ảnh <span class="text-danger">*</span></label>
        <div class="input-group">
            <span class="input-group-btn">
                <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                    <i class="fas fa-image"></i> Chọn ảnh
                </a>
            </span>
            <input id="thumbnail" class="form-control" type="text" name="photo" value="{{ old('photo') }}">
        </div>
        <div id="holder" style="margin-top: 15px; max-height: 100px;"></div>
        @error('photo')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>

    <!-- Trạng thái -->
    <div class="form-group mb-3">
        <label for="status" class="col-form-label">Trạng Thái <span class="text-danger">*</span></label>
        <select name="status" class="form-control">
            <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Kích hoạt</option>
            <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Không kích hoạt</option>
        </select>
        @error('status')
            <span class="text-danger small">{{ $message }}</span>
        @enderror
    </div>

    <!-- Nút submit và reset -->
    <div class="form-group mb-3 d-flex justify-content-center">
        <button type="reset" class="btn btn-warning mx-2">Đặt lại</button>
        <button class="btn btn-success mx-2" type="submit">Lưu</button>
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