@extends('layouts.auth-customer')

@section('content')

    <section class="login-wrap">
        <div class="login-box register-box">
            <div class="login-header">
                <h2>
                    <a href="{{ route('fr.home') }}">
                        <span>VromonBilash</span>
                    </a>
                </h2>
            </div>
            <div class="login-body">
                {!! Form::open(['route' => 'fr.register.submit', 'method' => 'POS']) !!}
                    <h3 class="mt-15 mb-30">Sign up in to Vromonbilash</h3>
                    <div class="form-grid grid-2">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}">
                            @error('name')
                            <span class="text-danger mt-5">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <input type="text" name="phone" id="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}">
                            @error('phone')
                            <span class="text-danger mt-5">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}">
                        @error('email')
                        <span class="text-danger mt-5">
                                    {{ $message }}
                                </span>
                        @enderror
                    </div>

                    <div class="form-grid grid-2">
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror">
                            @error('password')
                            <span class="text-danger mt-5">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="conf_pass">Confirm Password</label>
                            <input type="password" name="password_confirmation" id="conf_pass" class="form-control @error('password_confirmation') is-invalid @enderror">
                            @error('password_confirmation')
                            <span class="text-danger mt-5">
                            {{ $message }}
                        </span>
                            @enderror
                        </div>

                    </div>
                    <div class="form-group mt-20">
                        <button type="submit" class="sign-btn">Register Now</button>
                    </div>
                {!! Form::close() !!}
            </div>
            <div class="login-footer mt-20">
                <p class="mb-10">Already have an account?</p>
                <a href="{{ route('fr.login') }}">Login</a>
            </div>
        </div>
    </section>

@endsection
