@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <div class="box-header-content">
                        <h4 class="box-title">Bookind Details: #{{ $booking->invoice_no }}</h4>
                    </div>
                </div>
                <div class="box-body">
                    <div class="invoice">
                        <div class="invoice-header">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="logo">
                                        <h2>Vromon Bilash</h2>
                                    </div>
                                </div>
                                <div class="col-sm-6 text-right">
                                    <div class="resort-info">
                                        <h3>{{ $booking->resort->name }}</h3>
                                        <p>{{ $booking->resort->phone }}</p>
                                        <p>{{ $booking->resort->address }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="invoice-body pt-15 pb-10">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="guest-details">
                                        <h5>Guest</h5>
                                        <p> <span><i class="fas fa-user"></i></span>{{ $booking->guest->name }}</p>
                                        <p><span><i class="fas fa-mobile"></i></span>{{ $booking->guest->phone }}</p>
                                        @if($booking->guest->email)
                                            <p> <span><i class="fas fa-envelope"></i></span>{{ $booking->guest->email }}</p>
                                        @endif
                                        @if($booking->guest->address)
                                            <p> <span><i class="fas fa-map-marker"></i></span>{{ $booking->guest->address }}</p>
                                        @endif
                                        @if($booking->guest->identity)
                                            <p> <span><i class="fas fa-id-card"></i></span>{{ $booking->guest->identity }}</p>
                                        @endif

                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="invoice-details text-right">
                                        <h5>{{ $booking->invoice_no }} <strong>: Invoice No</strong></h5>
                                        <p>{{ user_formatted_date($booking->check_in) }}<strong>: Check In</strong></p>
                                        <p>{{ user_formatted_date($booking->check_out) }}<strong>: Check Out</strong></p>
                                    </div>
                                </div>
                            </div>
                            <div class="room-details mt-15">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Rooms</th>
                                        <th class="text-center">Days</th>
                                        <th class="text-center">Room Rent(Per Night)</th>
                                        <th class="text-right">Room Rent X Days</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($booking->bookingRooms as $key => $room)
                                        <tr>
                                            <td>{{ $key+1 }}</td>
                                            <td>{{ $room->room->name }}</td>
                                            @if($key === 0)
                                                <td class="text-center" rowspan="{{ count($booking->bookingRooms) }}">{{ $booking->diffInDays() }}</td>
                                            @endif
                                            <td class="text-center">{{ number_format($room->room_rate, 2) }}</td>
                                            <td class="text-right">{{ number_format($room->room_rate*$booking->diffInDays(), 2) }}</td>
                                        </tr>
                                    @endforeach
                                        <tr class="text-right">
                                            <td colspan="4">Sub Total</td>
                                            <td>{{ number_format($booking->sub_total, 2) }}</td>
                                        </tr>
                                        <tr class="text-right">
                                            <td colspan="4">Vat (15%)</td>
                                            <td>{{ number_format($booking->vat_amount, 2) }}</td>
                                        </tr>
                                        <tr class="text-right">
                                            <td colspan="4">Discount</td>
                                            <td>{{ number_format($booking->discount, 2) }}</td>
                                        </tr>
                                        <tr class="text-right">
                                            <td colspan="4">Grand Total</td>
                                            <td>{{ number_format($booking->grand_total, 2) }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="invoice-footer">

                        </div>
                    </div>
                </div>
                <div class="box-footer text-center">
                    @if($booking->status === 'pending')
                        <button class="btn btn-success" type="button" data-toggle="modal" data-target="#approvedModal">Approved</button>
                        <button class="btn btn-danger" type="button" data-toggle="modal" data-target="#cancelledModal">Cancelled</button>
                    @elseif($booking->status === 'approved')
                        <button class="btn btn-danger" type="button" data-toggle="modal" data-target="#cancelledModal">Cancelled</button>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="approvedModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Booking Approve ({{ $booking->invoice_no }})</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                {!! Form::open(['route' => ['booking.approved', $booking->id], 'method' => 'POST']) !!}
                <div class="modal-body">
                    <table class="table no-bordered">
                        <tr>
                            <th>Resort</th>
                            <td>{{ $booking->resort->name }}</td>
                        </tr>
                        <tr>
                            <th>Check in</th>
                            <td>{{ $booking->check_in }}</td>
                        </tr>
                        <tr>
                            <th>Check out</th>
                            <td>{{ $booking->check_out }}</td>
                        </tr>
                        <tr>
                            <th>Rooms</th>
                            <td>{{ $booking->room() }}</td>
                        </tr>
                        <tr>
                            <th>Guest</th>
                            <td>
                                {{ $booking->guest->name }} <br>
                                {{ $booking->guest->phone}} <br>
                                {{ $booking->guest->address}}
                            </td>
                        </tr>
                    </table>
                    <h4 class="text-danger text-center">Are you sure to approve?</h4>
                </div>
                <div class="modal-footer text-center">
                    <button type="submit" class="btn btn-success" onclick="formSubmit(this, event)">Confirm</button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
    <div class="modal fade" id="cancelledModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Booking Cancel({{ $booking->invoice_no }})</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                {!! Form::open(['route' => ['booking.approved', $booking->id], 'method' => 'POST']) !!}
                <div class="modal-body">
                    <table class="table no-bordered">
                        <tr>
                            <th>Resort</th>
                            <td>{{ $booking->resort->name }}</td>
                        </tr>
                        <tr>
                            <th>Check in</th>
                            <td>{{ $booking->check_in }}</td>
                        </tr>
                        <tr>
                            <th>Check out</th>
                            <td>{{ $booking->check_out }}</td>
                        </tr>
                        <tr>
                            <th>Rooms</th>
                            <td>{{ $booking->room() }}</td>
                        </tr>
                        <tr>
                            <th>Guest</th>
                            <td>
                                {{ $booking->guest->name }} <br>
                                {{ $booking->guest->phone}} <br>
                                {{ $booking->guest->address}}
                            </td>
                        </tr>
                    </table>
                    <h4 class="text-danger text-center">Are you sure to cancel?</h4>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-warning" onclick="formSubmit(this, event)">Confirm Cancelled</button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection
