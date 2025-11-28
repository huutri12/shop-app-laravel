@extends('frontend.layout.master')

@section('title', $product->name . ' | E-Shopper')

@section('content')
<section>
    <div class="container">
        <div class="row">
            <div class="col-sm-3">
                @include('frontend.layout.menu_left')
            </div>
            <div class="col-sm-9 padding-right">
                <div class="product-details">
                    <div class="col-sm-5">
                        <div class="view-product">
                            @php
                            $first = $images[0] ?? null;
                            $userId = $product->id_user;
                            $big = $first ? asset("upload/products/$userId/329x380_$first") : asset('frontend/images/no-image.png');
                            $full = $first ? asset("upload/products/$userId/$first") : asset('frontend/images/no-image.png');
                            @endphp

                            <a id="mainImageLink" href="{{ $full }}" rel="prettyPhoto[product]">
                                <img id="mainImageImg" src="{{ $big }}" alt="{{ $product->name }}">
                            </a>
                            <h3 class="text-center" style="margin-top:10px">ZOOM</h3>
                        </div>
                        @if(count($images))
                        <div id="similar-product" class="carousel slide" data-ride="carousel">
                            <div class="carousel-inner">
                                <div class="item active">
                                    @foreach($images as $img)
                                    <a href="javascript:void(0);">
                                        <img class="thumb-img"
                                            src="{{ asset("upload/products/$userId/85x84_$img") }}"
                                            data-big="{{ asset("upload/products/$userId/329x380_$img") }}"
                                            data-full="{{ asset("upload/products/$userId/$img") }}"
                                            alt="">
                                    </a>
                                    @endforeach
                                </div>
                            </div>
                            <a class="left item-control" href="#similar-product" data-slide="prev">
                                <i class="fa fa-angle-left"></i>
                            </a>
                            <a class="right item-control" href="#similar-product" data-slide="next">
                                <i class="fa fa-angle-right"></i>
                            </a>
                        </div>
                        @endif
                    </div>

                    <div class="col-sm-7">
                        <div class="product-information"><!--/product-information-->
                            @if($product->status == 0)
                            <img src="{{ asset('frontend/images/product-details/new.jpg') }}"
                                class="newarrival" alt="">
                            @else
                            <img src="{{ asset('frontend/images/product-details/sale.png') }}"
                                class="newarrival" alt="">
                            @endif

                            <h2>{{ $product->name }}</h2>
                            <p>Web ID: {{ $product->id }}</p>
                            <img src="{{ asset('frontend/images/product-details/rating.png') }}" alt="">

                            <span>
                                <span>{{ number_format($product->price, 0, ',', '.') }} $</span>
                                <label>Quantity:</label>
                                <input type="number" value="1" min="1">
                                <button type="button"
                                    class="btn btn-fefault cart add-to-cart"
                                    data-id="{{ $product->id }}">
                                    <i class="fa fa-shopping-cart"></i>
                                    Add to cart
                                </button>
                            </span>

                            <p><b>Availability:</b> In stock</p>
                            <p><b>Condition:</b> {{ $product->status == 0 ? 'New' : 'Sale' }}</p>
                            <p><b>Brand:</b> {{ optional($product->brand)->name }}</p>
                            <p><b>Company:</b> {{ $product->company }}</p>

                            <a href="#">
                                <img src="{{ asset('frontend/images/product-details/share.png') }}"
                                    class="share img-responsive" alt="">
                            </a>
                        </div>
                    </div>
                </div><!--/product-details-->

                <div class="category-tab shop-details-tab"><!--category-tab-->
                    <div class="col-sm-12">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#details" data-toggle="tab">Details</a></li>
                            <li><a href="#companyprofile" data-toggle="tab">Company Profile</a></li>
                            <li><a href="#reviews" data-toggle="tab">Reviews (0)</a></li>
                        </ul>
                    </div>

                    <div class="tab-content">
                        <div class="tab-pane fade active in" id="details">
                            <div class="col-sm-12">
                                {!! nl2br(e($product->detail)) !!}
                            </div>
                        </div>

                        <div class="tab-pane fade" id="companyprofile">
                            <div class="col-sm-12">
                                {{ $product->company }}
                            </div>
                        </div>

                        <div class="tab-pane fade" id="reviews">
                            <div class="col-sm-12">
                                <p>Chưa có review. Bạn có thể tự làm form review sau.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <

                    <div class="recommended_items"><!--recommended_items-->
                    <h2 class="title text-center">Sản phẩm gợi ý</h2>

                    <div id="recommended-item-carousel" class="carousel slide" data-ride="carousel">
                        <div class="carousel-inner">
                            <div class="item active">
                                @foreach($recommended as $r)
                                @php
                                $imgsR = $r->images ?? [];
                                $thumbR = $imgsR[0] ?? null;
                                @endphp
                                <div class="col-sm-4">
                                    <div class="product-image-wrapper">
                                        <div class="single-products">
                                            <div class="productinfo text-center">
                                                <a href="{{ route('product.detail',$r->id) }}">
                                                    @if($thumbR)
                                                    <img src="{{ asset("upload/products/{$r->id_user}/329x380_$thumbR") }}"
                                                        alt="{{ $r->name }}">
                                                    @else
                                                    <img src="{{ asset('frontend/images/no-image.png') }}" alt="">
                                                    @endif
                                                </a>
                                                <h2>{{ number_format($r->price,0,',','.') }} VND</h2>
                                                <p>{{ \Illuminate\Support\Str::limit($r->name, 40) }}</p>
                                                <a href="{{ route('product.detail',$r->id) }}"
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
                    </div>
            </div><!--/recommended_items-->

        </div>
    </div>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const mainImg = document.getElementById('mainImageImg');
        const mainLink = document.getElementById('mainImageLink');

        document.querySelectorAll('.thumb-img').forEach(function(thumb) {
            thumb.addEventListener('click', function() {
                const big = this.getAttribute('data-big');
                const full = this.getAttribute('data-full');

                mainImg.src = big;
                mainLink.href = full;
            });
        });

        if (typeof jQuery !== 'undefined' && typeof jQuery.prettyPhoto !== 'undefined') {
            jQuery(function($) {
                $("a[rel^='prettyPhoto']").prettyPhoto();
            });
        }
    });
</script>
@endsection