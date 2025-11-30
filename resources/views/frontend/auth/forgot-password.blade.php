@extends('frontend.layout.master')

@section('content')
<div class="container">
    <h2>Quên mật khẩu</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <div class="form-group">
            <label>Email:</label>
            <input type="email" name="email" class="form-control" required>
            @error('email') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <button type="submit" class="btn btn-primary">Gửi link reset mật khẩu</button>
    </form>
</div>
@endsection
