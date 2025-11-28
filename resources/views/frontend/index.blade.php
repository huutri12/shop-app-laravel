@extends('frontend.layout.master')

@section('title', 'Trang chủ | E-Shopper')

@section('content')
<section id="slider">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div id="slider-carousel" class="carousel slide" data-ride="carousel">
                    <ol class="carousel-indicators">
                        <li data-target="#slider-carousel" data-slide-to="0" class="active"></li>
                        <li data-target="#slider-carousel" data-slide-to="1"></li>
                        <li data-target="#slider-carousel" data-slide-to="2"></li>
                    </ol>

                    <div class="carousel-inner">
                        <div class="item active">
                            <div class="col-sm-6">
                                <h1><span>E</span>-SHOPPER</h1>
                                <h2>Miễn phí & hiện đại</h2>
                                <p>Mẫu giao diện thương mại điện tử phong cách, dễ sử dụng!</p>
                                <a href="{{ route('blog.index') }}" class="btn btn-default get">Xem blog</a>
                            </div>
                            <div class="col-sm-6">
                                <img src="{{ asset('frontend/images/home/girl1.jpg') }}" class="girl img-responsive" alt="">
                                <img src="{{ asset('frontend/images/home/pricing.png') }}" class="pricing" alt="">
                            </div>
                        </div>

                        <div class="item">
                            <div class="col-sm-6">
                                <h1><span>E</span>-SHOPPER</h1>
                                <h2>Responsive Design</h2>
                                <p>Hiển thị tốt trên mọi thiết bị từ mobile đến desktop.</p>
                                <a href="#" class="btn btn-default get">Khám phá ngay</a>
                            </div>
                            <div class="col-sm-6">
                                <img src="{{ asset('frontend/images/home/girl2.jpg') }}" class="girl img-responsive" alt="">
                                <img src="{{ asset('frontend/images/home/pricing.png') }}" class="pricing" alt="">
                            </div>
                        </div>

                        <div class="item">
                            <div class="col-sm-6">
                                <h1><span>E</span>-SHOPPER</h1>
                                <h2>Khuyến mãi hấp dẫn</h2>
                                <p>Ưu đãi lớn cho khách hàng đăng ký mới hôm nay!</p>
                                <a href="{{ route('member.register') }}" class="btn btn-default get">Đăng ký ngay</a>
                            </div>
                            <div class="col-sm-6">
                                <img src="{{ asset('frontend/images/home/girl3.jpg') }}" class="girl img-responsive" alt="">
                                <img src="{{ asset('frontend/images/home/pricing.png') }}" class="pricing" alt="">
                            </div>
                        </div>
                    </div>

                    <a href="#slider-carousel" class="left control-carousel hidden-xs" data-slide="prev">
                        <i class="fa fa-angle-left"></i>
                    </a>
                    <a href="#slider-carousel" class="right control-carousel hidden-xs" data-slide="next">
                        <i class="fa fa-angle-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<section>
    <div class="container">
        <div class="row">
            <div class="col-sm-3">
                @include('frontend.layout.menu_left')
            </div>

            <div class="col-sm-9 padding-right">
                {{-- SẢN PHẨM MỚI NHẤT --}}
                <div class="features_items">
                    <h2 class="title text-center">Sản phẩm mới nhất</h2>

                    @forelse($latestProducts as $p)
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

                                    <a href="#" class="btn btn-default add-to-cart" data-id="{{ $p->id }}">
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
                </div>

                {{-- BÀI VIẾT MỚI NHẤT --}}
                <div class="recommended_items">
                    <h2 class="title text-center">Bài viết mới nhất</h2>

                    <div id="recommended-item-carousel" class="carousel slide" data-ride="carousel">
                        <div class="carousel-inner">
                            @if(isset($latestPosts) && count($latestPosts))
                            @foreach($latestPosts->chunk(3) as $chunkIndex => $chunk)
                            <div class="item {{ $chunkIndex === 0 ? 'active' : '' }}">
                                @foreach($chunk as $post)
                                <div class="col-sm-4">
                                    <div class="product-image-wrapper">
                                        <div class="single-products">
                                            <div class="productinfo text-center">
                                                @if(!empty($post->image))
                                                <img src="{{ asset('upload/blog/'.$post->image) }}" alt="{{ $post->title }}">
                                                @else
                                                <img src="{{ asset('frontend/images/blog/blog-one.jpg') }}" alt="{{ $post->title }}">
                                                @endif

                                                <h2>{{ $post->title }}</h2>
                                                <p>{{ \Illuminate\Support\Str::limit($post->description ?? $post->content ?? '', 60) }}</p>

                                                <a href="{{ route('blog.show', ['id' => $post->id]) }}"
                                                    class="btn btn-default add-to-cart">
                                                    <i class="fa fa-eye"></i> Đọc thêm
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            @endforeach
                            @else
                            <div class="item active">
                                <p class="text-center">Chưa có bài viết nào.</p>
                            </div>
                            @endif
                        </div>

                        @if(isset($latestPosts) && count($latestPosts) > 3)
                        <a class="left recommended-item-control" href="#recommended-item-carousel" data-slide="prev">
                            <i class="fa fa-angle-left"></i>
                        </a>
                        <a class="right recommended-item-control" href="#recommended-item-carousel" data-slide="next">
                            <i class="fa fa-angle-right"></i>
                        </a>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>
@endsection