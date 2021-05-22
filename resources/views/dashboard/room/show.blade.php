@extends('layouts.master')

@section('content')
    <div class="box">
        <div class="box-header with-border">
            <div class="box-header-content">
                <h4 class="box-title">Rooms Details: {{ $room->name }}</h4>
            </div>
            <div class="action">
                <a href="{{ route('room.photo.gallery', $room->id) }}" class="btn btn-outline-success">Photo Gallery</a>
                <a href="{{ route('room.edit', $room->id) }}" class="btn btn-primary">Update</a>
                <a href="{{ route('room.list') }}" class="btn btn-dark">Room List</a>
            </div>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-lg-6">
                    <h4 class="view-section-title">Room General Information</h4>
                    <table class="table table-sm table-bordered">
                        <tr>
                            <th>Resort</th>
                            <td>{{ $room->resort->name }}</td>
                        </tr>
                        <tr>
                            <th>Room Category</th>
                            <td>{{ $room->category->full_name }}</td>
                        </tr>
                        <tr>
                            <th>Size</th>
                            <td>{{ $room->size.(' square_feet') }}</td>
                        </tr>
                        <tr>
                            <th>Capacity</th>
                            <td>{{ $room->capacity }}</td>
                        </tr>
                        <tr>
                            <th>Regular Price</th>
                            <td>{{ $room->regular_price }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-lg-6">
                    <h4 class="view-section-title">Room Facilities</h4>
                    <ul>
                        @foreach($room->facilities as $facility)
                            <li>{{ $facility->name }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>


            <h4 class="view-section-title">Room Seasonal Price</h4>
            @if($room->seasonPrices)
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Season</th>
                        <th>Date</th>
                        <th>Price</th>
                        <th>Holiday Price</th>
                        <th>Weekend Price</th>
                        <th>Acton</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($room->seasonPrices as $key => $season)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $season->season->name }}</td>
                                <td>{{ $season->season->from_date }} to {{ $season->season->to_date }}</td>
                                <td>{{ $season->price }}</td>
                                <td>{{ $season->holiday_price }}</td>
                                <td>{{ $season->weekend_price }}</td>
                                <td></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
        <div class="box-footer">

        </div>
    </div>
@endsection
