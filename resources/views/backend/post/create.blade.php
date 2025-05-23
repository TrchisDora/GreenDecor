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
          <h6 class="m-0">Thêm Bài Viết</h6>
          <a href="{{ route('post.index') }}" class="btn btn-danger btn-sm" data-toggle="tooltip" title="Quay lại danh sách bài viết">
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
          <h5 class="card-header">Thông tin Bài Viết</h5>
          <form method="post" action="{{ route('post.store') }}">
            {{ csrf_field() }}

            <!-- Tiêu đề -->
            <div class="form-group mb-3">
              <label for="inputTitle" class="col-form-label">Tiêu đề <span class="text-danger">*</span></label>
              <input id="inputTitle" type="text" name="title" placeholder="Nhập tiêu đề" value="{{ old('title') }}" class="form-control">
              @error('title')
                <span class="text-danger small">{{ $message }}</span>
              @enderror
            </div>

            <!-- Trích dẫn -->
            <div class="form-group mb-3">
              <label for="quote" class="col-form-label">Trích dẫn</label>
              <textarea class="form-control" id="quote" name="quote">{{ old('quote') }}</textarea>
              @error('quote')
                <span class="text-danger small">{{ $message }}</span>
              @enderror
            </div>

            <!-- Tóm tắt -->
            <div class="form-group mb-3">
              <label for="summary" class="col-form-label">Tóm tắt <span class="text-danger">*</span></label>
              <textarea class="form-control" id="summary" name="summary">{{ old('summary') }}</textarea>
              @error('summary')
                <span class="text-danger small">{{ $message }}</span>
              @enderror
            </div>

            <!-- Mô tả -->
            <div class="form-group mb-3">
              <label for="description" class="col-form-label">Mô tả</label>
              <textarea class="form-control" id="description" name="description">{{ old('description') }}</textarea>
              @error('description')
                <span class="text-danger small">{{ $message }}</span>
              @enderror
            </div>

            <!-- Danh mục -->
            <div class="form-group mb-3">
              <label for="post_cat_id" class="col-form-label">Danh mục <span class="text-danger">*</span></label>
              <select name="post_cat_id" class="form-control">
                <option value="">--Chọn danh mục--</option>
                @foreach($categories as $key=>$data)
                  <option value='{{ $data->id }}'>{{ $data->title }}</option>
                @endforeach
              </select>
            </div>

            <!-- Thẻ -->
            <div class="form-group mb-3">
              <label for="tags" class="col-form-label">Thẻ</label>
              <select name="tags[]" multiple data-live-search="true" class="form-control selectpicker">
                <option value="">--Chọn thẻ--</option>
                @foreach($tags as $key=>$data)
                  <option value='{{ $data->title }}'>{{ $data->title }}</option>
                @endforeach
              </select>
            </div>

            <!-- Tác giả -->
            <div class="form-group mb-3">
              <label for="added_by" class="col-form-label">Tác giả</label>
              <select name="added_by" class="form-control">
                <option value="">--Chọn tác giả--</option>
                @foreach($users as $key=>$data)
                  <option value='{{ $data->id }}' {{ ($key==0) ? 'selected' : '' }}>{{ $data->name }}</option>
                @endforeach
              </select>
            </div>

            <!-- Ảnh -->
            <div class="form-group mb-3">
              <label for="inputPhoto" class="col-form-label">Ảnh <span class="text-danger">*</span></label>
              <div class="input-group">
                <span class="input-group-btn">
                  <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                    <i class="fa fa-picture-o"></i> Chọn ảnh
                  </a>
                </span>
                <input id="thumbnail" class="form-control" type="text" name="photo" value="{{ old('photo') }}">
              </div>
              <div id="holder" style="margin-top:15px; max-height:100px;"></div>
              @error('photo')
                <span class="text-danger small">{{ $message }}</span>
              @enderror
            </div>

            <!-- Trạng thái -->
            <div class="form-group mb-3">
              <label for="status" class="col-form-label">Trạng thái <span class="text-danger">*</span></label>
              <select name="status" class="form-control">
                <option value="active">Hoạt động</option>
                <option value="inactive">Không hoạt động</option>
              </select>
              @error('status')
                <span class="text-danger small">{{ $message }}</span>
              @enderror
            </div>

            <!-- Nút Submit và Reset -->
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
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
@endpush
@push('scripts')
<script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
<script src="{{asset('backend/summernote/summernote.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>

<script>
    $('#lfm').filemanager('image');

    $(document).ready(function() {
      $('#summary').summernote({
        placeholder: "Write short description.....",
          tabsize: 2,
          height: 100
      });
    });

    $(document).ready(function() {
      $('#description').summernote({
        placeholder: "Write detail description.....",
          tabsize: 2,
          height: 150
      });
    });

    $(document).ready(function() {
      $('#quote').summernote({
        placeholder: "Write detail Quote.....",
          tabsize: 2,
          height: 100
      });
    });
    // $('select').selectpicker();

</script>
@endpush