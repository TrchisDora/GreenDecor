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
                    <h6 class="m-0">Chỉnh sửa Mã Giảm Giá</h6>
                    <a href="{{ route('coupon.index') }}" class="btn btn-danger btn-sm float-right" data-toggle="tooltip"
                        data-placement="bottom" title="Quay lại danh sách mã giảm giá">
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
                    <h5 class="card-header">Thông Tin Mã Giảm Giá</h5>
                    <form method="post" action="{{ route('coupon.update', $coupon->id) }}">
                        @csrf 
                        @method('PATCH')

                        <!-- Mã giảm giá -->
                        <div class="form-group mb-3">
                            <label for="inputCode" class="col-form-label">Mã Giảm Giá <span class="text-danger">*</span></label>
                            <input id="inputCode" type="text" name="code" placeholder="Nhập mã giảm giá" value="{{ $coupon->code }}" class="form-control">
                            @error('code')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Loại giảm giá -->
                        <div class="form-group mb-3">
                            <label for="type" class="col-form-label">Loại <span class="text-danger">*</span></label>
                            <select name="type" class="form-control">
                                <option value="fixed" {{ $coupon->type == 'fixed' ? 'selected' : '' }}>Cố định</option>
                                <option value="percent" {{ $coupon->type == 'percent' ? 'selected' : '' }}>Phần trăm</option>
                            </select>
                            @error('type')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Giá trị giảm -->
                        <div class="form-group mb-3">
                            <label for="inputValue" class="col-form-label">Giá Trị <span class="text-danger">*</span></label>
                            <input id="inputValue" type="number" name="value" placeholder="Nhập giá trị giảm" value="{{ $coupon->value }}" class="form-control">
                            @error('value')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Trạng thái -->
                        <div class="form-group mb-3">
                            <label for="status" class="col-form-label">Trạng Thái <span class="text-danger">*</span></label>
                            <select name="status" class="form-control">
                                <option value="active" {{ $coupon->status == 'active' ? 'selected' : '' }}>Hoạt động</option>
                                <option value="inactive" {{ $coupon->status == 'inactive' ? 'selected' : '' }}>Không hoạt động</option>
                            </select>
                            @error('status')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Nút cập nhật -->
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