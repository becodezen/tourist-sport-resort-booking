@extends('layouts.master')

@section('content')
<div class="row">
    @if($settings)
        <div class="col-lg-6">
            @include('dashboard.settings.booking.edit')
        </div>
        @else 
        <div class="col-lg-6">
            @include('dashboard.settings.booking.create')
        </div>
    @endif    
</div>
@endsection
