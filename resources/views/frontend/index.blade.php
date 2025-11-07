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
                <div class="features_items">
                    <h2 class="title text-center">Sản phẩm nổi bật</h2>

                    {{-- Danh sách sản phẩm mẫu cố định --}}
                    @for ($i = 1; $i <= 6; $i++)
                        <div class="col-sm-4">
                        <div class="product-image-wrapper">
                            <div class="single-products">
                                <div class="productinfo text-center">
                                    <img src="{{ asset('frontend/images/home/product'.$i.'.jpg') }}" alt="Product {{ $i }}">
                                    <h2>{{ number_format(299000 + $i*10000, 0, ',', '.') }} đ</h2>
                                    <p>Sản phẩm demo {{ $i }}</p>
                                    <a href="#" class="btn btn-default add-to-cart">
                                        <i class="fa fa-shopping-cart"></i> Thêm vào giỏ
                                    </a>
                                </div>
                            </div>
                        </div>
                </div>
                @endfor
            </div>

            <div class="recommended_items">
                <h2 class="title text-center">Bài viết mới nhất</h2>

                <div id="recommended-item-carousel" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                        <div class="item active">
                            <div class="col-sm-4">
                                <div class="product-image-wrapper">
                                    <div class="single-products">
                                        <div class="productinfo text-center">
                                            <img src="{{ asset('frontend/images/blog/blog-one.jpg') }}" alt="">
                                            <h2>Tin bóng đá</h2>
                                            <p>Cập nhật các tin thể thao nóng hổi.</p>
                                            <a href="{{ route('blog.index') }}" class="btn btn-default add-to-cart">
                                                <i class="fa fa-eye"></i> Đọc thêm
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="product-image-wrapper">
                                    <div class="single-products">
                                        <div class="productinfo text-center">
                                            <img src="{{ asset('frontend/images/blog/blog-two.jpg') }}" alt="">
                                            <h2>Thời trang nữ</h2>
                                            <p>Xu hướng thời trang mới nhất 2025.</p>
                                            <a href="{{ route('blog.index') }}" class="btn btn-default add-to-cart">
                                                <i class="fa fa-eye"></i> Đọc thêm
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="product-image-wrapper">
                                    <div class="single-products">
                                        <div class="productinfo text-center">
                                            <img src="{{ asset('frontend/images/blog/blog-three.jpg') }}" alt="">
                                            <h2>Công nghệ mới</h2>
                                            <p>Khám phá sản phẩm công nghệ nổi bật.</p>
                                            <a href="{{ route('blog.index') }}" class="btn btn-default add-to-cart">
                                                <i class="fa fa-eye"></i> Đọc thêm
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    </div>
</section>
@endsection