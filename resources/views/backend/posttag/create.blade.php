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
          <h6 class="m-0">Thêm Danh Mục Bài Viết</h6>
          <a href="{{ route('post-tag.index') }}" class="btn btn-danger btn-sm float-right" data-toggle="tooltip"
            data-placement="bottom" title="Quay lại danh sách">
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
          <form method="post" action="{{ route('post-tag.store') }}">
            {{ csrf_field() }}

            <!-- Tiêu đề -->
            <div class="form-group mb-3">
              <label for="inputTitle" class="col-form-label">Tiêu đề</label>
              <input id="inputTitle" type="text" name="title" placeholder="Nhập tiêu đề" value="{{ old('title') }}" class="form-control">
              @error('title')
              <span class="text-danger small">{{ $message }}</span>
              @enderror
            </div>

            <!-- Trạng thái -->
            <div class="form-group mb-3">
              <label for="status" class="col-form-label">Trạng thái</label>
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
              <button class="btn btn-success mx-2" type="submit">Lưu</button>
            </div>

          </form>
        </div>
      </div>
    </div>
  </div>
</div>


@endsection
