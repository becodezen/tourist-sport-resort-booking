@extends('layouts.frontend')

@section('content')

    <!-- login section -->
    <section class="login-area pb-70 pt-70 bg-light-gray">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 offset-3">
                    {!! Form::open(['route' => 'fr.login.submit', 'method' => 'POS', 'class' => 'login-form']) !!}
                        <div class="login-header text-center">
                            <h2>Login</h2>
                        </div>
                        <div class="login-body">
                            <div class="form-group">
                                <input type="text" name="email" placeholder="Email or phone" value="{{ old('email') }}"  class="form-control @error('email') is-invalid @enderror"">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input type="password" name="password" placeholder="Password" class="form-control @error('password') is-invalid @enderror">
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group d-flex justify-content-between">
                                <label>
                                    <input type="checkbox" name="remember_me"> Remember Me
                                </label>
                                 <a href="">Forgot Password?</a>
                            </div>
                            <div class="form-submit text-center mb-30">
                                <button type="submit" class="btn btn-primary">Login</button>
                            </div>
                            <div class="form-group text-center">
                                <p>Don't Have an Account <a href="{{ route('fr.register') }}">Create Account</a></p>
                            </div>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </section>

@endsection
