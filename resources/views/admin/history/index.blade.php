@extends('admin.layout.master')

@section('content')
<h4 class="fw-bold mb-3">🧾 Lịch sử mua hàng</h4>

<form method="GET" class="row mb-3">
    <div class="col-md-4">
        <input type="text" name="search" value="{{ $search }}"
            class="form-control" placeholder="Tìm theo tên / email member...">
    </div>
    <div class="col-md-2">
        <button class="btn btn-primary">Tìm kiếm</button>
    </div>
</form>

<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Member</th>
            <th>Email</th>
            <th>SĐT</th>
            <th>Tổng tiền</th>
            <th>Ngày mua</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($histories as $h)
        <tr>
            <td>{{ $h->id }}</td>
            <td>{{ $h->user->name ?? $h->name }}</td>
            <td>{{ $h->email }}</td>
            <td>{{ $h->phone }}</td>
            <td>{{ number_format($h->price) }} $</td>
            <td>{{ optional($h->created_at)->format('d-m-Y H:i') }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

{{ $histories->links('pagination::bootstrap-4') }}
@endsection