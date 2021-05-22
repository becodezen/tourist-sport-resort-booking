@extends('layouts.master')

@section('content')

<div class="box">
    <div class="box-header with-border">
        <div class="box-header-content">
            <h5 class="box-title">Package Booking Details</h5>
        </div>
        <div class="action">
            <a href="{{ route('package.booking.list') }}" class="btn btn-sm btn-light">Booking List</a>
        </div>
    </div>
    <div class="box-body">
        <div class="package-booking">
            <div class="row">
                <div class="col-md-4">
                    <div class="booking-phone">
                        <strong>Call Now</strong>
                        <h1><i class="fas fa-phone-alt"></i> {{ $booking->guest->phone }}</h1>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="booking-content">
                        <div class="booking-people">
                            <div class="booking-guest">
                                <h5 class="form-section-title">Guest Information</h5>
                                <div class="booking-guest-content">
                                    <p><i class="fas fa-user"></i> <strong>{{ $booking->guest->name }}</strong></p>
                                    <p><i class="fas fa-phone"></i> {{ $booking->guest->phone }}</p>
                                    <p><i class="fas fa-envelope"></i> {{ $booking->guest->email }}</p>
                                    <p><i class="fas fa-map-marker-alt"></i> {{ $booking->guest->address }}</p>
                                </div>
                            </div>
                            @if($booking->customer)
                                <div class="booking-customer">
                                    <h5 class="form-section-title">Customer Information</h5>
                                    <div class="booking-customer-content">
                                        <p><i class="fas fa-user"></i> <strong>{{ $booking->customer->name }}</strong></p>
                                        <p><i class="fas fa-phone"></i> {{ $booking->customer->phone }}</p>
                                        <p><i class="fas fa-envelope"></i> {{ $booking->customer->email }}</p>
                                        <p><i class="fas fa-map-marker-alt"></i> {{ $booking->customer->profile->address }}</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="booking-package mt-25">
                            <h5 class="form-section-title">Package Information</h5>
                            <div class="booking-customer-content">
                                <p><strong>Package Name: </strong> {{ $booking->package()->name }}</p>
                                <p><strong>Min Members: </strong> {{ $booking->package()->min_member }}</p>
                                <p><strong>Price (Per Unit): </strong> {{ $booking->price }}</p>
                                <p><strong>From Date: </strong> {{ $booking->assignPackage->check_in }}</p>
                                <p><strong>To Date: </strong> {{ $booking->assignPackage->check_out }}</p>
                            </div>
                        </div>
                        <div class="booking-booking mt-25">
                            <h5 class="form-section-title">Booking Information</h5>
                            <div class="booking-customer-content">
                                <p><strong>Booking No: </strong> {{ $booking->booking_no }}</p>
                                <p><strong>Issue Date: </strong> {{ $booking->created_at }}</p>
                                <p><strong>Members: </strong> {{ $booking->member }}</p>
                                <p><strong>Total Price: </strong> {{ $booking->total_price }}</p>
                                <p><strong>Status: </strong> {{ $booking->status }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="box-footer text-center">
        @if($booking->status == 'pending')
            {!! Form::open(['route' => ['package.booking.approved', $booking->id], 'method' => 'POST']) !!}
                <button type="submit" class="btn btn-sm btn-success" onclick="formSubmit(this, event)">Approved Booking</button>
            {!! Form::close() !!}
        @elseif($booking->status == 'approved')
            {!! Form::open(['route' => ['package.booking.cancelled', $booking->id], 'method' => 'POST']) !!}
                <button type="submit" class="btn btn-sm btn-danger" onclick="formSubmit(this, event)">Cancelled Booking</button>
            {!! Form::close() !!}
        @else
            {!! Form::open(['route' => ['package.booking.approved', $booking->id], 'method' => 'POST']) !!}
                <button type="submit" class="btn btn-sm btn-success" onclick="formSubmit(this, event)">Approved Booking</button>
            {!! Form::close() !!}
        @endif
    </div>
</div>
@endsection
