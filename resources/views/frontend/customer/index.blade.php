@extends('layouts.dashboard')

@section('dashboard.content')

    <h4 class="dashboard-section-title mb-15"><i class="fas fa-user"></i> Personal Profile</h4>
    <div class="row">
        <div class="col-md-3">
            @if($customer->profile)
                @if($customer->profile->photo)
                    <img src="{{ asset($customer->profile->photo) }}" alt="">
                @else
                    <img src="{{ asset('frontend/assets/img/man.svg') }}" alt="">
                @endif
            @else
                <img src="{{ asset('frontend/assets/img/man.svg') }}" alt="">
            @endif
        </div>
        <div class="col-md-9">
            <table>
                <tr>
                    <th>Name</th>
                    <th>:</th>
                    <td>{{ $customer->name }}</td>
                </tr>
                <tr>
                    <th>Email</th>
                    <th>:</th>
                    <td>{{ $customer->email }}</td>
                </tr>
                <tr>
                    <th>Phone</th>
                    <th>:</th>
                    <td>{{ $customer->phone }}</td>
                </tr>
                @if($customer->profile)
                    <tr>
                        <th>Gender</th>
                        <th>:</th>
                        <td>{{ $customer->profile->gender }}</td>
                    </tr>
                    <tr>
                        <th>Address</th>
                        <th>:</th>
                        <td>{{ $customer->profile->address }}</td>
                    </tr>
                    <tr>
                        <th>NID/Passport</th>
                        <th>:</th>
                        <td>{{ $customer->profile->identity }}</td>
                    </tr>
                @endif
            </table>
        </div>
    </div>
    <h4 class="dashboard-section-title mt-30 mb-15"><i class="fas fa-history"></i> Recent Booking</h4>
    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Check In</th>
                <th>Check Out</th>
                <th>Resort</th>
                <th>Rooms</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @if($bookings->isNotEmpty())
                @foreach ($bookings as $key => $booking)
                    <tr>
                        <td>{{ $key+1 }}</td>
                        <td>{{ user_formatted_date($booking->check_in) }}</td>
                        <td>{{ user_formatted_date($booking->check_out) }}</td>
                        <td>
                            <a href="{{ route('fr.resort.show', $booking->resort->slug) }}">{{ $booking->resort->name }}</a>
                        </td>
                        <td>{{ $booking->room() }}</td>
                        <td>{{ $booking->status }}</td>
                        <td>

                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="7">No Recent Booking Found</td>
                </tr>
            @endif
        </tbody>
    </table>
@endsection
