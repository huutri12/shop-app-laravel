@extends('admin.layout.master')

@section('breadcrumb')
<div class="page-breadcrumb">
  <div class="row">
    <div class="col-5 align-self-center">
      <h4 class="page-title">Blog</h4>
    </div>
    <div class="col-7 align-self-center">
      <div class="d-flex align-items-center justify-content-end">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Blog</li>
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
          <input type="text" name="q" class="form-control mr-2" placeholder="Search title..." value="{{ request('q') }}">
          <button class="btn btn-outline-primary">Search</button>
        </form>
        <a href="{{ route('admin.blog.create') }}" class="btn btn-success">Add Blog</a>
      </div>

      <div class="table-responsive">
        <table class="table">
          <thead class="thead-light">
            <tr>
              <th style="width:80px">#</th>
              <th>Title</th>
              <th>Image</th>
              <th>Description</th>
              <th>Content</th>
              <th style="width:160px" class="text-right">Action</th>
            </tr>
          </thead>
          <tbody>
            @if($blogs->count() > 0)
            @foreach($blogs as $b)
            <tr>
              <td>{{ $b->id }}</td>
              <td>{{ $b->title }}</td>
              <td>
                @if($b->image)
                <img src="{{ asset('upload/blog/'.$b->image) }}" alt="" width="80">
                @endif
              </td>
              <td>{{ \Illuminate\Support\Str::limit($b->description, 80) }}</td>
              <td>{{ \Illuminate\Support\Str::of(html_entity_decode($b->content ?? ''))->stripTags()->limit(120) }}</td>
              <td class="text-right">
                <a class="text-primary mr-3" href="{{ route('admin.blog.edit', $b->id) }}">Edit</a>
                <a href="{{ route('admin.blog.delete', $b->id) }}"
                  onclick="return confirm('Delete this blog?')"
                  class="text-danger">Delete</a>
              </td>
            </tr>
            @endforeach
            @else
            <tr>
              <td colspan="5" class="text-center text-muted">No data</td>
            </tr>
            @endif
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection