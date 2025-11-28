@extends('frontend.layout.master')

@section('title', 'Checkout')

@section('content')
<section id="cart_items">
    <div class="container">

        <div class="breadcrumbs">
            <ol class="breadcrumb">
                <li><a href="{{ url('/') }}">Home</a></li>
                <li class="active">Check out</li>
            </ol>
        </div>

        <div class="step-one">
            <h2 class="heading">Step1</h2>
        </div>


        @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $e)
                <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        @if(session('success'))
        <script>
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
            });

            Toast.fire({
                icon: 'success',
                title: '{{ session("success") }}'
            });
        </script>
        @endif


        @guest
        <div class="checkout-options">
            <h3>New User</h3>
            <p>Checkout options</p>
            <ul class="nav">
                <li>
                    <label>Register Account</label>
                </li>
            </ul>
        </div>

        <div class="register-req">
            <p>
                Please use Register And Checkout to easily get access to your order history,
                or use Checkout as Guest.
            </p>
        </div>
        @else
        <div class="checkout-options">
            <h3>Welcome back</h3>
            <p>Bạn đang đăng nhập với tài khoản <strong>{{ auth()->user()->email }}</strong></p>
        </div>
        @endguest

        <div class="shopper-informations">
            <div class="row">


                <div class="col-sm-4">
                    <div class="shopper-info">
                        @guest
                        <p>Register Account</p>

                        <form method="POST" action="{{ route('member.register.post') }}">
                            @csrf
                            <input type="text" name="name" value="{{ old('name') }}" placeholder="Full Name" required />
                            <input type="email" name="email" value="{{ old('email') }}" placeholder="Email Address" required />
                            <input type="text" name="phone" value="{{ old('phone') }}" placeholder="Phone" />
                            <input type="text" name="address" value="{{ old('address') }}" placeholder="Address" />
                            <input type="password" name="password" placeholder="Password" required />
                            <input type="password" name="password_confirmation" placeholder="Confirm Password" required />

                            <button type="submit" class="btn btn-primary">Signup & Checkout</button>
                        </form>

                        <p class="mt-3">
                            Đã có tài khoản?
                            <a href="{{ route('member.login.post') }}">Đăng nhập</a>
                        </p>
                        @else
                        <p>Thông tin đặt hàng</p>

                        <form method="POST" action="{{ route('checkout.order') }}">
                            @csrf
                            <input type="text" value="{{ auth()->user()->name }}" name="name"
                                placeholder="Full Name" readonly>
                            <input type="email" value="{{ auth()->user()->email }}" name="email"
                                placeholder="Email Address" readonly>
                            <input type="text" name="phone"
                                value="{{ old('phone', auth()->user()->phone) }}"
                                placeholder="Phone *" required>
                            <input type="text" name="address"
                                value="{{ old('address', auth()->user()->address) }}"
                                placeholder="Address *" required>
                            <textarea name="note" placeholder="Notes about your order"
                                rows="4">{{ old('note') }}</textarea>

                            <button type="submit" class="btn btn-primary" style="margin-top:10px;">
                                Đặt hàng
                            </button>
                        </form>
                        @endguest
                    </div>
                </div>

                <div class="col-sm-5 clearfix">
                    <div class="bill-to">
                        <p>Bill To</p>
                        <div class="form-one">
                            @auth
                            <p><strong>Name:</strong> {{ auth()->user()->name }}</p>
                            <p><strong>Email:</strong> {{ auth()->user()->email }}</p>
                            @else
                            <p>Đăng ký tài khoản bên trái để tiếp tục thanh toán.</p>
                            @endauth
                        </div>
                    </div>
                </div>

                {{-- CỘT PHẢI: ghi chú giao hàng --}}
                <div class="col-sm-3">
                    <div class="order-message">
                        <p>Shipping Order</p>
                        <textarea name="message" placeholder="Notes about your order, Special Notes for Delivery"
                            rows="10" disabled></textarea>
                        <label><input type="checkbox" disabled> Shipping to bill address</label>
                    </div>
                </div>
            </div>
        </div>

        <div class="review-payment">
            <h2>Review & Payment</h2>
        </div>

        {{-- BẢNG REVIEW GIỎ HÀNG --}}
        <div class="table-responsive cart_info">
            <table class="table table-condensed">
                <thead>
                    <tr class="cart_menu">
                        <td class="image">Item</td>
                        <td class="description"></td>
                        <td class="price">Price</td>
                        <td class="quantity">Quantity</td>
                        <td class="total">Total</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cart as $item)
                    <tr>
                        <td class="cart_product">
                            @if(!empty($item['image']))
                            <img src="{{ asset('upload/products/'.$item['id_user'].'/85x84_'.$item['image']) }}"
                                width="70" alt="">
                            @endif
                        </td>
                        <td class="cart_description">
                            <h4>{{ $item['name'] }}</h4>
                            <p>ID: {{ $item['id'] }}</p>
                        </td>
                        <td class="cart_price">
                            <p>{{ number_format($item['price']) }}</p>
                        </td>
                        <td class="cart_quantity">
                            <p>{{ $item['qty'] }}</p>
                        </td>
                        <td class="cart_total">
                            <p class="cart_total_price">
                                {{ number_format($item['price'] * $item['qty']) }}
                            </p>
                        </td>
                    </tr>
                    @endforeach

                    <tr>
                        <td colspan="3">&nbsp;</td>
                        <td colspan="2">
                            <table class="table table-condensed total-result">
                                <tr>
                                    <td>Cart Sub Total</td>
                                    <td>{{ number_format($subtotal) }}</td>
                                </tr>
                                <tr class="shipping-cost">
                                    <td>Shipping Cost</td>
                                    <td>Free</td>
                                </tr>
                                <tr>
                                    <td>Total</td>
                                    <td><span>{{ number_format($subtotal) }}</span></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>
</section>
@endsection