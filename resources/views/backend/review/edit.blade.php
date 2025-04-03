@extends('backend.layouts.master')

@section('title','Review Edit')

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
                    <h6 class="m-0">Chỉnh Sửa Đánh Giá</h6>
                    <a href="{{ route('review.index') }}" class="btn btn-danger btn-sm float-right" data-toggle="tooltip"
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
                    <form action="{{ route('review.update', $review->id) }}" method="POST">
                        @csrf
                        @method('PATCH')

                        <!-- Người đánh giá -->
                        <div class="form-group mb-3">
                            <label for="name">Người đánh giá:</label>
                            <input type="text" disabled class="form-control" value="{{ $review->user_info->name }}">
                        </div>

                        <!-- Đánh giá -->
                        <div class="form-group mb-3">
                            <label for="review">Nội dung đánh giá</label>
                            <textarea name="review" disabled id="" cols="20" rows="10" class="form-control">{{ $review->review }}</textarea>
                        </div>

                        <!-- Trạng thái -->
                        <div class="form-group mb-3">
                            <label for="status">Trạng thái:</label>
                            <select name="status" id="" class="form-control">
                                <option value="">--Chọn trạng thái--</option>
                                <option value="active" {{ $review->status == 'active' ? 'selected' : '' }}>Kích hoạt</option>
                                <option value="inactive" {{ $review->status == 'inactive' ? 'selected' : '' }}>Không kích hoạt</option>
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
<style>
    .order-info,.shipping-info{
        background:#ECECEC;
        padding:20px;
    }
    .order-info h4,.shipping-info h4{
        text-decoration: underline;
    }
</style>
@endpush