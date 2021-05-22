@extends('layouts.frontend')

@section('content')

    @include('partials._fr_page_title')

    <!-- Register section -->
    <section class="login-area pb-70 pt-70 bg-light-gray">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 offset-3">
                    {!! Form::open(['route' => 'fr.register.submit', 'method' => 'POST', 'class' => 'login-form']) !!}
                        <div class="login-header text-center">
                            <h2>Create Account</h2>
                        </div>
                        <div class="login-body">
                            <div class="form-group">
                                <input type="text" name="name" placeholder="Name" class="form-control">
                                <span class="text-danger"></span>
                            </div>
                            <div class="form-group">
                                <input type="text" name="phone" placeholder="Phone" class="form-control">
                                <span class="text-danger"></span>
                            </div>
                            <div class="form-group">
                                <input type="text" name="email" placeholder="Email address"  class="form-control">
                                <span class="text-danger"></span>
                            </div>
                            <div class="form-group">
                                <input type="password" name="password" placeholder="Password" class="form-control">
                                <span class="text-danger"></span>
                            </div>
                            <div class="form-group">
                                <input type="password" name="password_confirmation" placeholder="Confirm Password" class="form-control">
                                <span class="text-danger"></span>
                            </div>

                            <div class="form-submit text-center mb-30">
                                <button type="submit" onclick="formSubmit(this, event)" class="btn btn-primary">Create Account</button>
                            </div>

                            <div class="form-group text-center">
                                <p>Already Have an Account? <a href="{{ route('fr.login') }}">Login</a></p>
                            </div>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </section>

@endsection
