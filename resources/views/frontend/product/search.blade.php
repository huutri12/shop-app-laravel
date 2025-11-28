@extends('frontend.layout.master')

@section('title', 'Search Result')

@section('content')

<div class="container">

    <h2>Kết quả tìm kiếm cho: <strong>{{ $keyword }}</strong></h2>

    @if($products->count() == 0)
    <p>Không tìm thấy sản phẩm nào.</p>
    @endif

    <div class="row">
        @foreach($products as $product)
        @php
        $imgs = $product->images ?? json_decode($product->image, true) ?? [];
        $thumb = $imgs[0] ?? null;
        @endphp

        <div class="col-sm-4">
            <div class="product-image-wrapper">
                <div class="single-products">
                    <div class="productinfo text-center">

                        <a href="{{ route('product.detail', $product->id) }}">
                            @if($thumb)
                            <img src="{{ asset('upload/products/'.$product->id_user.'/329x380_'.$thumb) }}"
                                width="300"
                                alt="{{ $product->name }}">
                            @else
                            <img src="{{ asset('frontend/images/no-image.png') }}"
                                width="300"
                                alt="No image">
                            @endif
                        </a>

                        <h2>{{ number_format($product->price, 0, ',', '.') }} đ</h2>
                        <p>{{ $product->name }}</p>
                        <a href="{{ route('product.detail', $product->id) }}"
                            class="btn btn-default add-to-cart">
                            Xem chi tiết
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>


</div>

@endsection