@extends('layouts.master')

@section('content')
    <div class="box">
        <div class="box-header with-border">
            <div class="box-header-content">
                <h4 class="box-title">New Booking</h4>
            </div>
            <div class="action">
                <a href="{{ route('booking.list') }}" class="btn btn-primary">Booking List</a>
            </div>
        </div>
        {!! Form::open(['route' => 'booking.store', 'method' => 'POST', 'class' => 'booking-form']) !!}
        <div class="box-body">
            <div class="form-section">
                <h4 class="form-title">Room Information</h4>
                <div class="row">
                    <div class="col-md-6">
                        @if($user_type === 'system_user')
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Resort</label>
                            <div class="col-sm-8">
                                {!! Form::select('resort', formSelectOptions($resorts), [], ['placeholder' => 'Select Resort', 'class' => 'form-control', 'id' => 'resort']) !!}
                                <span class="text-danger"></span>
                            </div>
                        </div>
                        @elseif ($user_type === 'resort_user')
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">Resort</label>
                                <div class="col-sm-8">
                                    <input type="hidden" name="resort" value="{{ $resorts->id }}" id="resort">
                                    <input type="text" value="{{ $resorts->name }}" class="form-control" readonly>
                                    <span class="text-danger"></span>
                                </div>
                            </div>
                        @endif
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Check In</label>
                            <div class="col-sm-8">
                                <input type="text" name="check_in" id="checkIn" class="form-control datepicker" placeholder="YYYY-MM-DD" autocomplete="off">
                                <span class="text-danger"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Check Out</label>
                            <div class="col-sm-8">
                                <input type="text" name="check_out" id="checkOut" class="form-control datepicker" placeholder="YYYY-MM-DD" autocomplete="off">
                                <span class="text-danger"></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Room Type</label>
                            <div class="col-sm-8">
                                {!! Form::select('room_category', formSelectOptions($categories, 'id', 'full_name'), null, ['class' =>'form-control', 'id' => 'room_category', 'multiple']) !!}
                                <span class="text-danger"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Capacity</label>
                            <div class="col-sm-8">
                                <input type="number" name="capacity" placeholder="e.g. 2" id="" class="form-control">
                                <span class="text-danger"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-section">
                <h4 class="form-title">Available Rooms</h4>
                <div class="row">
                    <div class="col-md-12">
                        <div id="rooms">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Room</th>
                                        <th>Type</th>
                                        <th>Price</th>
                                        <th>Facilities</th>
                                    </tr>
                                </thead>
                                <tbody id="room_list">
                                    <tr>
                                        <td colspan="5">No Room Display</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-8">
                    <div class="form-section">
                        <h4 class="form-title">Guest Information</h4>
                        <div class="row">
                            <div class="col-md-6">
                                <input type="hidden" name="guest_id">
                                <div class="form-group row" id="newGuest">
                                    <label class="col-sm-4 col-form-label">Name</label>
                                    <div class="col-sm-8">
                                        <input type="text" name="guest_name" class="form-control" placeholder="Guest name">
                                        <span class="text-danger"></span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Phone</label>
                                    <div class="col-sm-8 has-guest-list">
                                        <input type="text" name="guest_phone" class="form-control" placeholder="Guest phone" id="guest_phone" autocomplete="off">
                                        <span class="text-danger"></span>
                                        <ul id="guestList"></ul>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Adult</label>
                                    <div class="col-sm-8">
                                        <input type="number" name="adult_member" min="0" max="50" placeholder="Adult member" id="adultMember" class="form-control">
                                        <span class="text-danger"></span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Child</label>
                                    <div class="col-sm-8">
                                        <input type="number" name="child_member" min="0" max="50" placeholder="Child member" id="childMember" class="form-control">
                                        <span class="text-danger"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Email</label>
                                    <div class="col-sm-8">
                                        <input type="text" name="email" class="form-control" placeholder="Guest email" id="guest_email">
                                        <span class="text-danger"></span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Company</label>
                                    <div class="col-sm-8">
                                        <input type="text" name="company" placeholder="Guest company name" class="form-control" id="guest_company">
                                        <span class="text-danger"></span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Address</label>
                                    <div class="col-sm-8">
                                        <input type="text" name="address" placeholder="Guest Address" class="form-control" id="guest_address">
                                        <span class="text-danger"></span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">NID/Passport</label>
                                    <div class="col-sm-8">
                                        <input type="text" name="identity" placeholder="NID or Password No" class="form-control" id="guest_identity">
                                        <span class="text-danger"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-section">
                        <h4 class="form-title">Billing Information</h4>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Address</label>
                            <div class="col-sm-8">
                                <input type="text" name="bill_address" class="form-control" placeholder="Enter address">
                                <span class="text-danger"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">City</label>
                            <div class="col-sm-8">
                                <input type="text" name="bill_city" class="form-control" placeholder="Enter city">
                                <span class="text-danger"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Country</label>
                            <div class="col-sm-8">
                                <input type="text" name="bill_country" placeholder="Select country" id="" class="form-control">
                                <span class="text-danger"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Post Code</label>
                            <div class="col-sm-8">
                                <input type="text" name="bill_postal_code" placeholder="Enter postal code" id="" class="form-control">
                                <span class="text-danger"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-section" id="members">
                <h4 class="form-title">Members</h4>
                <table class="table table-hover table-striped" id="memberList"></table>
            </div>
            <div class="form-section">
                <h4 class="form-title">Payment</h4>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Room Rent</label>
                            <div class="col-sm-8">
                                <input type="text" name="room_rent" placeholder="0.00" id="roomRent" class="form-control" readonly>
                            </div>
                        </div>
{{--                        <div class="form-group row">--}}
{{--                            <label class="col-sm-4 col-form-label">Service Rent</label>--}}
{{--                            <div class="col-sm-8">--}}
{{--                                <input type="text" name="Service Rent" placeholder="0.00" id="serviceRent" class="form-control" readonly>--}}
{{--                            </div>--}}
{{--                        </div>--}}
                        <div id="roomRentDetails"></div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Sub Total</label>
                            <div class="col-sm-8">
                                <input type="text" name="sub_total" placeholder="0.00" id="subTotal" class="form-control" readonly>
                            </div>
                        </div>
                        {{-- <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Tax <span id="tax">15</span>%</label>
                            <div class="col-sm-8">
                                <input type="text" name="tax" placeholder="0.00" id="taxAmount" class="form-control" readonly>
                            </div>
                        </div> --}}
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Discount</label>
                            <div class="col-sm-8">
                                <input type="text" name="discount" placeholder="0.00" id="discount" class="form-control">
                                <span class="text-danger"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Grand Total</label>
                            <div class="col-sm-8">
                                <input type="text" name="grand" placeholder="0.00" id="grandTotal" class="form-control" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Paid</label>
                            <div class="col-sm-8">
                                <input type="text" name="paid_amount" placeholder="0.00" id="paidAmount" class="form-control">
                                <span class="text-danger"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Balance</label>
                            <div class="col-sm-8">
                                <input type="text" name="balance" placeholder="0.00" id="balance" class="form-control">
                                <span class="text-danger"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Payment Method</label>
                            <div class="col-sm-8">
                                {!! Form::select('payment_method', getPaymentMethods(), null, ['placeholder' => 'Select Payment', 'class' =>'form-control']) !!}
                                <span class="text-danger"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-right">
                <button type="submit" class="btn btn-success" onclick="formSubmit(this, event)">Submit & Confirm Booking</button>
            </div>
        </div>
        <div class="box-footer text-right">
        </div>
        {!! Form::close() !!}
    </div>
    <template id="roomTemplate">
        <tr>
            <td><input type="checkbox" class="room_id" name="rooms[]" id=""></td>
            <td class="room_name"><label for=""></label></td>
            <td class="room_type"></td>
            <td class="room_price"></td>
            <td class="room_facility"></td>
        </tr>
    </template>

    <template id="guestListTemplate">
        <li class="guest" data-guest_id="">
            <p></p>
            <span></span>
        </li>
    </template>

    <template id=adultMemberTemplate">
        <tr class="adult">
            <td><input type="hidden" name="member_adult[]" class="member_numbers"> <span>Adult</span></td>
            <td><input type="text" name="member_name[]" placeholder="Member name" class="form-control"></td>
            <td><input type="text" name="member_age[]" placeholder="Member age" class="form-control"></td>
            <td><input type="text" name="member_phone[]" placeholder="Member phone" class="form-control"></td>
            <td><input type="text" name="member_address[]" placeholder="Member address" class="form-control"></td>
            <td><input type="text" name="member_identity[]" placeholder="Member NID/Passport" class="form-control"></td>
        </tr>
    </template>

    <template id="childMemberTemplate">
        <tr class="child">
            <td><input type="hidden" name="member_child[]"> <span>Child</span></td>
            <td><input type="text" name="member_name[]" placeholder="Member name" class="form-control"></td>
            <td><input type="text" name="member_age[]" placeholder="Member age" class="form-control"></td>
            <td colspan="3"></td>
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
        (function($){
            "use-strict"

            jQuery(document).ready(function() {

                //bootstrap datepicker
                if ($('.datepicker').length > 0) {
                    $('.datepicker').datepicker({
                        format: 'yyyy-mm-dd',
                        todayHighlight: true,
                        autoclose: true,
                        autocomplete: true,
                        startDate: new Date(),
                    });
                }

                //select2 multiple
                if($('#room_category').length > 0) {
                    $('#room_category').select2({
                        placeholder: "Select Category"
                    });
                }

                if($('#resort').length > 0) {
                    $('#resort').select2({
                        placeholder: "Select Resort"
                    });
                }

                //select2
                if($('#guest_exists').length > 0) {
                    $('#guest_exists').select2({
                        placeholder: "Select Guest",
                        allowClear: true
                    });
                }

                $('#existsGuest').slideUp();

                //existing or new guest option
                $(document).on('change', '#guestType', function () {
                    if ($(this).val() === 'exists') {
                        $('#existsGuest').slideDown();
                        $('#newGuest').slideUp();
                    } else {
                        $('#existsGuest').slideUp();
                        $('#newGuest').slideDown();
                    }
                });

                $(document).on('change', '#guest_exists', function () {
                    const guest_id = $(this).val();
                    const _token = $('input[name="_token"]').val();
                    const resort_id = 1;
                    const method = 'POST'

                    if (guest_id) {
                        $.ajax("{{ route('get.guests') }}", {
                            method: method,
                            data: {
                                resort_id: resort_id,
                                _token: _token,
                                guest_id: guest_id
                            },
                            beforeSend: function (xhr) {
                                console.log('guest loading.......');
                            },
                            success: function (res, status, xhr) {
                                if (res.status === 'success') {
                                    guest = res.data;
                                    $('#guest_phone').val(guest.phone);
                                    $('#guest_email').val(guest.email);
                                    $('#guest_company').val(guest.company);
                                    $('#guest_address').val(guest.address);
                                    $('#guest_identity').val(guest.identity);
                                }
                            },
                        });
                    } else {
                        $('#guest_phone, #guest_email, #guest_company, #guest_address, #guest_identity').val(null);
                    }
                });

                $('#members').hide();


                $(document).on('keyup change', '#adultMember', function () {
                    let adult_members = $(this).val();
                    $('.adult').remove();


                    if (adult_members > 0) {
                        let max = 0;
                        $('#members').show();
                        while (adult_members > 0 && max < 50) {
                           const adultEl = `<tr class="adult">
                                                <td><input type="hidden" name="member_adult[]" class="member_numbers" value="${adult_members}"> <span>Adult</span></td>
                                                <td><input type="text" name="adult_name[]" placeholder="Member name" class="form-control"></td>
                                                <td><input type="text" name="adult_age[]" placeholder="Member age" class="form-control"></td>
                                                <td><input type="text" name="adult_phone[]" placeholder="Member phone" class="form-control"></td>
                                                <td><input type="text" name="adult_address[]" placeholder="Member address" class="form-control"></td>
                                                <td><input type="text" name="adult_identity[]" placeholder="Member NID/Passport" class="form-control"></td>
                                            </tr>`;

                            $('#memberList').append(adultEl);

                            adult_members--;
                            max++;

                        }
                    } else {
                        if (!$('.child').length > 0) {
                            $('#members').hide();
                        }
                    }
                })

                $(document).on('keyup change', '#childMember', function () {
                    let child_members = $(this).val();
                    $('.child').remove();

                    if (child_members > 0) {
                        let max = 0;
                        $('#members').show();
                        while (child_members > 0 && max < 50) {
                            const childEl = `<tr class="child">
                                                <td><input type="hidden" name="member_child[]" value="${child_members}"> <span>Child</span></td>
                                                <td><input type="text" name="child_name[]" placeholder="Member name" class="form-control"></td>
                                                <td><input type="text" name="child_age[]" placeholder="Member age" class="form-control"></td>
                                                <td colspan="3"></td>
                                            </tr>`;

                            $('#memberList').append(childEl);

                            child_members--;
                            max++;
                        }
                    }else {
                        if (!$('.adult').length > 0) {
                            $('#members').hide();
                        }
                    }
                })

                //load room information
                $(document).on('change', '#room_category, #checkIn,  #checkOut, #resort', function () {
                    const category_id =$('#room_category').val();
                    const check_in_date = $('#checkIn').val();
                    const check_out_date = $('#checkOut').val();
                    const resort_id = $('#resort').val();


                    if (category_id !== '' && check_in_date !== '' && check_out_date !== '' && resort_id !== '') {
                        const _token = $('input[name="_token"]').val();
                        const method = 'POST';

                        $.ajax("{{ route('get.rooms') }}", {
                            method: method,
                            data: {
                                resort_id: resort_id,
                                category_id: category_id,
                                check_in: check_in_date,
                                check_out: check_out_date,
                                _token: _token
                            },
                            beforeSend: function (xhr) {
                                $('#room_list').html(`<tr>
                                    <td colspan="4">Room Loading..........</td>
                                </tr>`);
                                room_rent_calcution();
                            },
                            success: function (res, status, xhr) {
                                if (res.status === 'success') {
                                    let rooms = res.data;
                                    let prices = res.prices;

                                    const roomElement = document.getElementById('room_list');
                                    const roomTemplate = document.getElementById('roomTemplate');

                                    if (rooms.length > 0) {
                                        $('#room_list').html('');

                                        for (const room of rooms) {
                                            const facilities = room.facilities;

                                            let facility = facilities.map(function(elem){
                                                return elem.name;
                                            }).join(", ");

                                            const roomEl = document.importNode(roomTemplate.content, true);
                                            roomEl.querySelector('.room_id').value = room.id;
                                            roomEl.querySelector('.room_id').setAttribute('id', 'room_'+room.id);
                                            roomEl.querySelector('.room_name label').textContent = room.name;
                                            roomEl.querySelector('.room_name label').setAttribute('for', 'room_'+room.id);
                                            roomEl.querySelector('.room_type').textContent = room.category.full_name;

                                            let se_price = jQuery.grep(prices, function(room_price) {
                                                    return room_price.room_id === room.id
                                                });

                                            if (se_price.length > 0) {
                                                roomEl.querySelector('.room_price').textContent = se_price[0].price;
                                            } else {
                                                roomEl.querySelector('.room_price').textContent = room.regular_price;
                                            }

                                            roomEl.querySelector('.room_facility').textContent = facility;
                                            roomElement.append(roomEl);
                                        }
                                    } else {
                                        $('#room_list').html(`<tr>
                                            <td colspan="4">No Room Found</td>
                                        </tr>`);
                                    }
                                }
                            }
                        });

                    } else {
                        $('#room_list').html(`<tr>
                            <td colspan="4">No Room Display</td>
                        </tr>`);
                    }

                    //RESET GUEST INFORMATION
                    $('input[name="guest_id"]').val('');
                    $('input[name="guest_name"]').val('');
                    $('#guest_phone').val('');
                    $('#guest_email').val('');
                    $('#guest_company').val('');
                    $('#guest_address').val('');
                    $('#guest_identity').val('');
                });

                //calculation of rent
                $(document).on('change', '.room_id', function () {
                    room_rent_calcution();
                });

                $(document).on('keyup', '#discount', function () {
                    room_rent_calcution();
                });

                $(document).on('change', '#checkIn, #checkOut', function () {
                    room_rent_calcution();
                });

                $(document).on('keyup', '#paidAmount', function () {
                    let paid = parseFloat($('#paidAmount').val()) || 0;
                    let grand_total = parseFloat($('#grandTotal').val()) || 0;
                    let balance = grand_total - paid;
                    $('#balance').val(balance);
                });

                //guest list find
                $(document).on('keyup', '#guest_phone', function () {
                    const phone =$(this).val();
                    const resort_id = $('#resort').val();

                    if (phone.length > 2 && resort_id) {
                        const _token = $('input[name="_token"]').val();
                        const method = 'POST';

                        $.ajax("{{ route('get.guest.list') }}", {
                            method: method,
                            data: {
                                resort_id: resort_id,
                                phone: phone,
                                _token: _token
                            },
                            beforeSend: function (xhr) {
                                $('#guestList').html('');
                            },
                            success: function (res, status, xhr) {
                                if (res.status) {
                                    let guests = res.data;

                                    const guestElement = document.getElementById('guestList');
                                    const guestTemplate = document.getElementById('guestListTemplate');

                                    if (guests.length > 0) {

                                        $('#guestList').show();

                                        for (const guest of guests) {
                                            console.log(guest);

                                            const guestEl = document.importNode(guestTemplate.content, true);
                                            guestEl.querySelector('li').setAttribute('data-guest_id', guest.id);
                                            guestEl.querySelector('p').textContent = guest.name;
                                            guestEl.querySelector('span').textContent = guest.phone
                                            guestElement.append(guestEl);
                                        }
                                    }
                                }
                            }
                        });
                    } else {
                        $('#guestList').html('');
                        $('#guestList').show();
                    }
                });

                //guest list find
                $(document).on('click', '.guest', function () {
                    const guest_id =$(this).data('guest_id');

                    if (guest_id) {
                        const _token = $('input[name="_token"]').val();
                        const method = 'POST';

                        $.ajax("{{ route('get.guest.data') }}", {
                            method: method,
                            data: {
                                guest_id: guest_id,
                                _token: _token
                            },
                            beforeSend: function (xhr) {
                                $('#guestList').css({
                                    'display': 'none'
                                }).html('');
                                $('input[name="guest_id"]').val('');
                                $('input[name="guest_name"]').val('');
                                $('#guest_email').val('');
                                $('#guest_company').val('');
                                $('#guest_address').val('');
                                $('#guest_identity').val('');
                            },
                            success: function (res, status, xhr) {
                                if (res.status) {
                                    let guest = res.data;
                                    $('input[name="guest_id"]').val(guest.id);
                                    $('input[name="guest_name"]').val(guest.name);
                                    $('#guest_phone').val(guest.phone);
                                    $('#guest_email').val(guest.email);
                                    $('#guest_company').val(guest.company);
                                    $('#guest_address').val(guest.address);
                                    $('#guest_identity').val(guest.identity);
                                }
                            }
                        });
                    }
                });

            });

        }(jQuery))

        room_rent_calcution = function () {
            let room_rent = 0;
            let tax = parseFloat($('#tax').html()) || 0;
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
                    let this_room_rent = parseFloat($(this).closest('tr').children('.room_price').html());
                    room_rent += this_room_rent;
                }
            });

            if (room_rent != 0) {
                $('#roomRent').val(room_rent);
                $('#subTotal').val(room_rent*day);
                //tax calculation
                let sub_total = parseFloat($('#subTotal').val());
                //let tax_amount = Math.ceil(parseFloat((sub_total*tax)/100));
                let discount = parseFloat($('#discount').val()) || 0;
                let paid_amount = parseFloat($('#paidAmount').val()) || 0;
                let grand_total = sub_total-discount;
                //$('#taxAmount').val(tax_amount);
                $('#grandTotal').val(grand_total);
                $('#balance').val(grand_total-paid_amount);
                $('#roomRentDetails').html(`For ${day} dasys Room Rent: X ${day} = ${sub_total}`);
            } else {
                $('#roomRent, #subTotal, #taxAmount, #discount, #grandTotal, #paidAmount, #balance').val(null);
                $('#roomRentDetails').html('');
            }
        }

    </script>
@endpush
