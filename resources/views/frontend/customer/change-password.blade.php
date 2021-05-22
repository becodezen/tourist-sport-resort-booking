@extends('layouts.dashboard')

@section('dashboard.content')
    <div class="row">
        <div class="col-md-6 offset-3">
            {!! Form::open(['route' => 'fr.update.password', 'method' => 'PUT']) !!}
                <div class="form-group">
                    <label for="old_pass">Current Password</label>
                    <input type="password" name="current_password" id="old_pass" placeholder="*******" class="form-control">
                    <span class="text-danger"></span>
                </div>
                <div class="form-group">
                    <label for="new_pass">New Password</label>
                    <input type="password" name="password" id="new_pass" placeholder="*******" class="form-control">
                    <span class="text-danger"></span>
                </div>
                <div class="form-group">
                    <label for="conf_pass">Confirm New Password</label>
                    <input type="password" name="password_confirmation" id="conf_pass" placeholder="*******" class="form-control">
                    <span class="text-danger"></span>
                </div>
                <div class="form-group mt-25 text-right">
                    <button type="submit" class="btn btn-sm btn-primary" onclick="formSubmit(this, event)">Update Password</button>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection
