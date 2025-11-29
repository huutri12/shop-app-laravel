@extends('frontend.layout.master')

@section('title', 'Products | E-Shopper')

@section('content')
<section>
    <div class="container">
        <div class="row">
            <div class="col-sm-3">
                @include('frontend.layout.menu_left')
            </div>

            <div class="col-sm-9 padding-right">
                <div class="features_items">
                    <h2 class="title text-center">Products</h2>

                    {{-- FORM SEARCH ADVANCED --}}
                    <form action="{{ route('search.advanced') }}" method="GET" class="row mb-3" style="margin-bottom:20px;">
                        <div class="col-sm-3">
                            <input type="text" name="name" class="form-control"
                                placeholder="Name"
                                value="{{ request('name') }}">
                        </div>

                        <div class="col-sm-2">
                            <select name="price_range" class="form-control">
                                <option value="">Choose price</option>
                                <option value="0-100" {{ request('price_range')=='0-100' ? 'selected':'' }}>0 – 100</option>
                                <option value="100-200" {{ request('price_range')=='100-200' ? 'selected':'' }}>100 – 200</option>
                                <option value="200-500" {{ request('price_range')=='200-500' ? 'selected':'' }}>200 – 500</option>
                                <option value="500+" {{ request('price_range')=='500+' ? 'selected':'' }}>500+</option>
                            </select>
                        </div>

                        <div class="col-sm-2">
                            <select name="category_id" class="form-control">
                                <option value="">Category</option>
                                @foreach($categories as $cat)
                                <option value="{{ $cat->id }}"
                                    {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-sm-2">
                            <select name="brand_id" class="form-control">
                                <option value="">Brand</option>
                                @foreach($brands as $brand)
                                <option value="{{ $brand->id }}"
                                    {{ request('brand_id') == $brand->id ? 'selected' : '' }}>
                                    {{ $brand->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-sm-2">
                            <select name="status" class="form-control">
                                <option value="">Status</option>
                                <option value="0" {{ request('status')==='0' ? 'selected' : '' }}>New</option>
                                <option value="1" {{ request('status')==='1' ? 'selected' : '' }}>Sale</option>
                            </select>
                        </div>

                        <div class="col-sm-1">
                            <button class="btn btn-warning btn-block">Search</button>
                        </div>
                    </form>

                    {{-- DANH SÁCH SẢN PHẨM --}}
                    @forelse($products as $p)
                    @php
                    $imgs = $p->images ?? [];
                    $thumb = $imgs[0] ?? null;
                    @endphp

                    <div class="col-sm-4">
                        <div class="product-image-wrapper">
                            <div class="single-products">
                                <div class="productinfo text-center">
                                    <a href="{{ route('product.detail', $p->id) }}">
                                        @if($thumb)
                                        <img src="{{ asset('upload/products/'.$p->id_user.'/329x380_'.$thumb) }}"
                                            alt="{{ $p->name }}">
                                        @else
                                        <img src="{{ asset('frontend/images/no-image.png') }}" alt="No image">
                                        @endif
                                    </a>

                                    <h2>{{ number_format($p->price, 0, ',', '.') }} $</h2>
                                    <p>
                                        <a href="{{ route('product.detail', $p->id) }}">
                                            {{ $p->name }}
                                        </a>
                                    </p>

                                    <a href="#" class="btn btn-default add-to-cart"
                                        data-id="{{ $p->id }}">
                                        <i class="fa fa-shopping-cart"></i> Thêm vào giỏ
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <p class="text-center">Chưa có sản phẩm nào.</p>
                    @endforelse

                    <div class="clearfix"></div>

                    <div class="text-center">
                        {{ $products->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection