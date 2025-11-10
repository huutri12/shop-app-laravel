@extends('frontend.layout.master')
@section('title','User Update')

@section('menu_left')
@include('frontend.account._sidebar')
@endsection

@section('content')
<div class="features_items">
  <h2 class="title text-center">User Update!</h2>

  @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
  @if($errors->any())
  <div class="alert alert-danger">
    <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
  </div>
  @endif

  <form action="{{ route('account.update.post') }}" method="POST" enctype="multipart/form-data" class="col-sm-8">
    @csrf
    <input class="form-control mb-2" name="name" value="{{ old('name',$user->name) }}" placeholder="Name">
    <input class="form-control mb-2" name="email" value="{{ old('email',$user->email) }}" placeholder="Email">
    <input class="form-control mb-2" type="password" name="password" placeholder="New password (optional)">
    <input class="form-control mb-2" type="password" name="password_confirmation" placeholder="Confirm password">
    <input class="form-control mb-2" name="address" value="{{ old('address',$user->address) }}" placeholder="City">
    <select name="id_country" class="form-control">
      @foreach($countries as $country)
      <option value="{{ $country->id }}"
        {{ old('id_country', $user->id_country) == $country->id ? 'selected' : '' }}>
        {{ $country->name }}
      </option>
      @endforeach
    </select>

    <input class="form-control mb-2" name="phone" value="{{ old('phone',$user->phone) }}" placeholder="Phone">
    <input class="form-control mb-2" type="file" name="avatar">

    <button class="btn btn-warning">Save</button>
  </form>
</div>
@endsection