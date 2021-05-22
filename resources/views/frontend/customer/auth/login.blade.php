@extends('layouts.auth-customer')

@section('content')

    <section class="login-wrap">
        <div class="login-box">
            <div class="login-header">
                <h2>
                    <a href="{{ route('fr.home') }}">
                        <span>VromonBilash</span>
                    </a>
                </h2>
            </div>
            <div class="login-body">
                {!! Form::open(['route' => 'fr.login.submit', 'method' => 'POS']) !!}
                    <h3 class="mt-15 mb-30">Sign in to Vromonbilash</h3>
                    <div class="form-group">
                        <label for="email_phone">Email/Phone</label>
                        <input type="text" name="email" id="email_phone" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" autocomplete="off">
                        @error('email')
                            <span class="text-danger mt-5">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror">
                            @error('password')
                            <span class="text-danger mt-5">
                                    {{ $message }}
                                </span>
                            @enderror
                    </div>
                    <div class="form-group mt-30">
                        <button type="submit" class="sign-btn">Login</button>
                    </div>
                {!! Form::close() !!}
            </div>
            <div class="login-footer mt-20">
                <p class="mb-10">Have no account?</p>
                <a href="{{ route('fr.register') }}">Create Account</a>
            </div>
        </div>
    </section>

@endsection
