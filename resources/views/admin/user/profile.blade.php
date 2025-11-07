@extends('admin.layout.master')

@section('breadcrumb')
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-5 align-self-center">
            <h4 class="page-title">Profile</h4>
        </div>
        <div class="col-7 align-self-center">
            <div class="d-flex align-items-center justify-content-end">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ url('/admin/dashboard') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Profile</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="container-fluid">

    <div class="row">
        <!-- LEFT -->
        <div class="col-lg-4 col-xlg-3 col-md-5">
            <div class="card">
                <div class="card-body">
                    <center class="m-t-30">
                        <img
                            src="{{ $user->avatar ? asset('upload/user/avatar/'.$user->avatar) : asset('admin/assets/images/users/5.jpg') }}"
                            class="rounded-circle" width="150" alt="user">
                        <h4 class="card-title m-t-10">{{ $user->name }}</h4>
                        <h6 class="card-subtitle">{{ $user->role ?? 'Administrator' }}</h6>
                        <div class="row text-center justify-content-md-center">
                            <div class="col-4"><a href="javascript:void(0)" class="link"><i class="icon-people"></i>
                                    <span class="font-medium">—</span></a></div>
                            <div class="col-4"><a href="javascript:void(0)" class="link"><i class="icon-picture"></i>
                                    <span class="font-medium">—</span></a></div>
                        </div>
                    </center>
                </div>
                <div>
                    <hr>
                </div>
                <div class="card-body">
                    <small class="text-muted">Email address</small>
                    <h6>{{ $user->email }}</h6>

                    <small class="text-muted p-t-30 db">Phone</small>
                    <h6>{{ $user->phone ?? 'Chưa cập nhật' }}</h6>

                    <small class="text-muted p-t-30 db">Address</small>
                    <h6>{{ $user->address ?? 'Chưa cập nhật' }}</h6>

                    <small class="text-muted p-t-30 db">Country</small>
                    <h6>
                        @php
                        $country = collect($countries ?? [])->firstWhere('id', $user->id_country);
                        @endphp
                        {{ $country->name ?? 'Chưa chọn' }}
                    </h6>
                </div>
            </div>
        </div>

        <!-- RIGHT -->
        <div class="col-lg-8 col-xlg-9 col-md-7">
            <div class="card">
                <div class="card-body">
                    <form class="form-horizontal form-material"
                        action="{{ route('admin.profile.update') }}"
                        method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group">
                            <label class="col-md-12">Full Name *</label>
                            <div class="col-md-12">
                                <input type="text" name="name"
                                    value="{{ old('name', $user->name) }}"
                                    class="form-control form-control-line">
                                @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-12">Email (không đổi)</label>
                            <div class="col-md-12">
                                <input type="email" name="email"
                                    value="{{ $user->email }}"
                                    class="form-control form-control-line" readonly>
                                @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-12">Password (để trống nếu không đổi)</label>
                            <div class="col-md-12">
                                <input type="password" name="password"
                                    class="form-control form-control-line" autocomplete="new-password">
                                @error('password') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-12">Phone</label>
                            <div class="col-md-12">
                                <input type="text" name="phone"
                                    value="{{ old('phone', $user->phone) }}"
                                    class="form-control form-control-line">
                                @error('phone') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-12">Address</label>
                            <div class="col-md-12">
                                <input type="text" name="address"
                                    value="{{ old('address', $user->address) }}"
                                    class="form-control form-control-line">
                                @error('address') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-12">Select Country</label>
                            <div class="col-sm-12">
                                <select name="id_country" class="form-control form-control-line">
                                    <option value="">-- Chọn quốc gia --</option>
                                    @foreach($countries as $c)
                                    <option value="{{ $c->id }}"
                                        @selected(old('id_country', $user->id_country) == $c->id)>
                                        {{ $c->name }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('id_country') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-12">Avatar (<=1MB, jpg/png/gif)</label>
                                    <div class="col-md-12">
                                        <input type="file" name="avatar" class="form-control form-control-line" accept="image/*">
                                        @error('avatar') <small class="text-danger">{{ $message }}</small> @enderror

                                        @if($user->avatar)
                                        <div class="mt-2">
                                            <img src="{{ asset('upload/user/avatar/'.$user->avatar) }}" width="100" class="rounded">
                                        </div>
                                        @endif
                                    </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-12">
                                <button class="btn btn-success" type="submit">Update Profile</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- /RIGHT -->
    </div>
</div>
@endsection