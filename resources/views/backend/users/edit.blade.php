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
                    <h6 class="m-0">Chỉnh sửa Người dùng</h6>
                    <a href="{{ route('users.index') }}" class="btn btn-primary btn-sm float-right" data-toggle="tooltip"
                        data-placement="bottom" title="Quay lại danh sách người dùng">
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
                    <h5 class="card-header">Thông Tin Người Dùng</h5>
                    <form method="post" action="{{ route('users.update', $user->id) }}">
                        @csrf
                        @method('PATCH')

                        <!-- Tên -->
                        <div class="form-group mb-3">
                            <label for="inputTitle" class="col-form-label">Tên <span class="text-danger">*</span></label>
                            <input id="inputTitle" type="text" name="name" placeholder="Nhập tên" value="{{ $user->name }}" class="form-control">
                            @error('name')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="form-group mb-3">
                            <label for="inputEmail" class="col-form-label">Email <span class="text-danger">*</span></label>
                            <input id="inputEmail" type="email" name="email" placeholder="Nhập email" value="{{ $user->email }}" class="form-control">
                            @error('email')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Ảnh đại diện -->
                        <div class="form-group mb-3">
                            <label for="inputPhoto" class="col-form-label">Ảnh đại diện</label>
                            <div class="input-group">
                                <span class="input-group-btn">
                                    <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                                        <i class="fa fa-picture-o"></i> Chọn ảnh
                                    </a>
                                </span>
                                <input id="thumbnail" class="form-control" type="text" name="photo" value="{{ $user->photo }}">
                            </div>
                            <img id="holder" style="margin-top:15px;max-height:100px;">
                            @error('photo')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Quyền (Role) -->
                        @php 
                            $roles = DB::table('users')->select('role')->where('id', $user->id)->get();
                        @endphp
                        <div class="form-group mb-3">
                            <label for="role" class="col-form-label">Quyền <span class="text-danger">*</span></label>
                            <select name="role" class="form-control">
                                <option value="">-- Chọn quyền --</option>
                                @foreach($roles as $role)
                                    <option value="admin" {{ $role->role == 'admin' ? 'selected' : '' }}>Quản trị viên</option>
                                    <option value="user" {{ $role->role == 'user' ? 'selected' : '' }}>Người dùng</option>
                                @endforeach
                            </select>
                            @error('role')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Trạng thái -->
                        <div class="form-group mb-3">
                            <label for="status" class="col-form-label">Trạng thái <span class="text-danger">*</span></label>
                            <select name="status" class="form-control">
                                <option value="active" {{ $user->status == 'active' ? 'selected' : '' }}>Hoạt động</option>
                                <option value="inactive" {{ $user->status == 'inactive' ? 'selected' : '' }}>Không hoạt động</option>
                            </select>
                            @error('status')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Nút cập nhật -->
                        <div class="form-group mb-3 d-flex justify-content-center">
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

@push('scripts')
<script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
<script>
    $('#lfm').filemanager('image');
</script>
@endpush