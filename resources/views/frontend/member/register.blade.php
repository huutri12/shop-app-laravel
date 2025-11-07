@extends('frontend.layout.master')
@section('title','Register | E-Shopper')

@section('content')
<section id="form">
    <div class="container">
        <div class="row">

            <div class="col-sm-6 col-sm-offset-3">
                <div class="signup-form">
                    <h2>New User Signup</h2>

                    @if($errors->any())
                    <div class="alert alert-danger">{{ $errors->first() }}</div>
                    @endif

                    <form method="POST" action="{{ route('member.register.post') }}">
                        @csrf
                        <input type="text" name="name" value="{{ old('name') }}" placeholder="Full Name" required />
                        <input type="email" name="email" value="{{ old('email') }}" placeholder="Email Address" required />
                        <input type="text" name="phone" value="{{ old('phone') }}" placeholder="Phone" />
                        <input type="text" name="address" value="{{ old('address') }}" placeholder="Address" />
                        <input type="password" name="password" placeholder="Password" required />
                        <input type="password" name="password_confirmation" placeholder="Confirm Password" required />

                        <button type="submit" class="btn btn-default">Signup</button>
                    </form>

                    <p class="mt-3">Đã có tài khoản?
                        <a href="{{ route('member.login.post') }}">Đăng nhập</a>
                    </p>
                </div>
            </div>

        </div>
    </div>
</section>
@endsection