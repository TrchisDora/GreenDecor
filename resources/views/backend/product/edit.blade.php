@extends('backend.layouts.master')

@section('main-content')
<div class="container-fluid">
<div class="row mb-3">
    <div class="col-md-12">
    </div>
    </div>
    <div class="card">
        <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
            <h6 class="m-0">Chỉnh Sửa Sản Phẩm</h6>
            <a href="{{ route('product.index') }}" class="btn btn-danger btn-sm float-right" data-toggle="tooltip" data-placement="bottom" title="Quay lại danh sách sản phẩm">
                <i class="fas fa-back"></i> Quay lại
            </a>
        </div>
        <div class="card-body">
            <form method="post" action="{{ route('product.update', $product->id) }}">
                @csrf
                @method('PATCH')
                <!-- Tiêu đề -->
                <div class="form-group">
                    <label for="inputTitle" class="col-form-label">Tiêu Đề <span class="text-danger">*</span></label>
                    <input id="inputTitle" type="text" name="title" placeholder="Nhập tiêu đề" value="{{ $product->title }}" class="form-control">
                    @error('title')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Tóm tắt -->
                <div class="form-group">
                    <label for="summary" class="col-form-label">Tóm Tắt <span class="text-danger">*</span></label>
                    <textarea class="form-control" id="summary" name="summary">{{ $product->summary }}</textarea>
                    @error('summary')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Mô tả -->
                <div class="form-group">
                    <label for="description" class="col-form-label">Mô Tả</label>
                    <textarea class="form-control" id="description" name="description">{{ $product->description }}</textarea>
                    @error('description')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Nổi bật -->
                <div class="form-group">
                    <label for="is_featured">Có Nổi Bật</label><br>
                    <input type="checkbox" name="is_featured" id="is_featured" value="{{ $product->is_featured }}" {{ ($product->is_featured ? 'checked' : '') }}> Có
                </div>

                <!-- Danh mục -->
                <div class="form-group">
                    <label for="cat_id">Danh Mục <span class="text-danger">*</span></label>
                    <select name="cat_id" id="cat_id" class="form-control">
                        <option value="">--Chọn danh mục--</option>
                        @foreach($categories as $key => $cat_data)
                            <option value="{{ $cat_data->id }}" {{ ($product->cat_id == $cat_data->id ? 'selected' : '') }}>{{ $cat_data->title }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Danh mục con (nếu có) -->
                <div class="form-group {{ ($product->child_cat_id ? '' : 'd-none') }}" id="child_cat_div">
                    <label for="child_cat_id">Danh Mục Con</label>
                    <select name="child_cat_id" id="child_cat_id" class="form-control">
                        <option value="">--Chọn danh mục con--</option>
                    </select>
                </div>

                <!-- Giá -->
                <div class="form-group">
                    <label for="price" class="col-form-label">Giá (NRS) <span class="text-danger">*</span></label>
                    <input id="price" type="number" name="price" placeholder="Nhập giá" value="{{ $product->price }}" class="form-control">
                    @error('price')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Giảm giá -->
                <div class="form-group">
                    <label for="discount" class="col-form-label">Giảm Giá (%)</label>
                    <input id="discount" type="number" name="discount" min="0" max="100" placeholder="Nhập giảm giá" value="{{ $product->discount }}" class="form-control">
                    @error('discount')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Kích thước -->
                <div class="form-group">
                    <label for="size">Kích Thước</label>
                    <select name="size[]" class="form-control selectpicker" multiple data-live-search="true">
                        <option value="">--Chọn kích thước--</option>
                        @foreach($items as $item)
                            @php 
                                $data = explode(',', $item->size);
                            @endphp
                            <option value="S" @if(in_array("S", $data)) selected @endif>Nhỏ</option>
                            <option value="M" @if(in_array("M", $data)) selected @endif>Vừa</option>
                            <option value="L" @if(in_array("L", $data)) selected @endif>Lớn</option>
                            <option value="XL" @if(in_array("XL", $data)) selected @endif>Extra Lớn</option>
                            <option value="2XL" @if(in_array("2XL", $data)) selected @endif>Double Extra Lớn</option>
                            <option value="FS" @if(in_array("FS", $data)) selected @endif>Free Size</option>
                        @endforeach
                    </select>
                </div>

                <!-- Thương hiệu -->
                <div class="form-group">
                    <label for="brand_id">Thương Hiệu</label>
                    <select name="brand_id" class="form-control">
                        <option value="">--Chọn Thương Hiệu--</option>
                        @foreach($brands as $brand)
                            <option value="{{ $brand->id }}" {{ ($product->brand_id == $brand->id ? 'selected' : '') }}>{{ $brand->title }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Tình trạng -->
                <div class="form-group">
                    <label for="condition">Tình Trạng</label>
                    <select name="condition" class="form-control">
                        <option value="">--Chọn Tình Trạng--</option>
                        <option value="default" {{ ($product->condition == 'default' ? 'selected' : '') }}>Mặc định</option>
                        <option value="new" {{ ($product->condition == 'new' ? 'selected' : '') }}>Mới</option>
                        <option value="hot" {{ ($product->condition == 'hot' ? 'selected' : '') }}>Hot</option>
                    </select>
                </div>

                <!-- Số lượng -->
                <div class="form-group">
                    <label for="stock">Số Lượng <span class="text-danger">*</span></label>
                    <input id="quantity" type="number" name="stock" min="0" placeholder="Nhập số lượng" value="{{ $product->stock }}" class="form-control">
                    @error('stock')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Ảnh -->
                <div class="form-group">
                    <label for="inputPhoto" class="col-form-label">Ảnh <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-btn">
                            <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                                <i class="fas fa-image"></i> Chọn ảnh
                            </a>
                        </span>
                        <input id="thumbnail" class="form-control" type="text" name="photo" value="{{ $product->photo }}">
                    </div>
                    <div id="holder" style="margin-top: 15px; max-height: 100px;"></div>
                    @error('photo')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Trạng thái -->
                <div class="form-group">
                    <label for="status" class="col-form-label">Trạng Thái <span class="text-danger">*</span></label>
                    <select name="status" class="form-control">
                        <option value="active" {{ ($product->status == 'active' ? 'selected' : '') }}>Kích hoạt</option>
                        <option value="inactive" {{ ($product->status == 'inactive' ? 'selected' : '') }}>Không kích hoạt</option>
                    </select>
                    @error('status')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Nút cập nhật -->
                <div class="form-group mb-3 d-flex justify-content-center">
                    <button class="btn btn-success" type="submit">Cập Nhật</button>
                </div>
            </form>
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
      $('#description').summernote({
        placeholder: "Write detail Description.....",
          tabsize: 2,
          height: 150
      });
    });
</script>

<script>
  var  child_cat_id='{{$product->child_cat_id}}';
        // alert(child_cat_id);
        $('#cat_id').change(function(){
            var cat_id=$(this).val();

            if(cat_id !=null){
                // ajax call
                $.ajax({
                    url:"/admin/category/"+cat_id+"/child",
                    type:"POST",
                    data:{
                        _token:"{{csrf_token()}}"
                    },
                    success:function(response){
                        if(typeof(response)!='object'){
                            response=$.parseJSON(response);
                        }
                        var html_option="<option value=''>--Select any one--</option>";
                        if(response.status){
                            var data=response.data;
                            if(response.data){
                                $('#child_cat_div').removeClass('d-none');
                                $.each(data,function(id,title){
                                    html_option += "<option value='"+id+"' "+(child_cat_id==id ? 'selected ' : '')+">"+title+"</option>";
                                });
                            }
                            else{
                                console.log('no response data');
                            }
                        }
                        else{
                            $('#child_cat_div').addClass('d-none');
                        }
                        $('#child_cat_id').html(html_option);

                    }
                });
            }
            else{

            }

        });
        if(child_cat_id!=null){
            $('#cat_id').change();
        }
</script>
@endpush