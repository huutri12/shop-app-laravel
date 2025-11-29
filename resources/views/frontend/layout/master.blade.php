<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'E-Shopper')</title>

    <link href="{{ asset('frontend/css/rate.css') }}" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="{{ asset('frontend/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/css/prettyPhoto.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/css/price-range.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/css/main.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/css/responsive.css') }}" rel="stylesheet">

    <link rel="shortcut icon" href="{{ asset('frontend/images/ico/favicon.ico') }}">
    <link rel="apple-touch-icon-precomposed" sizes="144x144"
        href="{{ asset('frontend/images/ico/apple-touch-icon-144-precomposed.png') }}">
    <link rel="apple-touch-icon-precomposed" sizes="114x114"
        href="{{ asset('frontend/images/ico/apple-touch-icon-114-precomposed.png') }}">
    <link rel="apple-touch-icon-precomposed" sizes="72x72"
        href="{{ asset('frontend/images/ico/apple-touch-icon-72-precomposed.png') }}">
    <link rel="apple-touch-icon-precomposed"
        href="{{ asset('frontend/images/ico/apple-touch-icon-57-precomposed.png') }}">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @stack('styles')
</head>

<body>
    @include('frontend.layout.header')

    {{-- Slide chỉ hiển thị khi trang con định nghĩa section("slider") --}}
    @hasSection('slider')
    <section class="mb-3">
        @yield('slider')
    </section>
    @else
    {{-- Nếu muốn slide luôn hiện, bỏ comment dưới này --}}
    {{-- @include('frontend.layout.slide') --}}
    @endif

    <section>
        <div class="container">
            <div class="row">

                @hasSection('menu_left')
                <div class="col-sm-3">
                    @yield('menu_left')
                </div>
                @else
                {{-- Nếu muốn menu trái luôn hiện, bỏ comment dưới này --}}
                {{-- <div class="col-sm-3">@include('frontend.layout.menu_left')</div> --}}
                @endif

                <div class="col-sm-9">
                    @include('frontend.layout.alert')
                    @yield('content')
                </div>
            </div>
        </div>
    </section>

    @include('frontend.layout.footer')

    <script src="{{ asset('frontend/js/jquery.js') }}"></script>
    <script src="{{ asset('frontend/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('frontend/js/jquery.scrollUp.min.js') }}"></script>
    <script src="{{ asset('frontend/js/price-range.js') }}"></script>
    <script src="{{ asset('frontend/js/jquery.prettyPhoto.js') }}"></script>
    <script src="{{ asset('frontend/js/main.js') }}"></script>

    {{-- Lọc sản phẩm theo khoảng giá với slider bên trái --}}
    <script>
        $(function() {
            // nếu trang hiện tại không có slider #sl2 thì thôi
            if (!$('#sl2').length) return;

            var $slider = $('#sl2').slider();

            var initVal = $slider.data('slider').getValue(); // [min,max]
            $('#price-min-label').text(initVal[0]);
            $('#price-max-label').text(initVal[1]);

            $slider.on('slideStop', function(ev) {
                var vals = ev.value; // [min,max]
                var min = vals[0];
                var max = vals[1];

                $('#price-min-label').text(min);
                $('#price-max-label').text(max);

                filterProductsByPrice(min, max);
            });

            function filterProductsByPrice(min, max) {
                $.ajax({
                    url: "{{ route('products.filter-price') }}",
                    type: "GET",
                    data: {
                        min: min,
                        max: max
                    },
                    beforeSend: function() {
                        $('#product-list').css('opacity', .5);
                    },
                    success: function(html) {
                        $('#product-list').html(html);
                    },
                    complete: function() {
                        $('#product-list').css('opacity', 1);
                    },
                    error: function() {
                        alert('Có lỗi khi lọc sản phẩm theo giá.');
                    }
                });
            }
        });
    </script>

    {{-- Ajax add to cart --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            $(document).on('click', '.add-to-cart', function(e) {
                e.preventDefault();

                let product_id = $(this).data('id');
                let qtyInput = $(this).closest('.product-information').find('input[name="quantity"]');
                let qty = qtyInput.length ? parseInt(qtyInput.val() || 1) : 1;

                $.ajax({
                    url: '{{ route("cart.add") }}',
                    type: 'POST',
                    data: {
                        product_id: product_id,
                        qty: qty,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(res) {
                        if (res.success) {
                            $('#cart-count').text(res.count);
                        }
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                    }
                });
            });
        });
    </script>

    @stack('scripts')
</body>

</html>