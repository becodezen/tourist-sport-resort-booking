@extends('layouts.frontend')

@section('content')
    {{-- page-title --}}
    @include('partials._fr_page_title')

    <div class="resort-details-area pt-40 pb-40">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="resort-box">
                        <div class="resort-box-header">
                            <h5 class="resort-box-title">About {{ $resort->name }}</h5>
                        </div>
                        <div class="resort-box-body">
                            <div class="spot-sliders owl-carousel">
                                @if($resort->galleries)
                                    @foreach($resort->galleries as $gallery)
                                        <div class="spot-slider">
                                            <img src="{{ asset($gallery->image) }}" alt="">
                                            <div class="spot-slider-caption">
                                                <p>{{ $gallery->caption }}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            <div class="mt-15">
                                {{ $resort->short_description }}
                            </div>
                            {!! $resort->description !!}
                        </div>
                        <div class="resort-box-footer mt-20">
                            <div class="video-btn-group">
                                <button class="btn btn-sm">Video</button>
                                <i class="fas fa-play"></i>
                            </div>
                            <div class="video-btn-group mt-15">
                                <button class="btn btn-sm">3D Video</button>
                                <i class="fas fa-play"></i>
                            </div>
                        </div>
                    </div>

                    {{-- resort amenities --}}
                    <div class="resort-box">
                        <div class="resort-box-header">
                            <h5 class="resort-box-title">Facilities</h5>
                        </div>
                        <div class="resort-box-body">
                            <ul class="room-facilities">
                                @foreach ($resort->facilities as $facility)
                                    <li>{{ $facility->name }}</li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="resort-box-footer"></div>
                    </div>

                    <div class="resort-box">
                        <div class="resort-box-header">
                            <h5 class="resort-box-title">Rooms in this resort</h5>
                        </div>
                        <div class="resort-box-body">
                            @foreach ($resort->rooms as $room)
                                <div class="resort-room">
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div class="resort-room-gallery">
                                                @if($room->galleries)
                                                <div class="room-image-carousel owl-carousel">
                                                    @foreach ($room->galleries as $gallery)
                                                        <div class="room-image">
                                                            <img src="{{ asset($gallery->image) }}" alt="">
                                                        </div>
                                                    @endforeach
                                                </div>
                                                @else
                                                    <img src="{{ $room->thumbnail() }}" alt="">
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-lg-8">
                                            <div class="resort-room-content">
                                                <div class="resort-room-header">
                                                    <div class="resort-room-title">
                                                        <h3>{{ $room->category->room_type }} {{ $room->name }}</h3>
                                                        <strong>Max Guest: {{ $room->capacity }}</strong>
                                                    </div>
                                                    <div class="text-right resort-room-price">
                                                        <h3>{{ $room->regular_price }}/per night</h3>
                                                    </div>
                                                </div>
                                                <div class="resort-room-description">
                                                    {{ $room->facilityList() }}
                                                </div>
                                                <div class="text-right">
                                                    <a href="#" class="btn btn-primary btn-sm">Details <i class="fas fa-long-arrow-alt-right"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="resort-box-footer"></div>
                    </div>


                </div>
                <div class="col-md-4">
                    <div class="sidebar-box">
                        <div class="sidebar-box-header">
                            <h5 class="sidebar-box-title">Book in {{ $resort->name }}</h5>
                        </div>
                        <div class="sidebar-box-body">
                            {!! Form::open(['route' => ['fr.booking.store', $resort->slug], 'method' => 'POST']) !!}
                                <input type="hidden" name="resort_id" value="{{ $resort->id }}">
                                <div class="booking-form">
                                    <div class="form-group">
                                        <label for="">Check In</label>
                                        <div class="form-input-group">
                                            <i class="fas fa-calendar"></i>
                                            <input type="text" name="check_in" id="checkIn" autocomplete="off"  class="form-control check-in-datepicker datepicker" placeholder="yyyy-mm-dd" value="{{ $check_in ? database_formatted_date($check_in) : '' }}">
                                        </div>
                                        <span class="text-danger"></span>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Check Out</label>
                                        <div class="form-input-group">
                                            <i class="fas fa-calendar"></i>
                                            <input type="text" name="check_out" autocomplete="off" id="checkOut" class="form-control check-out-datepicker datepicker" placeholder="yyyy-mm-dd" value="{{ $check_out ? database_formatted_date($check_out) : '' }}">
                                        </div>
                                        <span class="text-danger"></span>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Guest</label>
                                        <div class="form-input-group">
                                            <i class="fas fa-users"></i>
                                            <input type="number" name="guest_capacity" min="1" id="guestCapacity" class="form-control" placeholder="e.g: 2" value="{{ $guest_number }}">
                                        </div>
                                        <span class="text-danger"></span>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Available Rooms</label>
                                        <div class="resort-rooms">
                                            @if($rooms)
                                                @foreach ($rooms as $room)
                                                    <div class="room">
                                                        <label class="room-label">
                                                            <div>
                                                                <input type="checkbox" name="rooms[]" class="room_id" value="{{ $room->id }}">
                                                                <span>{{ $room->name }} ({{ $room->capacity }})</span>
                                                            </div>
                                                            <span class="room_price">{{ $room->price() }}</span>
                                                        </label>
                                                    </div>
                                                @endforeach
                                                @else
                                                <p class="text-warning">No room found | Search again please</p>
                                            @endif
                                        </div>

                                        <span class="text-danger"></span>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Total Cost <span id="totalDays"></span></label>
                                        <div class="form-input-group">
                                            <i class="fas fa-dollar-sign"></i>
                                            <input type="text" name="total_cost" placeholder="0.00" class="form-control" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group form-group-submit mt-30">
                                        <button class="btn btn-primary w-100" type="button" id="bookNowModalBtn" disabled data-toggle="modal" data-target="#bookModal">Booked Now</button>
                                    </div>
                                </div>
                                @include('frontend.resort.booking-modal')
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <template id="roomTemplate">
        <tr>
            <td class="room_name"></td>
            <td class="room_price"></td>
        </tr>
    </template>
