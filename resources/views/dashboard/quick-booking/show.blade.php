@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-lg-8 col-md-12 offset-2">
            <div class="box">
                <div class="box-header with-border">
                    <div class="box-header-content">
                        <h4 class="box-title">Bookind Details: #{{ $booking->invoice_no }}</h4>
                    </div>
                    <div class="action">
                        <a href="{{ route('booking.invoice', $booking->id) }}" class="btn btn-primary">Invoice Print</a>
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
                                    <div class="invoice-details">
                                        <h5>Invoice: {{ $booking->invoice_no }}</h5>
                                        <p><strong>Check In :</strong> {{ user_formatted_date($booking->check_in) }}</p>
                                        <p><strong>Check In :</strong> {{ user_formatted_date($booking->check_out) }}</p>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="guest-details text-right">
                                        <h5>Guest</h5>
                                        <p>{{ $booking->guest->name }} <span><i class="fas fa-user"></i></span></p>
                                        <p>{{ $booking->guest->phone }} <span><i class="fas fa-mobile"></i></span></p>
                                        @if($booking->guest->address)
                                            <p>{{ $booking->guest->address }} <span><i class="fas fa-map-marker"></i></span></p>
                                        @endif
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
                            <h3>Terms & Condition</h3>

                        </div>
                    </div>
                </div>
                <div class="box-footer text-center">
                    <button class="btn btn-primary"><i class="fas fa-print"></i> Print</button>
                </div>
            </div>
        </div>
    </div>
@endsection
