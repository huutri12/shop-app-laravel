@extends('admin.layout.master')

@section('breadcrumb')
<div class="page-breadcrumb">
  <div class="row">
    <div class="col-5 align-self-center"><h4 class="page-title">Country</h4></div>
    <div class="col-7 align-self-center">
      <div class="d-flex align-items-center justify-content-end">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Country</li>
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
      <div class="d-flex justify-content-between mb-3">
        <form class="form-inline" method="GET">
          <input type="text" name="q" class="form-control mr-2" placeholder="Search name..." value="{{ $q }}">
          <button class="btn btn-outline-primary">Search</button>
        </form>
        <a href="{{ route('admin.country.create') }}" class="btn btn-success">Add Country</a>
      </div>

      <div class="table-responsive">
        <table class="table">
          <thead class="thead-light">
            <tr>
              <th style="width: 80px;">#</th>
              <th>Name</th>
              <th style="width: 160px;" class="text-right">Action</th>
            </tr>
          </thead>
          <tbody>
            @forelse($countries as $country)
              <tr>
                <td>{{ $country->id }}</td>
                <td>{{ $country->name }}</td>
                <td class="text-right">
                  <a href="{{ route('admin.country.edit', $country->id) }}" class="text-primary mr-3">Edit</a>
                  <a href="{{ route('admin.country.delete', $country->id) }}"
                     onclick="return confirm('Delete this country?')"
                     class="text-danger">Delete</a>
                </td>
              </tr>
            @empty
              <tr><td colspan="3" class="text-center text-muted">No data</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection
