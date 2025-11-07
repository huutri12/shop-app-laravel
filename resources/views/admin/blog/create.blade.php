@extends('admin.layout.master')

@section('breadcrumb')
<div class="page-breadcrumb">
  <div class="row">
    <div class="col-5 align-self-center">
      <h4 class="page-title">Add Blog</h4>
    </div>
    <div class="col-7 align-self-center">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ route('admin.blog.index') }}">Blog</a></li>
          <li class="breadcrumb-item active">Create</li>
        </ol>
      </nav>
    </div>
  </div>
</div>
@endsection

@section('content')
<div class="container-fluid">

  <div class="card">
    <div class="card-body">
      <form method="POST" action="{{ route('admin.blog.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
          <label>Title *</label>
          <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
          @error('title') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="form-group">
          <label>Image (<=2MB)< /label> {{-- sửa < /label> -> </label> --}}
              <input type="file" name="image" class="form-control" accept="image/*">
              @error('image') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="form-group">
          <label>Description</label>
          <input type="text" name="description" class="form-control" value="{{ old('description') }}">
          @error('des') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="form-group">
          <label>Content</label>
          <textarea id="editor" name="content" rows="10" class="form-control">{{ old('content',  $blog->content ?? '') }}</textarea>
          @error('content') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <a href="{{ route('admin.blog.index') }}" class="btn btn-light">Cancel</a>
        <button class="btn btn-primary">Create</button>
      </form>
    </div>
  </div>
</div>
@endsection

@push('scripts')

<script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    if (document.getElementById('editor')) {
      CKEDITOR.replace('editor');
    }
  });
</script>
@endpush