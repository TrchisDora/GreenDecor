@extends('backend.layouts.master')

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
                    <h6 class="m-0">Thêm Phương Thức Vận Chuyển</h6>
                    <a href="{{ route('shipping.index') }}" class="btn btn-danger btn-sm float-right" data-toggle="tooltip"
                        data-placement="bottom" title="Quay lại danh sách phương thức vận chuyển">
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
                    <h5 class="card-header">Thông Tin Phương Thức Vận Chuyển</h5>
                    <form method="post" action="{{ route('shipping.store') }}">
                        {{ csrf_field() }}

                        <!-- Loại -->
                        <div class="form-group mb-3">
                            <label for="inputTitle" class="col-form-label">Loại <span class="text-danger">*</span></label>
                            <input id="inputTitle" type="text" name="type" placeholder="Nhập loại phương thức" value="{{ old('type') }}" class="form-control">
                            @error('type')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Giá -->
                        <div class="form-group mb-3">
                            <label for="price" class="col-form-label">Giá <span class="text-danger">*</span></label>
                            <input id="price" type="number" name="price" placeholder="Nhập giá" value="{{ old('price') }}" class="form-control">
                            @error('price')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Trạng thái -->
                        <div class="form-group mb-3">
                            <label for="status" class="col-form-label">Trạng Thái <span class="text-danger">*</span></label>
                            <select name="status" class="form-control">
                                <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Hoạt động</option>
                                <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Không hoạt động</option>
                            </select>
                            @error('status')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Nút submit và reset -->
                        <div class="form-group mb-3 d-flex justify-content-center">
                            <button type="reset" class="btn btn-warning mx-2">Đặt lại</button>
                            <button class="btn btn-success mx-2" type="submit">Xác nhận</button>
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