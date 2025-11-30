@extends('admin.layout.master')

@section('content')
<div class="pagetitle">
    <h1>Edit Product</h1>
</div>

@if($errors->any())
<div class="alert alert-danger">
    <ul class="mb-0">
        @foreach($errors->all() as $err)
        <li>{{ $err }}</li>
        @endforeach
    </ul>
</div>
@endif

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card">
    <div class="card-body">
        <h5 class="card-title">Thông tin sản phẩm</h5>

        <form action="{{ route('admin.products.update', $product->id) }}"
            method="POST">
            @csrf

            <div class="row mb-3">
                <label class="col-sm-2 col-form-label">Tên sản phẩm</label>
                <div class="col-sm-10">
                    <input type="text" name="name"
                        class="form-control @error('name') is-invalid @enderror"
                        value="{{ old('name', $product->name) }}">
                    @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-2 col-form-label">Giá</label>
                <div class="col-sm-4">
                    <input type="number" step="0.01" name="price"
                        class="form-control @error('price') is-invalid @enderror"
                        value="{{ old('price', $product->price) }}">
                    @error('price')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <label class="col-sm-2 col-form-label">Status</label>
                <div class="col-sm-4">
                    <select name="status"
                        class="form-control @error('status') is-invalid @enderror">
                        <option value="0" {{ old('status', $product->status) == 0 ? 'selected' : '' }}>New</option>
                        <option value="1" {{ old('status', $product->status) == 1 ? 'selected' : '' }}>Sale</option>
                    </select>
                    @error('status')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-2 col-form-label">Category</label>
                <div class="col-sm-4">
                    <select name="category_id"
                        class="form-control @error('category_id') is-invalid @enderror">
                        <option value="">-- Không chọn --</option>
                        @foreach($categories as $cat)
                        <option value="{{ $cat->id }}"
                            {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                        @endforeach
                    </select>
                    @error('category_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <label class="col-sm-2 col-form-label">Brand</label>
                <div class="col-sm-4">
                    <select name="brand_id"
                        class="form-control @error('brand_id') is-invalid @enderror">
                        <option value="">-- Không chọn --</option>
                        @foreach($brands as $brand)
                        <option value="{{ $brand->id }}"
                            {{ old('brand_id', $product->brand_id) == $brand->id ? 'selected' : '' }}>
                            {{ $brand->name }}
                        </option>
                        @endforeach
                    </select>
                    @error('brand_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-2 col-form-label">Company</label>
                <div class="col-sm-10">
                    <input type="text" name="company"
                        class="form-control @error('company') is-invalid @enderror"
                        value="{{ old('company', $product->company) }}">
                    @error('company')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-2 col-form-label">Mô tả chi tiết</label>
                <div class="col-sm-10">
                    <textarea name="detail" rows="5"
                        class="form-control @error('detail') is-invalid @enderror">{{ old('detail', $product->detail) }}</textarea>
                    @error('detail')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- chỉ hiển thị cho admin xem member nào tạo --}}
            <div class="row mb-3">
                <label class="col-sm-2 col-form-label">Owner (Member)</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" disabled
                        value="{{ $product->user->name ?? 'Không rõ' }}">
                </div>
            </div>

            <div class="text-end">
                <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
                    Quay lại
                </a>
                <button type="submit" class="btn btn-primary">
                    Lưu thay đổi
                </button>
            </div>
        </form>

    </div>
</div>
@endsection