@extends('admin.layout.master')

@section('breadcrumb')
<div class="page-breadcrumb">
  <div class="row">
    <div class="col-5 align-self-center">
      <h4 class="page-title">Edit Country</h4>
    </div>
    <div class="col-7 align-self-center">
      <div class="d-flex align-items-center justify-content-end">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.country.index') }}">Country</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit</li>
          </ol>
        </nav>
      </div>
    </div>
  </div>
</div>
@endsection

@section('content')
<div class="container-fluid">


  <div class="card">
    <div class="card-body">
      <form method="POST" action="{{ route('admin.country.update', $country->id) }}">
        @csrf
        <div class="form-group">
          <label>Name *</label>
          <input type="text" name="name" class="form-control" value="{{ old('name', $country->name ?? '') }}" required>
        </div>
        <a href="{{ route('admin.country.index') }}" class="btn btn-light">Cancel</a>
        <button class="btn btn-primary">Update</button>
      </form>
    </div>
  </div>
</div>
@endsection