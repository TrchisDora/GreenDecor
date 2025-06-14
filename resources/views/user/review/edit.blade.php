@extends('user.layouts.master')

@section('title','Edit Review')

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
                    <h6 class="m-0">Sửa Đánh Giá</h6>
                    <a href="{{ route('user.productreview.index') }}" class="btn btn-primary btn-sm float-right" data-toggle="tooltip"
                        data-placement="bottom" title="Quay lại danh sách đánh giá">
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
                    <h5 class="card-header">Thông Tin Đánh Giá</h5>
                    <form action="{{route('user.productreview.update', $review->id)}}" method="POST">
                        @csrf
                        @method('PATCH')

                        <!-- Người đánh giá -->
                        <div class="form-group mb-3">
                            <label for="name" class="col-form-label">Người đánh giá:</label>
                            <input type="text" disabled class="form-control" value="{{$review->user_info->name}}">
                        </div>

                        <!-- Đánh giá -->
                        <div class="form-group mb-3">
                            <label for="review" class="col-form-label">Đánh giá:</label>
                            <textarea name="review" id="" cols="20" rows="5" class="form-control">{{$review->review}}</textarea>
                        </div>

                        <!-- Trạng thái -->
                        <div class="form-group mb-3">
                            <label for="status" class="col-form-label">Trạng Thái:</label>
                            <select name="status" class="form-control">
                                <option value="">--Chọn Trạng Thái--</option>
                                <option value="active" {{(($review->status=='active')? 'selected' : '')}}>Kích hoạt</option>
                                <option value="inactive" {{(($review->status=='inactive')? 'selected' : '')}}>Không kích hoạt</option>
                            </select>
                        </div>

                        <!-- Nút submit -->
                        <div class="form-group mb-3 d-flex justify-content-center">
                            <button type="submit" class="btn btn-success mx-2">Cập nhật</button>
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
