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
                {!! Form::open(['route' => ['fr.otp.submit', $customer->slug], 'method' => 'POS']) !!}
                    <div class="login-body-content mt-15 mb-30 text-center">
                        <h3 class="mb-10">Congratulations! {{ $customer->name }}</h3>
                        <h4>Thank you to join with us.</h4>
                    </div>
                    @if($resend)
                        <p class="mb-10">We have resent a code to: {{ $customer->otp }}</p>
                        @else
                        <p class="mb-10">We have sent a code to: {{ $customer->otp }}</p>
                    @endif
                    <strong>{{ $customer->phone }}</strong>
                    <div class="form-group mt-30">
                        <label for="otp">Enter you code here:</label>
                        <input type="text" name="otp" id="otp" class="form-control" autocomplete="off">
                        <span class="text-danger"></span>
                    </div>
                    <div class="form-group mt-30">
                        <button type="submit" class="sign-btn" onclick="formSubmit(this, event)">Submit</button>
                    </div>
                {!! Form::close() !!}
            </div>
            <div class="login-footer mt-20">
                <p class="mb-10">Didn't received any code?</p>
                <div class="code-resend">
{{--                    <span id="countDown">00:59</span>--}}
                    <a href="{{ route('fr.otp.resend', $customer->slug) }}">Resend Code</a>
                </div>
            </div>
        </div>
    </section>

@endsection
