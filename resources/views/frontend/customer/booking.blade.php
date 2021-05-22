@extends('layouts.dashboard')

@section('dashboard.content')
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
