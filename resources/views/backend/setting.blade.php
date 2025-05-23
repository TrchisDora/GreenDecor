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
        <h6 class="m-0">Sửa Thông Tin</h6>
        <a href="#" class="btn btn btn-sm float-right" data-toggle="tooltip" data-placement="bottom" title=""><i
          class="fas fa-star" style="color:#55AC49;"></i></a>
      </div>
      </div>
    </div>
    </div>
    <div class="row">
    <div class="col-md-12">
      <div class="card shadow-sm">
      <div class="card-body">
        <h5 class="card-header">Thông Tin Cập Nhật</h5>
        <form method="post" action="{{ route('settings.update') }}">
        @csrf
        {{-- @method('PATCH') --}}
        {{-- {{dd($data)}} --}}

        <!-- Mô tả ngắn -->
        <div class="form-group mb-3">
          <label for="short_des" class="col-form-label">Mô Tả Ngắn <span class="text-danger">*</span></label>
          <textarea class="form-control" id="quote" name="short_des">{{ $data->short_des }}</textarea>
          @error('short_des')
        <span class="text-danger small">{{ $message }}</span>
      @enderror
        </div>

        <!-- Mô tả đầy đủ -->
        <div class="form-group mb-3">
          <label for="description" class="col-form-label">Mô Tả <span class="text-danger">*</span></label>
          <textarea class="form-control" id="description" name="description">{{ $data->description }}</textarea>
          @error('description')
        <span class="text-danger small">{{ $message }}</span>
      @enderror
        </div>

        <!-- Logo -->
        <div class="form-group mb-3">
          <label for="inputPhoto" class="col-form-label">Logo <span class="text-danger">*</span></label>
          <div class="input-group">
          <span class="input-group-btn">
            <a id="lfm1" data-input="thumbnail1" data-preview="holder1" class="btn btn-primary text-white">
            <i class="fa fa-picture-o"></i> Chọn ảnh
            </a>
          </span>
          <input id="thumbnail1" class="form-control" type="text" name="logo" value="{{ $data->logo }}">
          </div>
          <div id="holder1" style="margin-top:15px;max-height:100px;"></div>
          @error('logo')
        <span class="text-danger small">{{ $message }}</span>
      @enderror
        </div>

        <!-- Ảnh -->
        <div class="form-group mb-3">
          <label for="inputPhoto" class="col-form-label">Ảnh <span class="text-danger">*</span></label>
          <div class="input-group">
          <span class="input-group-btn">
            <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary text-white">
            <i class="fa fa-picture-o"></i> Chọn ảnh
            </a>
          </span>
          <input id="thumbnail" class="form-control" type="text" name="photo" value="{{ $data->photo }}">
          </div>
          <div id="holder" style="margin-top:15px;max-height:100px;"></div>
          @error('photo')
        <span class="text-danger small">{{ $message }}</span>
      @enderror
        </div>

        <!-- Địa chỉ -->
        <div class="form-group mb-3">
          <label for="address" class="col-form-label">Địa Chỉ <span class="text-danger">*</span></label>
          <input type="text" class="form-control" name="address" required value="{{ $data->address }}">
          @error('address')
        <span class="text-danger small">{{ $message }}</span>
      @enderror
        </div>

        <!-- Email -->
        <div class="form-group mb-3">
          <label for="email" class="col-form-label">Email <span class="text-danger">*</span></label>
          <input type="email" class="form-control" name="email" required value="{{ $data->email }}">
          @error('email')
        <span class="text-danger small">{{ $message }}</span>
      @enderror
        </div>

        <!-- Số điện thoại -->
        <div class="form-group mb-3">
          <label for="phone" class="col-form-label">Số Điện Thoại <span class="text-danger">*</span></label>
          <input type="text" class="form-control" name="phone" required value="{{ $data->phone }}">
          @error('phone')
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
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />

@endpush
@push('scripts')
  <script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
  <script src="{{asset('backend/summernote/summernote.min.js')}}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>

  <script>
    $('#lfm').filemanager('image');
    $('#lfm1').filemanager('image');
    $(document).ready(function () {
    $('#summary').summernote({
      placeholder: "Write short description.....",
      tabsize: 2,
      height: 150
    });
    });

    $(document).ready(function () {
    $('#quote').summernote({
      placeholder: "Write short Quote.....",
      tabsize: 2,
      height: 100
    });
    });
    $(document).ready(function () {
    $('#description').summernote({
      placeholder: "Write detail description.....",
      tabsize: 2,
      height: 150
    });
    });
  </script>
@endpush