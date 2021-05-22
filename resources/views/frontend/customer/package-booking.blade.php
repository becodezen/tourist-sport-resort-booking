@extends('layouts.dashboard')

@section('dashboard.content')
<table class="table">
    <thead>
        <tr>
            <th>Booking No</th>
            <th>Check In</th>
            <th>Check Out</th>
            <th>Package</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @if($bookings->isNotEmpty())
            @foreach ($bookings as $key => $booking)
                <tr>
                    <td>{{ $booking->booking_no }}</td>
                    <td>{{ user_formatted_date($booking->assignPackage->check_in) }}</td>
                    <td>{{ user_formatted_date($booking->assignPackage->check_out) }}</td>
                    <td>
                        <a href="{{ route('fr.package.show', ['slug' => $booking->assignPackage->package->slug, 'assign_id' => $booking->assignPackage->id]) }}">{{ $booking->assignPackage->package->name }}</a>
                    </td>
                    <td>{{ $booking->status }}</td>
                    <td>

                    </td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="7">No Recent Package Booking Found</td>
            </tr>
        @endif
    </tbody>

</table>
@endsection
