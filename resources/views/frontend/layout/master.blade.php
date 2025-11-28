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
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="{{ asset('frontend/images/ico/apple-touch-icon-144-precomposed.png') }}">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="{{ asset('frontend/images/ico/apple-touch-icon-114-precomposed.png') }}">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="{{ asset('frontend/images/ico/apple-touch-icon-72-precomposed.png') }}">
    <link rel="apple-touch-icon-precomposed" href="{{ asset('frontend/images/ico/apple-touch-icon-57-precomposed.png') }}">

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
    {{-- Nếu muốn slide luôn hiện, thay block này bằng:
        @include('frontend.layout.slide') --}}
    @endif

    <section>
        <div class="container">
            <div class="row">

                @hasSection('menu_left')
                <div class="col-sm-3">
                    @yield('menu_left')
                </div>
                @else
                {{-- Nếu muốn slide luôn hiện, thay block này bằng:
                 @include('frontend.layout.menu_left') --}}
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
                            // update qty cart
                            $('#cart-count').text(res.count);
                        }
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                    }
                })
            })
        })
    </script>
    @stack('scripts')
</body>

</html>