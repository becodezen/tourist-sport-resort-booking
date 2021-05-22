@extends('layouts.master')

@section('content')
    <div class="box">
        <div class="box-header with-border">
            <div class="box-header-content">
                <h4 class="box-title">Quick Booking List</h4>
            </div>
            <div class="action">
                <a href="{{ route('quick.booking.create') }}" class="btn btn-primary">New Booking</a>
            </div>
        </div>
        <div class="box-body">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Invoice</th>
                        <th>Resort</th>
                        <th>Guest</th>
                        <th>Room</th>
                        <th>Date</th>
                        <th>Day</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                @if($bookings)
                    @foreach($bookings as $key => $booking)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>#{{ $booking->invoice_no }}</td>
                            <td>{{ $booking->resort->name }}</td>
                            <td>
                                <p>{{ $booking->guest->name }}</p>
                                <p>{{ $booking->guest->phone }}</p>
                                <p>{{ $booking->guest->address }}</p>
                            </td>
                            <td>{{ $booking->room() }}</td>
                            <td>{{ user_formatted_date($booking->check_in).' to '.user_formatted_date($booking->check_out) }}</td>
                            <td>{{ $booking->diffInDays() }}</td>
                            <td>
                                <div class="action-group">
                                    <a href="{{ route('quick.booking.invoice', $booking->id) }}" class="btn btn-sm btn-primary" data-toggle="tooltip" data-placement="top" title="Invoice Print">
                                        <i class="fas fa-print"></i>
                                    </a>
                                    <a href="{{ route('quick.booking.show', $booking->id) }}" class="btn btn-sm btn-success" data-toggle="tooltip" data-placement="top" title="Show Details">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    {!! Form::open(['route' => ['quick.booking.delete', $booking->id], 'method' => 'DELETE']) !!}
                                    <button class="btn btn-sm btn-danger" data-toggle="tooltip" data-placement="top" title="Delete" onclick="deleteSubmit(this, event)">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                {!! Form::close() !!}
                                </div>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="6">No Booking Yet</td>
                    </tr>
                @endif
                </tbody>
            </table>
        </div>
        <div class="box-footer">
            {{ $bookings->links() }}
        </div>
    </div>
@endsection
