
@extends('admin.layout.master')

@section('title', 'Edit User')

@section('content')
<div class="container-fluid">
    <h1 class="mb-4">Sửa User #{{ $user->id }}</h1>

    <div class="card">
        <div class="card-header">
            <strong>Thông tin user</strong>
        </div>

        <div class="card-body">
            <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="name" class="form-label">Tên</label>
                    <input type="text"
                           name="name"
                           id="name"
                           class="form-control @error('name') is-invalid @enderror"
                           value="{{ old('name', $user->name) }}"
                           required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email"
                           name="email"
                           id="email"
                           class="form-control @error('email') is-invalid @enderror"
                           value="{{ old('email', $user->email) }}"
                           required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="level" class="form-label">Level</label>
                    <select name="level"
                            id="level"
                            class="form-control @error('level') is-invalid @enderror">
                        <option value="0"
                            {{ old('level', $user->level) == 0 ? 'selected' : '' }}>
                            Member
                        </option>
                        <option value="1"
                            {{ old('level', $user->level) == 1 ? 'selected' : '' }}>
                            Admin
                        </option>
                    </select>
                    @error('level')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">
                        Mật khẩu mới (bỏ trống nếu không đổi)
                    </label>
                    <input type="password"
                           name="password"
                           id="password"
                           class="form-control @error('password') is-invalid @enderror">
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">
                    Lưu thay đổi
                </button>
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                    Quay lại
                </a>
            </form>
        </div>
    </div>
</div>
@endsection
