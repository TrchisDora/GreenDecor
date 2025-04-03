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
                    <h6 class="m-0">Chỉnh Sửa Danh Mục Bài Viết</h6>
                    <a href="{{ route('post-category.index') }}" class="btn btn-danger btn-sm float-right" data-toggle="tooltip"
                        data-placement="bottom" title="Quay lại danh sách danh mục">
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
                    <h5 class="card-header">Thông Tin Danh Mục</h5>
                    <form method="post" action="{{ route('post-category.update', $postCategory->id) }}">
                        @csrf 
                        @method('PATCH')

                        <!-- Tiêu đề -->
                        <div class="form-group mb-3">
                            <label for="inputTitle" class="col-form-label">Tiêu Đề <span class="text-danger">*</span></label>
                            <input id="inputTitle" type="text" name="title" placeholder="Nhập tiêu đề"
                                value="{{ $postCategory->title }}" class="form-control">
                            @error('title')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Trạng thái -->
                        <div class="form-group mb-3">
                            <label for="status" class="col-form-label">Trạng Thái <span class="text-danger">*</span></label>
                            <select name="status" class="form-control">
                                <option value="active" {{ $postCategory->status == 'active' ? 'selected' : '' }}>Kích hoạt</option>
                                <option value="inactive" {{ $postCategory->status == 'inactive' ? 'selected' : '' }}>Không kích hoạt</option>
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
