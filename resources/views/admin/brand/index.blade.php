@extends('admin.layout.master')
@section('title','Brands')

@section('content')
<h3>Brands</h3>
<a href="{{ route('admin.brand.create') }}" class="btn btn-primary mb-2">Create</a>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($items as $it)
        <tr>
            <td>{{ $it->id }}</td>
            <td>{{ $it->name }}</td>
            <td>
                @if($it->status)
                <span class="badge rounded-pill bg-success px-3 py-2 shadow-sm">Active</span>
                @else
                <span class="badge rounded-pill bg-light text-dark border border-secondary px-3 py-2 shadow-sm">Inactive</span>
                @endif
            </td>

            <td>
                <a href="{{ route('admin.brand.edit',$it->id) }}" class="btn btn-sm btn-warning">Edit</a>
                <a href="{{ route('admin.brand.delete',$it->id) }}" class="btn btn-sm btn-danger"
                    onclick="return confirm('Delete?')">Delete</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

{!! $items->links('pagination::bootstrap-4') !!}
@endsection