@extends('frontend.layout.master')
@section('title','My Product')

@section('menu_left')
@include('frontend.account._sidebar')
@endsection

@section('content')
<h3>My Products</h3>

@if($products->isEmpty())
<p>Chưa có sản phẩm nào.</p>
<a class="btn btn-primary" href="{{ route('account.add-product') }}">Add New</a>
@else
<a class="btn btn-primary mb-2" href="{{ route('account.add-product') }}">Add New</a>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Id</th>
            <th>Name</th>
            <th>Image(s)</th>
            <th>Price</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($products as $p)
        @php

        $images = json_decode($p->image, true) ?? [];
        @endphp
        <tr>
            <td>{{ $p->id }}</td>
            <td>{{ $p->name }}</td>
            <td>
                @foreach($images as $img)
                <img src="{{ asset('upload/products/'.auth()->id().'/85x84_'.$img) }}"
                    width="60"
                    style="margin-right:4px; margin-bottom:3px;">
                @endforeach
            </td>
            <td>${{ number_format($p->price, 2) }}</td>
            <td>
                <a href="{{ route('account.edit-product', $p->id) }}" class="btn btn-sm btn-warning">Edit</a>
                <form action="{{ route('account.delete-product',$p->id) }}" method="POST" class="d-inline"
                    onsubmit="return confirm('Delete this product?')">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-danger">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
{!! $products->links('pagination::bootstrap-4') !!}
@endif
@endsection