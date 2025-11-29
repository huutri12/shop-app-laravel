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
                    <img src="{{ asset("upload/products/{$p->id_user}/329x380_{$thumb}") }}"
                        alt="{{ $p->name }}">
                    @else
                    <img src="{{ asset('frontend/images/no-image.png') }}" alt="No image">
                    @endif
                </a>

                <h2>{{ number_format($p->price, 0, ',', '.') }} $</h2>
                <p><a href="{{ route('product.detail',$p->id) }}">{{ $p->name }}</a></p>

                <a href="#" class="btn btn-default add-to-cart" data-id="{{ $p->id }}">
                    <i class="fa fa-shopping-cart"></i> Thêm vào giỏ
                </a>
            </div>
        </div>
    </div>
</div>
@empty
<p class="text-center">Không có sản phẩm trong khoảng giá này.</p>
@endforelse