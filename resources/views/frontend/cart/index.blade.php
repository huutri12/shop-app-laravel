@extends('frontend.layout.master')

@section('title', 'Cart')

@section('content')
<section id="cart_items">
    <div class="container">
        <div class="breadcrumbs">
            <ol class="breadcrumb">
                <li><a href="{{ url('/') }}">Home</a></li>
                <li class="active">Shopping Cart</li>
            </ol>
        </div>

        <div class="table-responsive cart_info">
            <table class="table table-condensed">
                <thead>
                    <tr class="cart_menu">
                        <td class="image">Item</td>
                        <td class="description"></td>
                        <td class="price">Price</td>
                        <td class="quantity">Quantity</td>
                        <td class="total">Total</td>
                        <td></td>
                    </tr>
                </thead>
                <tbody>
                    @forelse($cart as $item)
                    <tr data-id="{{ $item['id'] }}">
                        <td class="cart_product">
                            @if(!empty($item['image']))
                            <a href="#">
                                <img src="{{ asset('upload/products/'.$item['id_user'].'/85x84_'.$item['image']) }}"
                                    width="80" alt="">
                            </a>
                            @endif
                        </td>
                        <td class="cart_description">
                            <h4><a href="#">{{ $item['name'] }}</a></h4>
                            <p>ID: {{ $item['id'] }}</p>
                        </td>
                        <td class="cart_price">
                            <p class="price">{{ number_format($item['price']) }}</p>
                        </td>
                        <td class="cart_quantity">
                            <div class="cart_quantity_button">
                                <a href="javascript:void(0)" class="cart_quantity_up"> + </a>
                                <input class="cart_quantity_input" type="text" name="quantity"
                                    value="{{ $item['qty'] }}" autocomplete="off" size="2">
                                <a href="javascript:void(0)" class="cart_quantity_down"> - </a>
                            </div>
                        </td>
                        <td class="cart_total">
                            <p class="cart_total_price">
                                {{ number_format($item['price'] * $item['qty']) }}
                            </p>
                        </td>
                        <td class="cart_delete">
                            <a class="cart_quantity_delete" href="javascript:void(0)">
                                <i class="fa fa-times"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">
                            Chưa có sản phẩm nào trong giỏ hàng.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</section>

<section id="do_action">
    <div class="container">
        <div class="row">
            <div class="col-sm-6">

            </div>
            <div class="col-sm-6">
                <div class="total_area">
                    <ul>
                        <li>Cart Sub Total
                            <span id="cart-subtotal">{{ number_format($subtotal) }}</span>
                        </li>
                        <li>Shipping Cost <span>Free</span></li>
                        <li>Total <span id="cart-total">{{ number_format($subtotal) }}</span></li>
                    </ul>
                    <a class="btn btn-default check_out"
                        href="{{ route('checkout.index') }}">Check Out</a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@push('scripts')
<script>
    $(document).ready(function() {

        // Tăng quantity
        $(document).on('click', '.cart_quantity_up', function() {
            let tr = $(this).closest('tr');
            let id = tr.data('id');
            let qtyInput = tr.find('.cart_quantity_input');
            let qty = parseInt(qtyInput.val() || 1) + 1;

            updateCart(id, qty, tr);
        });

        // Giảm quantity
        $(document).on('click', '.cart_quantity_down', function() {
            let tr = $(this).closest('tr');
            let id = tr.data('id');
            let qtyInput = tr.find('.cart_quantity_input');
            let qty = parseInt(qtyInput.val() || 1) - 1;
            if (qty < 1) qty = 1;

            updateCart(id, qty, tr);
        });

        // Xóa item
        $(document).on('click', '.cart_quantity_delete', function() {
            let tr = $(this).closest('tr');
            let id = tr.data('id');

            $.post('{{ route("cart.delete") }}', {
                _token: '{{ csrf_token() }}',
                id: id
            }, function(res) {
                if (res.success) {
                    tr.remove();

                    $('#cart-subtotal').text(res.subtotal.toLocaleString('vi-VN'));
                    $('#cart-total').text(res.subtotal.toLocaleString('vi-VN'));
                    $('#cart-count').text(res.total_qty);

                    if (res.total_qty === 0) {
                        $('tbody').html(`
                            <tr>
                                <td colspan="6" class="text-center">
                                    Chưa có sản phẩm nào trong giỏ hàng.
                                </td>
                            </tr>
                        `);
                    }
                }
            });
        });

        // Hàm gọi AJAX update cart
        function updateCart(id, qty, tr) {
            $.post('{{ route("cart.update") }}', {
                _token: '{{ csrf_token() }}',
                id: id,
                qty: qty
            }, function(res) {
                if (res.success) {
                    tr.find('.cart_quantity_input').val(qty);

                    tr.find('.cart_total_price').text(
                        res.item_total.toLocaleString('vi-VN')
                    );
                    $('#cart-subtotal').text(res.subtotal.toLocaleString('vi-VN'));
                    $('#cart-total').text(res.subtotal.toLocaleString('vi-VN'));
                    $('#cart-count').text(res.total_qty);
                }
            });
        }

    });
</script>
@endpush