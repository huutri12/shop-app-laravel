@extends('frontend.layout.master')
@section('title','Login | E-Shopper')

{{-- báo layout: trang này KHÔNG có sidebar --}}
@section('no_sidebar') @endsection

@section('content')
<section id="form">
    <div class="container">
        <div class="row">
            <div class="col-sm-6 col-sm-offset-3">
                <div class="login-form">
                    <h2>Login to your account</h2>

                    
                    @if($errors->any())
                    <div class="alert alert-danger">{{ $errors->first() }}</div>
                    @endif
                    @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <form action="{{ route('member.login.post') }}" method="POST">
                        @csrf
                        <input type="email" placeholder="email" name="email" value="{{ old('email') }}" required>
                        
                        <input type="password" placeholder="password" name="password" required>

                        <label class="mt-2"><input type="checkbox" name="remember_me" {{ old('remember_me') ? 'checked' : '' }}> Keep me signed in</label>
                        <button class="btn btn-default">Login</button>
                    </form>

                    <p class="mt-3">Chưa có tài khoản?
                        <a href="{{ route('member.register') }}">Đăng ký ngay</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection