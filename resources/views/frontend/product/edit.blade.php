@extends('frontend.layout.master')
@section('title','Edit product')

@section('menu_left')
@include('frontend.account._sidebar')
@endsection

@section('content')
<div class="features_items">
    <h2 class="title text-center">Edit product!</h2>

    @if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $e)
            <li>{{ $e }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('account.update-product', $product->id) }}"
        method="POST"
        enctype="multipart/form-data"
        class="col-sm-8">
        @csrf

        <input class="form-control mb-2" type="text" name="name"
            placeholder="Name"
            value="{{ old('name', $product->name) }}">
        @error('name') <small class="text-danger">{{ $message }}</small>@enderror

        <input class="form-control mb-2" type="number" step="0.01" name="price"
            placeholder="Price"
            value="{{ old('price', $product->price) }}">
        @error('price') <small class="text-danger">{{ $message }}</small>@enderror

        <select class="form-control mb-2" name="id_category">
            <option value="">Please choose category</option>
            @foreach($categories as $c)
            <option value="{{ $c->id }}"
                @selected(old('id_category', $product->id_category) == $c->id)>
                {{ $c->name }}
            </option>
            @endforeach
        </select>
        @error('id_category') <small class="text-danger">{{ $message }}</small>@enderror

        <select class="form-control mb-2" name="id_brand">
            <option value="">Please choose brand</option>
            @foreach($brands as $b)
            <option value="{{ $b->id }}"
                @selected(old('id_brand', $product->id_brand) == $b->id)>
                {{ $b->name }}
            </option>
            @endforeach
        </select>
        @error('id_brand') <small class="text-danger">{{ $message }}</small>@enderror

        <select class="form-control mb-2" name="status" id="statusSelect">
            <option value="0" @selected(old('status',$product->status)=='0')>New</option>
            <option value="1" @selected(old('status',$product->status)=='1')>Sale</option>
        </select>
        @error('status') <small class="text-danger">{{ $message }}</small>@enderror

        <div id="saleBox" class="mb-2" style="display:none;">
            <input id="saleInput" class="form-control"
                type="number" name="sale"
                placeholder="Sale %" min="1" max="99"
                value="{{ old('sale', $product->sale) }}">
            @error('sale') <small class="text-danger">{{ $message }}</small>@enderror
        </div>

        <label>Company profile</label>
        <input class="form-control mb-2" type="text" name="company"
            value="{{ old('company', $product->company) }}">

        <label>Current images</label>
        <div class="row mb-3">
            @php
            $oldImages = $product->images ?? [];
            @endphp

            @if(count($oldImages) > 0)
            @foreach($oldImages as $idx => $img)
            <div class="col-xs-4 col-sm-3 text-center mb-2">

                <img src="{{ asset('upload/products/' . auth()->id() . '/85x84_' . $img) }}"
                    class="img-thumbnail mb-1"
                    width="80"
                    height="80">

                <div class="form-check">
                    <input class="form-check-input"
                        type="checkbox"
                        name="remove_images[]"
                        id="remove_{{ $idx }}"
                        value="{{ $img }}">

                    <label class="form-check-label"
                        for="remove_{{ $idx }}">
                        Xoá
                    </label>
                </div>

            </div>
            @endforeach

            @else
            <p class="text-muted">Chưa có hình nào.</p>
            @endif
        </div>

        <label>Upload new images (max 3, mỗi hình &lt; 1MB)</label>
        <input class="form-control mb-2"
            type="file"
            id="imagesInput"
            name="images[]"
            accept="image/*"
            multiple>
        <small id="selectedCount" class="text-info mb-2 d-block"></small>

        @error('images') <small class="text-danger d-block">{{ $message }}</small>@enderror
        @error('images.*') <small class="text-danger d-block">{{ $message }}</small>@enderror

        <label>Detail</label>
        <textarea class="form-control mb-3" name="detail" rows="5">
        {{ old('detail', $product->detail) }}</textarea>

        <button class="btn btn-primary">Save</button>
    </form>
</div>

<script>
    const statusSelect = document.getElementById('statusSelect');
    const saleBox = document.getElementById('saleBox');
    const saleInput = document.getElementById('saleInput');

    function toggleSale() {
        if (statusSelect.value === '1') {
            saleBox.style.display = 'block';
            saleInput.disabled = false;
        } else {
            saleBox.style.display = 'none';
            saleInput.disabled = true;
            saleInput.value = 0;
        }
    }
    toggleSale();
    statusSelect.addEventListener('change', toggleSale);


    const input = document.getElementById('imagesInput');
    const counter = document.getElementById('selectedCount');

    input.addEventListener('change', () => {
        const files = Array.from(input.files || []);

        if (files.length > 3) {
            alert('Chỉ được chọn tối đa 3 hình mới!');
            input.value = '';
            counter.textContent = '';
            return;
        }

        counter.textContent = files.length ?
            `Đã chọn ${files.length} hình mới.` :
            '';
    });
</script>
@endsection