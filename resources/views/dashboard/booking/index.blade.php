@extends('layouts.master')

@section('content')
    <div class="box">
        <div class="box-header with-border">
            <div class="box-header-content">
                <h4 class="box-title">Booking List</h4>
            </div>
            {!! Form::open(['method' => 'POST']) !!}
                Filter By
                {!! Form::select('filter_by', [
                    'all' => 'All',
                    'customer' => 'Customer',
                    'guest' => 'Guest',
                    'admin' => 'Admin',
                    'resort' => 'Resort'
                ], $filter_by, ['class' => 'form-control-filter-by', 'id' => 'filterBy']) !!}
            {!! Form::close() !!}
            <div class="action">
                <a href="{{ route('booking.create') }}" class="btn btn-primary">New Booking</a>
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
                        <th>Book By</th>
                        <th>Status</th>
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
                            <td>{{ $booking->guest->name }} <br> {{ $booking->guest->phone }}</td>
                            <td><abbr title="{{ $booking->room() }}">{{ count($booking->rooms) }}</abbr></td>
                            <td>{{ user_formatted_date($booking->check_in).' to '.user_formatted_date($booking->check_out) }}</td>
                            <td>{{ $booking->diffInDays() }}</td>
                            <td><span class="">{{ Str::ucfirst($booking->booked_by) }}</span></td>
                            <td><span class="">{!! $booking->bookingStatus() !!}</span></td>
                            <td>
                                <div class="action-group">
                                    <a href="{{ route('booking.invoice', $booking->id) }}" class="btn btn-sm btn-primary" data-toggle="tooltip" data-placement="top" title="Invoice Print">
                                        <i class="fas fa-print"></i>
                                    </a>
                                    <a href="{{ route('booking.show', $booking->id) }}" class="btn btn-sm btn-success" data-toggle="tooltip" data-placement="top" title="Show Details">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    {!! Form::open(['route' => ['booking.delete', $booking->id], 'method' => 'DELETE']) !!}
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


@push('footer-scripts')
    <script>
        (function($){
            "use-strict"

            jQuery(document).ready(function() {
                $(document).on('change', '#filterBy', function() {
                    const booking_filter = $(this).val();

                    if (booking_filter === 'all') {
                        redirect("{{ route('booking.list') }}")
                    }

                    if (booking_filter === 'guest') {
                        redirect("{{ route('booking.guest.list') }}")
                    }

                    if (booking_filter === 'customer') {
                        redirect("{{ route('booking.customer.list') }}")
                    }

                    if (booking_filter === 'resort') {
                        redirect("{{ route('booking.resort.list') }}")
                    }

                    if (booking_filter === 'admin') {
                        redirect("{{ route('booking.admin.list') }}")
                    }
                })
            });

        }(jQuery))
    </script>
@endpush
