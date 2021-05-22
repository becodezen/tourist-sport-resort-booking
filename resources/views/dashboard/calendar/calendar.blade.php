@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-md-3">
            <div class="box">
                <div class="box-header with-border">
                    <h4 class="box-title">Resort: {{ $resort->name }}</h4>
                </div>
                <div class="box-body">
                    <div class="rooms">
                        @foreach($resort->rooms as $key => $room)
                            <div class="single-room{{ $b_room->id == $room->id ? ' active' : '' }}" data-room_id="{{ $room->id }}">
                                <strong>ROOM: {{ $room->name }}</strong>
                                <span>{{ $room->price() }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="box">
                <div class="box-header with-border">
                    <h4 class="box-title">Booking Calendar</h4>
                </div>
                <div class="box-body">
                    <div class="calendar">
                        <div class="calendar-header">
                            @csrf
                            <div class="calendar-prev calendar-control" title="{{ $prev_month }}" data-month="{{ $prev_month }}">
                                <i class="fas fa-angle-left"></i>
                            </div>
                            <div class="calendar-title current_date">
                                <strong>{{ $month }} - {{ $year }}</strong>
                            </div>
                            <div class="calendar-next calendar-control" title="{{ $next_month }}" data-month="{{ $next_month }}">
                                <i class="fas fa-angle-right"></i>
                            </div>
                        </div>
                        <div class="calendar-body mt-15">
                            <div class="days">
                                <div class="day"><strong>SAT</strong></div>
                                <div class="day"><strong>SUN</strong></div>
                                <div class="day"><strong>MON</strong></div>
                                <div class="day"><strong>TUE</strong></div>
                                <div class="day"><strong>WED</strong></div>
                                <div class="day"><strong>THU</strong></div>
                                <div class="day weekend"><strong>FRI</strong></div>
                            </div>
                            <div class="dates" id="dates">
                                @for($i=1;$i<=$day_name_arr[$start_day_name];$i++)
                                    @if($i == $day_name_arr[$start_day_name])
                                        @for($d=1;$d<=$days;$d++)
                                            <div class="date" data-toggle="modal" data-target=".day-modal">
                                                <strong>{{ $d }}</strong>
                                            </div>
                                        @endfor
                                        @else
                                        <div class="date inactive"></div>
                                    @endif
                                @endfor
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade day-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Booking Modal</h5>
                </div>
                <div class="modal-body"></div>
                <div class="modal-footer"></div>
            </div>
        </div>
    </div>
@endsection

@push('footer-scripts')
    <script>
        (function ($) {
            "use-strict"

            jQuery(document).ready(function () {
                //onclick calendar control
                $(document).on('click', '.calendar-control', function () {
                    let _date = $(this).data('month');
                    let _token = $('input[name="_token"]').val();

                    $.ajax("{{ route('get.room.booking.calendar') }}", {
                        method: 'POST',
                        data: {
                            calendarDate:_date,
                            _token:_token
                        },
                        beforeSend:function (xhr) {
                            console.log('Loading..........')
                        },
                        success: function (res, status, xhr) {
                            if (status === 'success') {
                                $('#dates').html(res.html);
                                $('.calendar-prev').data('month', res.data.prev_month)
                                $('.calendar-prev').attr('title', res.data.prev_month)
                                $('.calendar-next').data('month', res.data.next_month)
                                $('.calendar-next').attr('title', res.data.next_month)
                                $('.current_date').children('strong').html(res.data.month +' - '+ res.data.year);
                            }
                        },
                        errors: function (jqXhr, textStatus, errorMessage) {
                            console.log(textStatus);
                        }
                    });
                });
            })
        }(jQuery))
    </script>
@endpush
