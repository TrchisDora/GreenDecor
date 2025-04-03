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
        <h6 class="m-0">Thêm Danh mục</h6>
        <a href="{{ route('category.index') }}" class="btn btn-danger btn-sm float-right" data-toggle="tooltip"
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
          <h5 class="card-header">Thông tin Danh Mục</h5>
          <div class="card-body">
            <form method="post" action="{{route('category.store')}}">
              {{csrf_field()}}

              <div class="form-group">
                <label for="inputTitle" class="col-form-label">Tiêu đề <span class="text-danger">*</span></label>
                <input id="inputTitle" type="text" name="title" placeholder="Nhập tiêu đề" value="{{old('title')}}" class="form-control">
                @error('title')
                  <span class="text-danger">{{$message}}</span>
                @enderror
              </div>

              <div class="form-group">
                <label for="summary" class="col-form-label">Tóm tắt</label>
                <textarea class="form-control" id="summary" name="summary">{{old('summary')}}</textarea>
                @error('summary')
                  <span class="text-danger">{{$message}}</span>
                @enderror
              </div>

              <div class="form-group">
                <label for="is_parent">Danh mục cha</label><br>
                <input type="checkbox" name="is_parent" id="is_parent" value="1" checked> Có
              </div>

              <div class="form-group d-none" id="parent_cat_div">
                <label for="parent_id">Danh mục cha</label>
                <select name="parent_id" class="form-control">
                  <option value="">--Chọn danh mục--</option>
                  @foreach($parent_cats as $key=>$parent_cat)
                    <option value="{{$parent_cat->id}}">{{$parent_cat->title}}</option>
                  @endforeach
                </select>
              </div>

              <div class="form-group">
                <label for="inputPhoto" class="col-form-label">Ảnh</label>
                <div class="input-group">
                  <span class="input-group-btn">
                  <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                                <i class="fas fa-image"></i> Chọn ảnh
                            </a>
                  </span>
                  <input id="thumbnail" class="form-control" type="text" name="photo" value="{{old('photo')}}">
                </div>
                <div id="holder" style="margin-top:15px; max-height:100px;"></div>
                @error('photo')
                  <span class="text-danger">{{$message}}</span>
                @enderror
              </div>

              <div class="form-group">
                <label for="status" class="col-form-label">Trạng thái <span class="text-danger">*</span></label>
                <select name="status" class="form-control">
                  <option value="active">Hoạt động</option>
                  <option value="inactive">Không hoạt động</option>
                </select>
                @error('status')
                  <span class="text-danger">{{$message}}</span>
                @enderror
              </div>

              <div class="form-group mb-3 text-center">
                <button type="reset" class="btn btn-warning">Đặt lại</button>
                <button class="btn btn-success" type="submit">Xác nhận</button>
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
      $('#summary').summernote({
        placeholder: "Write short description.....",
          tabsize: 2,
          height: 120
      });
    });
</script>

<script>
  $('#is_parent').change(function(){
    var is_checked=$('#is_parent').prop('checked');
    // alert(is_checked);
    if(is_checked){
      $('#parent_cat_div').addClass('d-none');
      $('#parent_cat_div').val('');
    }
    else{
      $('#parent_cat_div').removeClass('d-none');
    }
  })
</script>
@endpush