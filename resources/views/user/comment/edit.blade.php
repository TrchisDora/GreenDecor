@extends('user.layouts.master')

@section('title','Edit Comment')

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
                    <h6 class="m-0">Sửa Bình Luận</h6>
                    <a href="{{ route('user.post-comment.index') }}" class="btn btn-primary btn-sm float-right" data-toggle="tooltip"
                        data-placement="bottom" title="Quay lại danh sách bình luận">
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
                    <h5 class="card-header">Thông Tin Bình Luận</h5>
                    <form action="{{route('user.post-comment.update', $comment->id)}}" method="POST">
                        @csrf
                        @method('PATCH')

                        <!-- Người bình luận -->
                        <div class="form-group mb-3">
                            <label for="name" class="col-form-label">Người bình luận:</label>
                            <input type="text" disabled class="form-control" value="{{$comment->user_info->name}}">
                        </div>

                        <!-- Bình luận -->
                        <div class="form-group mb-3">
                            <label for="comment" class="col-form-label">Bình luận:</label>
                            <textarea name="comment" id="" cols="20" rows="5" class="form-control">{{$comment->comment}}</textarea>
                        </div>

                        <!-- Trạng thái -->
                        <div class="form-group mb-3">
                            <label for="status" class="col-form-label">Trạng Thái:</label>
                            <select name="status" class="form-control">
                                <option value="">--Chọn Trạng Thái--</option>
                                <option value="active" {{(($comment->status=='active')? 'selected' : '')}}>Kích hoạt</option>
                                <option value="inactive" {{(($comment->status=='inactive')? 'selected' : '')}}>Không kích hoạt</option>
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
