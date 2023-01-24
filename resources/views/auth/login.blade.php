@extends('layouts.auth')

@section('content')

<div class="row m-0">
    <div class="col-12 p-0">
        <div class="login-card">
            <div>
                <div>
                    <a class="logo" href="{{ route('login') }}"><img class="img-fluid for-light" src="{{ asset('/theme/cuba/assets/images/logo/login.png') }}" alt="looginpage">
                        <img class="img-fluid for-dark" src="{{ asset('/theme/cuba/assets/images/logo/logo_dark.png') }}" alt="looginpage">
                    </a>
                </div>
                <div class="login-main">
                    <form class="theme-form" method="POST" action="{{ route('login') }}">
                        @csrf
                        <h4>Sign in to account</h4>
                        <p>Enter your email & password to login</p>
                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <div class="form-group">
                            <label class="col-form-label">Username</label>
                            <input class="form-control" type="text" name="username" id="username" required="" placeholder="" autofocus="">
                        </div>
                        <div class="form-group">
                            <label class="col-form-label">Password</label>
                            <div class="form-input position-relative">
                                <input class="form-control" type="password" name="password" id="password" required="" placeholder="">
                            </div>
                        </div>
                        <div class="form-group mb-0">
                            <div class="checkbox p-0">
                                <input id="remember_me" type="checkbox" name="remember">
                                <label class="text-muted" for="remember_me">Remember Me</label>
                            </div>
                            @if (Route::has('password.request'))
                            <a class="link" href="{{ route('password.request') }}">Forgot password?</a>
                            @endif
                            <div class="text-end mt-3">
                                <button class="btn btn-primary btn-block w-100" type="submit">Sign in</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection