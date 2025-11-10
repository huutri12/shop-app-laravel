@extends('frontend.layout.master')
@section('title','Create product')

@section('menu_left')
  @include('frontend.account._sidebar')
@endsection

@section('content')
  <h3>Create product!</h3>

  <form action="{{ route('account.add-product.post') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <input class="form-control mb-2" type="text" name="name" placeholder="Name" value="{{ old('name') }}">
    @error('name') <small class="text-danger">{{ $message }}</small>@enderror

    <input class="form-control mb-2" type="number" step="0.01" name="price" placeholder="Price" value="{{ old('price') }}">
    @error('price') <small class="text-danger">{{ $message }}</small>@enderror

    <select class="form-control mb-2" name="id_category">
      <option value="">Please choose category</option>
      @foreach($categories as $c)
        <option value="{{ $c->id }}" @selected(old('id_category')==$c->id)>{{ $c->name }}</option>
      @endforeach
    </select>
    @error('id_category') <small class="text-danger">{{ $message }}</small>@enderror

    <select class="form-control mb-2" name="id_brand">
      <option value="">Please choose brand</option>
      @foreach($brands as $b)
        <option value="{{ $b->id }}" @selected(old('id_brand')==$b->id)>{{ $b->name }}</option>
      @endforeach
    </select>
    @error('id_brand') <small class="text-danger">{{ $message }}</small>@enderror

    <select class="form-control mb-2" name="status" id="statusSelect">
      <option value="0" @selected(old('status')==='0')>New</option>
      <option value="1" @selected(old('status')==='1')>Sale</option>
    </select>
    @error('status') <small class="text-danger">{{ $message }}</small>@enderror

    <div id="saleBox" style="display:none">
      <input class="form-control mb-2" type="number" name="sale" placeholder="Sale %" min="1" max="99" value="{{ old('sale', 0) }}">
      @error('sale') <small class="text-danger">{{ $message }}</small>@enderror
    </div>

    <label>Company profile</label>
    <input class="form-control mb-2" type="text" name="company" value="{{ old('company') }}">

    <label>Images (max 3, < 1MB each)</label>
    <input class="form-control mb-2" type="file" name="images[]" accept="image/*" multiple>
    @error('images.*') <small class="text-danger d-block">{{ $message }}</small>@enderror

    <label>Detail</label>
    <textarea class="form-control mb-2" name="detail" rows="6">{{ old('detail') }}</textarea>

    <button class="btn btn-primary">Save</button>
  </form>

  <script>
    const sel = document.getElementById('statusSelect');
    const box = document.getElementById('saleBox');
    function toggleSale(){ box.style.display = sel.value === '1' ? 'block':'none'; }
    toggleSale();
    sel.addEventListener('change', toggleSale);
  </script>
@endsection
