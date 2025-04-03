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
        <h6 class="m-0">Thêm Sản Phẩm</h6>
        <a href="{{ route('product.index') }}" class="btn btn-danger btn-sm float-right" data-toggle="tooltip"
        data-placement="bottom" title="Quay lại danh sách sản phẩm">
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
        <form method="post" action="{{route('product.store')}}">
        @csrf

        <div class="form-group">
          <label for="inputTitle" class="col-form-label">Tiêu đề <span class="text-danger">*</span></label>
          <input id="inputTitle" type="text" name="title" placeholder="Nhập tiêu đề" value="{{old('title')}}"
          class="form-control">
          @error('title')
        <span class="text-danger">{{$message}}</span>
      @enderror
        </div>

        <div class="form-group">
          <label for="summary" class="col-form-label">Tóm tắt <span class="text-danger">*</span></label>
          <textarea class="form-control" id="summary" name="summary">{{old('summary')}}</textarea>
          @error('summary')
        <span class="text-danger">{{$message}}</span>
      @enderror
        </div>

        <div class="form-group">
          <label for="description" class="col-form-label">Mô tả</label>
          <textarea class="form-control" id="description" name="description">{{old('description')}}</textarea>
          @error('description')
        <span class="text-danger">{{$message}}</span>
      @enderror
        </div>

        <div class="form-group">
          <label for="is_featured">Có nổi bật</label><br>
          <input type="checkbox" name='is_featured' id='is_featured' value='1' checked> Có
        </div>

        <div class="form-group">
          <label for="cat_id">Danh mục <span class="text-danger">*</span></label>
          <select name="cat_id" id="cat_id" class="form-control">
          <option value="">--Chọn danh mục--</option>
          @foreach($categories as $key => $cat_data)
        <option value='{{$cat_data->id}}'>{{$cat_data->title}}</option>
      @endforeach
          </select>
        </div>

        <div class="form-group d-none" id="child_cat_div">
          <label for="child_cat_id">Danh mục con</label>
          <select name="child_cat_id" id="child_cat_id" class="form-control">
          <option value="">--Chọn danh mục con--</option>
          {{-- @foreach($parent_cats as $key=>$parent_cat)
          <option value='{{$parent_cat->id}}'>{{$parent_cat->title}}</option>
          @endforeach --}}
          </select>
        </div>

        <div class="form-group">
          <label for="price" class="col-form-label">Giá ($) <span class="text-danger">*</span></label>
          <input id="price" type="number" name="price" placeholder="Nhập giá" value="{{old('price')}}"
          class="form-control">
          @error('price')
        <span class="text-danger">{{$message}}</span>
      @enderror
        </div>

        <div class="form-group">
          <label for="discount" class="col-form-label">Giảm giá (%)</label>
          <input id="discount" type="number" name="discount" min="0" max="100" placeholder="Nhập giảm giá"
          value="{{old('discount')}}" class="form-control">
          @error('discount')
        <span class="text-danger">{{$message}}</span>
      @enderror
        </div>

        <div class="form-group">
          <label for="size">Kích cỡ</label>
          <select name="size[]" class="form-control selectpicker" multiple data-live-search="true">
          <option value="">--Chọn kích cỡ--</option>
          <option value="S">Nhỏ (S)</option>
          <option value="M">Vừa (M)</option>
          <option value="L">Lớn (L)</option>
          <option value="XL">Cực lớn (XL)</option>
          <option value="2XL">Siêu lớn (2XL)</option>
          <option value="7US">7 US</option>
          <option value="8US">8 US</option>
          <option value="9US">9 US</option>
          <option value="10US">10 US</option>
          <option value="11US">11 US</option>
          <option value="12US">12 US</option>
          <option value="13US">13 US</option>
          </select>
        </div>

        <div class="form-group">
          <label for="brand_id">Thương hiệu</label>
          <select name="brand_id" class="form-control">
          <option value="">--Chọn thương hiệu--</option>
          @foreach($brands as $brand)
        <option value="{{$brand->id}}">{{$brand->title}}</option>
      @endforeach
          </select>
        </div>

        <div class="form-group">
          <label for="condition">Tình trạng</label>
          <select name="condition" class="form-control">
          <option value="">--Chọn tình trạng--</option>
          <option value="default">Mặc định</option>
          <option value="new">Mới</option>
          <option value="hot">Hot</option>
          </select>
        </div>

        <div class="form-group">
          <label for="stock">Số lượng <span class="text-danger">*</span></label>
          <input id="quantity" type="number" name="stock" min="0" placeholder="Nhập số lượng"
          value="{{old('stock')}}" class="form-control">
          @error('stock')
        <span class="text-danger">{{$message}}</span>
      @enderror
        </div>

        <div class="form-group">
          <label for="inputPhoto" class="col-form-label">Ảnh <span class="text-danger">*</span></label>
          <div class="input-group">
          <span class="input-group-btn">
          <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                                <i class="fas fa-image"></i> Chọn ảnh
                            </a>
          </span>
          <input id="thumbnail" class="form-control" type="text" name="photo" value="{{old('photo')}}">
          </div>
          <div id="holder" style="margin-top:15px;max-height:100px;"></div>
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

        <div class="form-group text-center">
          <button type="reset" class="btn btn-warning">Đặt lại</button>
          <button class="btn btn-success" type="submit">Gửi</button>
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

    $(document).ready(function () {
    $('#summary').summernote({
      placeholder: "Write short description.....",
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
    // $('select').selectpicker();

  </script>

  <script>
    $('#cat_id').change(function () {
    var cat_id = $(this).val();
    // alert(cat_id);
    if (cat_id != null) {
      // Ajax call
      $.ajax({
      url: "/admin/category/" + cat_id + "/child",
      data: {
        _token: "{{csrf_token()}}",
        id: cat_id
      },
      type: "POST",
      success: function (response) {
        if (typeof (response) != 'object') {
        response = $.parseJSON(response)
        }
        // console.log(response);
        var html_option = "<option value=''>----Select sub category----</option>"
        if (response.status) {
        var data = response.data;
        // alert(data);
        if (response.data) {
          $('#child_cat_div').removeClass('d-none');
          $.each(data, function (id, title) {
          html_option += "<option value='" + id + "'>" + title + "</option>"
          });
        }
        else {
        }
        }
        else {
        $('#child_cat_div').addClass('d-none');
        }
        $('#child_cat_id').html(html_option);
      }
      });
    }
    else {
    }
    })
  </script>
@endpush