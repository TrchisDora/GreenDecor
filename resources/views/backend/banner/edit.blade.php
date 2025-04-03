@extends('backend.layouts.master')
@section('title','Ecommerce Laravel || Banner Edit')
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
        <h6 class="m-0">Chỉnh sửa Banner</h6>
        <a href="{{ route('banner.index') }}" class="btn btn-danger btn-sm float-right" data-toggle="tooltip"
        data-placement="bottom" title="Thêm danh mục">
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
          <h5 class="card-header">Thông tin Banner</h5>
          <div class="card-body">
            <form method="post" action="{{route('banner.update', $banner->id)}}">
              @csrf 
              @method('PATCH')

              <div class="form-group">
                <label for="inputTitle" class="col-form-label">Tiêu đề <span class="text-danger">*</span></label>
                <input id="inputTitle" type="text" name="title" placeholder="Enter title" value="{{$banner->title}}" class="form-control">
                @error('title')
                  <span class="text-danger">{{$message}}</span>
                @enderror
              </div>

              <div class="form-group">
                <label for="inputDesc" class="col-form-label">Mô tả</label>
                <textarea class="form-control" id="description" name="description">{{$banner->description}}</textarea>
                @error('description')
                  <span class="text-danger">{{$message}}</span>
                @enderror
              </div>

              <div class="form-group">
                <label for="inputPhoto" class="col-form-label">Hình ảnh <span class="text-danger">*</span></label>
                <div class="input-group">
                  <span class="input-group-btn">
                  <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                                <i class="fas fa-image"></i> Chọn ảnh
                            </a>
                  </span>
                  <input id="thumbnail" class="form-control" type="text" name="photo" value="{{$banner->photo}}">
                </div>
                <div id="holder" style="margin-top:15px; max-height:100px;"></div>
                @error('photo')
                  <span class="text-danger">{{$message}}</span>
                @enderror
              </div>

              <div class="form-group">
                <label for="status" class="col-form-label">Trạng thái <span class="text-danger">*</span></label>
                <select name="status" class="form-control">
                  <option value="active" {{(($banner->status == 'active') ? 'selected' : '')}}>Hoạt động</option>
                  <option value="inactive" {{(($banner->status == 'inactive') ? 'selected' : '')}}>Không hoạt động</option>
                </select>
                @error('status')
                  <span class="text-danger">{{$message}}</span>
                @enderror
              </div>

              <div class="form-group mb-3 text-center">
                <button class="btn btn-success" type="submit">Cập nhật</button>
              </div>
            </form>
          </div>
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