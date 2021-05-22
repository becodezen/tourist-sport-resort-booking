@extends('layouts.master')

@section('content')
    <div class="box">
        <div class="box-header with-border">
            <div class="box-header-content">
                <h4 class="box-title">Rooms list</h4>
            </div>
            <div class="action">
                <a href="{{ route('room.create') }}" class="btn btn-primary">Add New</a>
            </div>
        </div>
        <div class="box-body">
            <table class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th>#</th>
                    {{-- @if($user_type === 'system_user')
                        <td>Resort</td>
                    @endif--}}
                    <th>Resort</th>
                    <th>Room</th>
                    <th>Category</th>
                    <th>Capacity</th>
                    <th>Regular Prices</th>
                    <th>Weekend Price</th>
                    <th>Holiday Price</th>
                    <th>Seasonal Prices</th>
                    <th style="width:120px">Action</th>
                </tr>
                </thead>
                @if($rooms->isNotEmpty())
                    <tbody>
                        @foreach($rooms as $key => $room)
                            <tr>
                                <td>{{ $key+1 }}</td>
                               {{-- @if($user_type === 'system_user')
                                    <td>{{ $room->resort->name }}</td>
                                @endif--}}
                                <td>{{ $room->resort->name }}</td>
                                <td>{{ $room->name }}</td>
                                <td>{{ $room->category->full_name }}</td>
                                <td>{{ $room->capacity }}</td>
                                <td>{{ $room->regular_price }}</td>
                                <td>{{ $room->weekend_price }}</td>
                                <td>{{ $room->holiday_price }}</td>
                                <td>
                                    @if($room->seasonPrices)
                                        <div class="season_prices">
                                            @foreach($room->seasonPrices as $s_price)
                                                <p>
                                                    <span>{{ $s_price->season->name }}</span>
                                                    <span><abbr title="Regular Price">RP</abbr>-{{ $s_price->price }}</span>
                                                    <span><abbr title="Holiday Price">HP</abbr>-{{ $s_price->holiday_price }}</span>
                                                    <span><abbr title="Weekend Price">WP</abbr>-{{ $s_price->weekend_price }}</span>
                                                </p>
                                            @endforeach
                                        </div>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    <div class="action-group">
                                        <a href="{{ route('room.photo.gallery', $room->id) }}" class="btn btn-sm btn-info" data-toggle="tooltip" data-placement="top" title="Room Image">
                                            <i class="fas fa-image"></i>
                                        </a>
                                        <a href="{{ route('room.show', $room->id) }}" class="btn btn-sm btn-success" data-toggle="tooltip" data-placement="top" title="View Details">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('room.edit', $room->id) }}" class="btn btn-sm btn-primary" data-toggle="tooltip" data-placement="top" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        {!! Form::open(['route' => ['room.delete', $room->id], 'method' => 'DELETE']) !!}
                                        <button class="btn btn-sm btn-danger" data-toggle="tooltip" data-placement="top" title="Delete" onclick="deleteSubmit(this, event)">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                        {!! Form::close() !!}
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                @endif
            </table>
        </div>
        <div class="box-footer">
            {{ $rooms->links() }}
        </div>
    </div>
@endsection
