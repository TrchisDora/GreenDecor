@extends('backend.layouts.master')

@section('title', 'Admin Profile')

@section('main-content')
    <div class="container-fluid">
        <div class="row mb-3">
            <div class="col-md-12">
                @include('backend.layouts.notification')
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                        <h6 class="m-0">Cài đặt thông tin</h6>
                        <a href="#" class="btn btn btn-sm float-right" data-toggle="tooltip" data-placement="bottom"
                            title=""><i class="fas fa-star" style="color:#55AC49;"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow-sm">
                    <div class="card-body-table">
                        <h4 class="font-weight-bold">Thông Tin Cá Nhân</h4>
                        <ul class="breadcrumbs">
                            <li><a href="{{ route('admin') }}" style="color:#999">Dashboard</a></li>
                            <li><a href="" class="active text-primary">Trang Hồ Sơ</a></li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="card shadow-sm rounded-4 border-0 text-center p-3">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-center">
                                            @if($profile->photo)
                                                <img src="{{ $profile->photo }}" alt="profile picture"
                                                    class="rounded-circle shadow"
                                                    style="height: 250px; width: 250px; object-fit: cover;">
                                            @else
                                                <img src="{{ asset('backend/img/avatar.png') }}" alt="default profile picture"
                                                    class="rounded-circle shadow"
                                                    style="height: 250px; width: 250px; object-fit: cover;">
                                            @endif
                                        </div>

                                        <h5 class="mt-3 mb-2">
                                            <i class="fas fa-user me-1 text-primary"></i> {{ $profile->name }}
                                        </h5>
                                        <p class="mb-2">
                                            <i class="fas fa-envelope me-1 text-secondary"></i> {{ $profile->email }}
                                        </p>
                                        <p class="text-muted mb-0">
                                            <i class="fas fa-hammer me-1 text-warning"></i> {{ $profile->role }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <form class="border px-4 pt-2 pb-3" method="POST"
                                    action="{{ route('profile-update', $profile->id) }}">
                                    @csrf
                                    <div class="form-group">
                                        <label for="inputTitle" class="col-form-label">Tên</label>
                                        <input id="inputTitle" type="text" name="name" placeholder="Nhập tên"
                                            value="{{ $profile->name }}" class="form-control">
                                        @error('name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="inputEmail" class="col-form-label">Email</label>
                                        <input id="inputEmail" disabled type="email" name="email" placeholder="Nhập email"
                                            value="{{ $profile->email }}" class="form-control">
                                        @error('email')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="inputPhoto" class="col-form-label">Ảnh đại diện</label>
                                        <div class="input-group">
                                            <span class="input-group-btn">
                                                <a id="lfm" data-input="thumbnail" data-preview="holder"
                                                    class="btn btn-primary text-white">
                                                    <i class="fa fa-picture-o"></i> Chọn ảnh
                                                </a>
                                            </span>
                                            <input id="thumbnail" class="form-control" type="text" name="photo"
                                                value="{{ $profile->photo }}">
                                        </div>
                                        @error('photo')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="role" class="col-form-label">Vai trò</label>
                                        <select name="role" class="form-control">
                                            <option value="">----- Chọn Vai Trò -----</option>
                                            <option value="admin" {{ $profile->role == 'admin' ? 'selected' : '' }}>Quản trị
                                                viên</option>
                                            <option value="user" {{ $profile->role == 'user' ? 'selected' : '' }}>Người dùng
                                            </option>
                                        </select>
                                        @error('role')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <button type="submit" class="btn btn-success btn-sm">Cập nhật</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<style>
    .breadcrumbs {
        list-style: none;
    }

    .breadcrumbs li {
        float: left;
        margin-right: 10px;
    }

    .breadcrumbs li a:hover {
        text-decoration: none;
    }

    .breadcrumbs li .active {
        color: red;
    }

    .breadcrumbs li+li:before {
        content: "/\00a0";
    }

    .image {
        background: url('{{asset('backend/img/background.jpg')}}');
        height: 150px;
        background-position: center;
        background-attachment: cover;
        position: relative;
    }

    .image img {
        position: absolute;
        top: 55%;
        left: 35%;
        margin-top: 30%;
    }

    i {
        font-size: 14px;
        padding-right: 8px;
    }
</style>

@push('scripts')
    <script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
    <script>
        $('#lfm').filemanager('image');
    </script>
@endpush