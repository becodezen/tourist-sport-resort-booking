@extends('layouts.auth')

@section('content')
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 col-12 fxt-none-991">
                <div class="fxt-header">
                    <div class="fxt-transformY-50 fxt-transition-delay-1">
                        <a href="#" class="fxt-logo"><img src="{{ asset('asset_login/img/logo-22.png') }}" alt="Logo"></a>
                    </div>
                    <div class="fxt-transformY-50 fxt-transition-delay-2">
                        <h1>Welcome To Vromon Bilash</h1>
                    </div>
                    <div class="fxt-transformY-50 fxt-transition-delay-3">
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. A accusantium blanditiis, culpa cumque doloribus eos est, fugit, incidunt iure iusto quasi quibusdam? Ad, odit placeat.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-12 fxt-bg-color">
                <div class="fxt-content">
                    <div class="fxt-form">
                        <h2>Login</h2>
                        <p>Login into your pages account</p>
                        {!! Form::open(['route' => 'login', 'method' => 'POS']) !!}
                            <div class="form-group">
                                <label for="email" class="input-label">Email Address</label>
                                <input type="text" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" name="email" placeholder="demo@gmail.com" required="required">
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="password" class="input-label">Password</label>
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="********" required="required">
                                <i toggle="#password" class="fa fa-fw fa-eye toggle-password field-icon"></i>
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <div class="fxt-checkbox-area">
                                    <div class="checkbox">
                                        <input id="checkbox1" type="checkbox">
                                        <label for="checkbox1">Keep me logged in</label>
                                    </div>
                                    <a href="#" class="switcher-text">Forgot Password</a>
                                </div>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="fxt-btn-fill">Log in</button>
                            </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
