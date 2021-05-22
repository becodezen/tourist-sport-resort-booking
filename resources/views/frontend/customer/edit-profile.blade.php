@extends('layouts.dashboard')

@section('dashboard.content')
    {!! Form::open(['route' => 'fr.update.profile.submit', 'method' => 'PUT']) !!}
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">Name</label>
                    <input type="text" name="name" value="{{ $customer->name }}" class="form-control">
                    <span class="text-danger"></span>
                </div>
                <div class="form-group">
                    <label for="">Phone</label>
                    <input type="text" readonly value="{{ $customer->phone }}" class="form-control">
                </div>
                <div class="form-group">
                    <label for="">Email</label>
                    <input type="text" readonly value="{{ $customer->email }}" class="form-control">
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group text-center">
                    <img src="{{ asset($customer->profile ? $customer->profile->photo : '') }}" alt="" class="mb-10">
                    <input type="file" name="photo">
                    <br>
                    <span class="text-danger"></span>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="">Gender</label>
                    {!! Form::select('gender', ['male' => 'Male', 'female' => 'Female', 'other' => 'Other'], ($customer->profile ? $customer->profile->gender : null), ['placeholder' => 'Select gender', 'class' => 'form-control']) !!}
                    <span class="text-danger"></span>
                </div>
                <div class="form-group">
                    <label for="">Address</label>
                    <input type="text" name="address" value="{{ $customer->profile ? $customer->profile->address : '' }}" placeholder="Address" class="form-control">
                    <span class="text-danger"></span>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="">Passport/NID no</label>
                    <input type="text" name="identity" value="{{ $customer->profile ? $customer->profile->identity : '' }}" placeholder="Passport/NID no" class="form-control">
                    <span class="text-danger"></span>
                </div>
                <div class="form-group">
                    <label for="">Birthdate</label>
                    <input type="text" name="birthdate" value="{{ $customer->profile ? $customer->profile->birthdate : '' }}" placeholder="DD/MM/YYYY" class="form-control">
                    <span class="text-danger"></span>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group mt-15 text-right">
                    <button class="btn btn-primary" onclick="formSubmit(this, event)">Update Profile</button>
                </div>
            </div>
        </div>
    {!! Form::close() !!}
@endsection
