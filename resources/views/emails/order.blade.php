@component('mail::message')
# Xin chào {{ $user->name }}

Cảm ơn bạn đã đặt hàng tại shop của chúng tôi.
Dưới đây là thông tin đơn hàng:

@component('mail::table')
| Sản phẩm | SL | Đơn giá | Thành tiền |
|---------|----|---------|------------|
@foreach($cart as $item)
| {{ $item['name'] }} | {{ $item['qty'] }} | {{ number_format($item['price']) }} | {{ number_format($item['price'] * $item['qty']) }} |
@endforeach
@endcomponent

**Tổng thanh toán:** {{ number_format($total) }} $

**SĐT nhận hàng:** {{ $orderData['phone'] }}
**Địa chỉ giao hàng:** {{ $orderData['address'] }}

@if(!empty($orderData['note']))
**Ghi chú:** {{ $orderData['note'] }}
@endif

Cảm ơn bạn đã mua sắm!

@endcomponent