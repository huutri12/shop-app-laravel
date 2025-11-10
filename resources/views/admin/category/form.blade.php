@extends('admin.layout.master')
@section('title', $item->exists ? 'Edit Category' : 'Create Category')

@section('content')
<h3>{{ $item->exists ? 'Edit' : 'Create' }} Category</h3>

<form method="POST" action="{{ $item->exists
      ? route('admin.category.update',$item->id)
      : route('admin.category.store') }}">
    @csrf

    <div class="mb-3">
        <label>Name</label>
        <input type="text" name="name" class="form-control" value="{{ old('name',$item->name) }}">
        @error('name') <small class="text-danger">{{ $message }}</small>@enderror
    </div>

    <div class="mb-3">
        <label>Status</label>
        <select name="status" class="form-control">
            <option value="1" @selected(old('status',$item->status)==1)>Active</option>
            <option value="0" @selected(old('status',$item->status)==0)>Inactive</option>
        </select>
    </div>

    <button class="btn btn-primary">Save</button>
</form>
@endsection