@endsection


@push('plugin-styles')
    <link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
@endpush

@push('plugin-scripts')
    <script src="{{ asset('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}"></script>
@endpush

@push('footer-scripts')
    <script>
        (function ($) {
            "use-strict"

            jQuery(document).ready(function () {

                //select2 multiple
                if($('.room_multiple_select2').length > 0) {
                    $('.room_multiple_select2').select2({
                        placeholder: "Select Room"
                    });
                }

                //bootstrap datepicker
                if ($('.check-in-datepicker').length > 0) {
                    $('.check-in-datepicker').datepicker({
                        format: 'yyyy-mm-dd',
                        todayHighlight: true,
                        autoclose: true,
                        autocomplete: true,
                        startDate: new Date(),
                        endDate: new Date(new Date().setDate(new Date().getDate() + 15))
                    });
                }

                if ($('.check-out-datepicker').length > 0) {
                    $('.check-out-datepicker').datepicker({
                        format: 'yyyy-mm-dd',
                        todayHighlight: true,
                        autoclose: true,
                        autocomplete: true,
                        startDate: new Date()
                    });
                }

                $(document).on('click', '#add-guest-btn', function () {
                    $('#guest_input').css({
                        display: 'flex'
                    });

                    $('#guests').hide();
                    $('.guest').prop('checked', false);
                    $('.guest-input').val(null);
                });

                $(document).on('click', '#close_guest_input', function () {
                    $('#guest_input').css({
                        display: 'none'
                    });

                    $('#guests').show();
                    $('.guest').prop('checked', false);
                    $('.guest-input').val(null);
                });



                $(document).on('click', '.search_destination', function () {
                    let destination = $(this).data('destination');
                    $('#destination').val(destination);
                    $('#destinationOptions').html('');
                });

                /* Destination list show */
                $(document).on('keyup','#resort', function () {
                    let resort = $(this).val();
                    const _token = $('input[name="_token"]').val();

                    if (resort.length > 0) {
                        $.ajax("{{ route('get.search.resort') }}", {
                            method: "POST",
                            data: {
                                _token: _token,
                                resort: resort
                            },
                            beforeSend: function (xhr) {
                                $('#resortsOptions').html('');
                            },
                            success: function(res, status, xhr) {
                                if(status === 'success') {
                                    if (res.status) {
                                        let resorts = res.data;
                                        $.each(resorts, function(i, resort){
                                            $('#resortsOptions').append(`<li class="search_resort" data-resort="${resort}">${resort}</li>`);
                                        });
                                    }else {
                                        $('#resortsOptions').html('');
                                    }
                                }
                            }
                        });
                    }else {
                        $('#resortsOptions').html('');
                    }
                });

                $(document).on('click', '.search_resort', function () {
                    let resort = $(this).data('resort');
                    $('#resort').val(resort);
                    $('#resortsOptions').html('');
                });

                //hide insidem
                $('#insideModal').hide();

                $('#verifyPhone').prop('disabled', true);

                $(document).on('keyup', '#guestPhone', function() {
                    const phone = $('#guestPhone').val();

                    if (phone.length > 10 && phone.length < 15) {
                        $('#verifyPhone').prop('disabled', false);
                        $('#otpPhone').html(phone);

                    } else {
                        $('#verifyPhone').prop('disabled', true);
                        $('#otpPhone').html('.........');
                    }
                });

                $(document).on('click', '#verifyPhone', function () {
                    const phone = $('#guestPhone').val();
                    const _token = $('input[name="_token"]').val();
                    const method = 'POST';

                    $.ajax("{{ route('otp.generate') }}", {
                        method: method,
                        data: {
                            _token:_token,
                            phone: phone
                        },
                        beforeSend: function (xhr) {
                            $('.test_otp').html('');
                        },
                        success: function (res, status, xhr) {
                            if (status === 'success') {
                                if (res.status) {
                                    $('.test_otp').html(res.otp.otp);
                                    $('#insideModal').show();
                                    Toast.fire({
                                        icon: 'success',
                                        title: 'Success',
                                        text: res.message
                                    })
                                } else {
                                    Toast.fire({
                                        icon: 'warning',
                                        title: 'Warning',
                                        text: res.message
                                    })
                                }
                            }
                        }
                    });

                });

                $(document).on('click', '#otpConfirmBtn', function () {
                    const phone = $('#guestPhone').val();
                    const otp = $('#otp').val();
                    const _token = $('input[name="_token"]').val();
                    const method = 'POST';

                    $.ajax("{{ route('guest.otp.verify') }}", {
                        method: method,
                        data: {
                            _token:_token,
                            phone: phone,
                            otp: otp
                        },
                        beforeSend: function (xhr) {
                            console.log('otp verifing');
                        },
                        success: function (res, status, xhr) {
                            if (status === 'success') {
                                if(res.status) {
                                    Toast.fire({
                                        icon: 'success',
                                        title: 'Congrates!',
                                        text: res.message
                                    }).then(function() {
                                        $('#insideModal').hide();
                                        $('#otpPhone, #test_otp').html('');
                                        $('#verifyPhone').attr('id', 'verified').html('<i class="fas fa-check"></i>');
                                        $('#guestPhone').prop('readonly',true);
                                        $('#guestBookingSubmit').prop('disabled',false);
                                    })
                                } else {
                                    Toast.fire({
                                        icon: 'warning',
                                        title: 'Failed',
                                        text: res.message
                                    })
                                }
                            }
                        }
                    });

                });

                $('#registerAsUser').hide();
                $(document).on('change', '#isUser', function () {
                    if($(this).is(':checked')) {
                        $('#registerAsUser').slideDown();
                    } else {
                        $('#registerAsUser').slideUp();
                        $('input[type="password"]').val('');
                    }
                });

                $(document).on('change', '.room_id', function () {
                    $('#roomList').html('');
                    let room_rent = 0;
                    let diff = 0;
                    //check in date
                    let check_in_date = $('#checkIn').val();
                    //check out date
                    let check_out_date = $('#checkOut').val();

                    if (check_in_date && check_out_date) {
                        const date_checkin = new Date(check_in_date);
                        const date_checkout = new Date(check_out_date);
                        diff = date_checkout.getTime() - date_checkin.getTime();
                    }

                    let day = diff/(1000*60*60*24)

                    $('.room_id').each(function(i){
                        if ($(this).is(':checked')) {
                            let this_room_rent = parseFloat($(this).closest('.room-label').children('.room_price').html());
                            room_rent += this_room_rent;

                            const roomElement = document.getElementById('roomList');
                            const roomTemplate = document.getElementById('roomTemplate');
                            const roomEl = document.importNode(roomTemplate.content, true);

                            roomEl.querySelector('.room_name').textContent = $(this).closest('div').children('span').html();
                            roomEl.querySelector('.room_price').textContent = $(this).closest('.room-label').children('.room_price').html()
                            roomElement.append(roomEl);
                        }

                    });

                    $('#room_info_check_in').html(check_in_date);
                    $('#room_info_check_out').html(check_out_date);
                    $('#sub_total').val(room_rent*day);
                    $('#grand_total').val(room_rent*day);

                    $('#totalDays').html('x '+day+' day');
                    $('input[name="total_cost"]').val(room_rent*day);

                    if (room_rent*day > 0) {
                        $('#bookNowModalBtn').prop('disabled', false);
                    } else {
                        $('#totalDays').html('')
                        $('#bookNowModalBtn').prop('disabled', true);
                    }

                });

                $(document).on('click', '.close-inside-modal', function() {
                    $('#insideModal').hide();
                });


                //load room information
                $(document).on('change', '#checkIn,  #checkOut, #guestCapacity', function () {
                    const check_in_date = $('#checkIn').val();
                    const check_out_date = $('#checkOut').val();
                    const guest_capacity = $('#guestCapacity').val();
                    const resort_id = $('input[name="resort_id"]').val();


                    if (check_in_date !== '' && check_out_date !== '') {
                        const _token = $('input[name="_token"]').val();
                        const method = 'POST';

                        $.ajax("{{ route('get.resort.room') }}", {
                            method: method,
                            data: {
                                resort_id: resort_id,
                                check_in: check_in_date,
                                check_out: check_out_date,
                                guest_capacity: guest_capacity,
                                _token: _token
                            },
                            beforeSend: function (xhr) {
                                $('.resort-rooms').html(`available room loading...`);
                                $('input[name="total_cost"]').val(null);
                            },
                            success: function (res, status, xhr) {
                                if (status === 'success') {
                                    if (res.status) {
                                        $('.resort-rooms').html(res.rooms)
                                    } else {
                                        $('.resort-rooms').html(res.message)
                                    }
                                }
                            }
                        });

                    }
                });

                if ($('.spot-sliders').length > 0) {
                   $('.spot-sliders').owlCarousel({
                        items: 1,
                        margin: 0,
                        autoplay: true,
                        autoplayTimeout:5000,
                        animateOut: 'fadeOut',
                        animateIn: 'fadeIn',
                        loop: true,
                        smartSpeed: 1000
                   })
               }

            });

        }(jQuery))
    </script>
@endpush
