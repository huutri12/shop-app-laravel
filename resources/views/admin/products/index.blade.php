@extends('admin.layout.master')

@section('content')

<h4 class="fw-bold mb-3">📦 Danh sách sản phẩm</h4>

<form method="GET" class="row mb-3">
    <div class="col-md-4">
        <input type="text" name="search" value="{{ $search }}" class="form-control"
            placeholder="Tìm theo tên sản phẩm hoặc tên member...">
    </div>
    <div class="col-md-2">
        <button class="btn btn-primary">Tìm kiếm</button>
    </div>
</form>

<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Ảnh</th>
            <th>Tên sản phẩm</th>
            <th>Member</th>
            <th>Giá</th>
            <th>Ngày tạo</th>
            <th width="150">Hành động</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($products as $p)
        <tr>
            <td>{{ $p->id }}</td>

            <td>
                @php
                // nếu images là JSON string thì decode, nếu là mảng thì giữ nguyên
                $imgs = is_array($p->images) ? $p->images : json_decode($p->images ?? '[]', true);
                $thumb = $imgs[0] ?? null;
                @endphp

                @if ($thumb)
                <img
                    src="{{ asset('upload/products/'.$p->id_user.'/329x380_'.$thumb) }}"
                    width="70"
                    alt="{{ $p->name }}">
                @else
                <img src="{{ asset('frontend/images/no-image.png') }}" width="70" alt="No image">
                @endif
            </td>


            <td>{{ $p->name }}</td>

            <td>
                <span class="badge bg-info text-white">
                    {{ $p->user->name ?? 'Không có' }}
                </span>
            </td>

            <td>{{ number_format($p->price) }} $</td>
            <td>{{ $p->created_at->format('d-m-Y') }}</td>

            <td>
                <a href="{{ route('admin.products.edit', $p->id) }}" class="btn btn-warning btn-sm">
                    Sửa
                </a>

                <form action="{{ route('admin.products.delete', $p->id) }}" method="POST"
                    style="display:inline-block;">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger btn-sm"
                        onclick="return confirm('Xóa sản phẩm này?')">
                        Xóa
                    </button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

{{ $products->links('pagination::bootstrap-4') }}

@endsection