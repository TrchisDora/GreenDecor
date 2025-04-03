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
        <h5 class="m-0">Chỉnh sửa Bài Viết</h5>
        <a href="{{ route('post.index') }}" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="bottom" title="Quay lại danh sách bài viết">
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
        <form method="post" action="{{ route('post.update', $post->id) }}">
            @csrf
            @method('PATCH')
            
            <div class="form-group mb-3">
                <label for="inputTitle">Tiêu Đề <span class="text-danger">*</span></label>
                <input id="inputTitle" type="text" name="title" placeholder="Nhập tiêu đề" value="{{ $post->title }}" class="form-control">
                @error('title')<span class="text-danger small">{{ $message }}</span>@enderror
            </div>

            <div class="form-group mb-3">
                <label for="summary">Tóm Tắt <span class="text-danger">*</span></label>
                <textarea class="form-control" id="summary" name="summary">{{ $post->summary }}</textarea>
                @error('summary')<span class="text-danger small">{{ $message }}</span>@enderror
            </div>

            <div class="form-group mb-3">
                <label for="post_cat_id">Danh Mục <span class="text-danger">*</span></label>
                <select name="post_cat_id" class="form-control">
                    <option value="">--Chọn danh mục--</option>
                    @foreach($categories as $data)
                        <option value='{{ $data->id }}' {{ $data->id == $post->post_cat_id ? 'selected' : '' }}>{{ $data->title }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group mb-3">
                <label for="tags">Thẻ</label>
                <select name="tags[]" multiple class="form-control selectpicker">
                    <option value="">--Chọn thẻ--</option>
                    @foreach($tags as $data)
                        <option value="{{ $data->title }}" {{ in_array($data->title, explode(',', $post->tags)) ? 'selected' : '' }}>{{ $data->title }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group mb-3">
                <label for="added_by">Tác Giả</label>
                <select name="added_by" class="form-control">
                    <option value="">--Chọn tác giả--</option>
                    @foreach($users as $data)
                        <option value='{{ $data->id }}' {{ $post->added_by == $data->id ? 'selected' : '' }}>{{ $data->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group mb-3">
                <label for="inputPhoto">Ảnh <span class="text-danger">*</span></label>
                <div class="input-group">
                    <span class="input-group-btn">
                        <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                            <i class="fa fa-picture-o"></i> Chọn
                        </a>
                    </span>
                    <input id="thumbnail" class="form-control" type="text" name="photo" value="{{ $post->photo }}">
                </div>
                <div id="holder" class="mt-2" style="max-height:100px;"></div>
                @error('photo')<span class="text-danger small">{{ $message }}</span>@enderror
            </div>
            
            <div class="form-group mb-3">
                <label for="status">Trạng Thái <span class="text-danger">*</span></label>
                <select name="status" class="form-control">
                    <option value="active" {{ $post->status == 'active' ? 'selected' : '' }}>Kích Hoạt</option>
                    <option value="inactive" {{ $post->status == 'inactive' ? 'selected' : '' }}>Không Kích Hoạt</option>
                </select>
                @error('status')<span class="text-danger small">{{ $message }}</span>@enderror
            </div>
            
            <div class="form-group d-flex justify-content-center">
                <button class="btn btn-warning mx-2" type="reset">Đặt lại</button>
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
        height: 150
    });
    });

    $(document).ready(function() {
      $('#quote').summernote({
        placeholder: "Write short Quote.....",
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
</script>
@endpush