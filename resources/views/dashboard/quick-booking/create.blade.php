@extends('layouts.master')

@section('content')
    <div class="box">
        <div class="box-header with-border">
            <div class="box-header-content">
                <h4 class="box-title">Quick Booking</h4>
            </div>
            <div class="action">
                <a href="{{ route('quick.booking.list') }}" class="btn btn-sm btn-light">Quick Booking List</a>
            </div>
        </div>
        {!! Form::open(['route' => 'quick.booking.store', 'method' => 'POST']) !!}
        <div class="box-body">
            <div class="row">
                <div class="col-md-4">
                    @if($user_type === 'system_user')
                        <div class="form-group">
                            <label for="">Resort</label>
                            {!! Form::select('resort', formSelectOptions($resorts), null, ['placeholder' => 'Select Resort', 'class' => 'form-control resort-select2', 'id' => 'resort']) !!}
                            <span class="text-danger"></span>
                        </div>
                    @elseif ($user_type === 'resort_user')
                        <div class="form-group">
                            <label for="">Resort</label>
                            <input type="hidden" name="resort" value="{{ $resorts->id }}" id="resort">
                            <input type="text" value="{{ $resorts->name }}" class="form-control" readonly>
                            <span class="text-danger"></span>
                        </div>
                    @endif
                    <div class="form-group">
                        <label for="">Check-in-Date</label>
                        <input type="text" name="check_in" id="checkIn" placeholder="YYYY-MM-DD" class="form-control booking_datepicker" autocomplete="off">
                        <span class="text-danger"></span>
                    </div>
                    <div class="form-group">
                        <label for="">Check-out-Date</label>
                        <input type="text" name="check_out" id="checkOut" placeholder="YYYY-MM-DD" class="form-control booking_datepicker" autocomplete="off">
                        <span class="text-danger"></span>
                    </div>
                    <div class="form-group">
                        <label for="">Guest Name</label>
                        <input type="text" name="guest_name" placeholder="Guest name" class="form-control">
                        <span class="text-danger"></span>
                    </div>
                    <div class="form-group">
                        <label for="">Guest Phone</label>
                        <input type="text" name="guest_phone" placeholder="Guest phone" class="form-control">
                        <span class="text-danger"></span>
                    </div>
                    <div class="form-group">
                        <label for="">Guest Address</label>
                        <input type="text" name="guest_address" placeholder="Guest address" class="form-control">
                        <span class="text-danger"></span>
                    </div>
                </div>

                <div class="col-md-8">
                    <h5 class="booking-section-title">Rooms</h5>
                    <div class="quick-booking-rooms">
                        <div id="rooms" style="max-height: 440px !important">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th style="width: 30px">#</th>
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
        </div>
        <div class="box-footer text-right">
            <button type="submit" class="btn btn-success" onclick="formSubmit(this, event)">Confirm Booking</button>
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

                if($('.resort-select2').length > 0) {
                    $('.resort-select2').select2({
                        placeholder: "Select Resort"
                    });
                }
                //bootstrap datepicker
                if ($('.booking_datepicker').length > 0) {
                    $('.booking_datepicker').datepicker({
                        format: 'yyyy-mm-dd',
                        todayHighlight: true,
                        autoclose: true,
                        autocomplete: true,
                        startDate: new Date(),
                    });
                }

                //load room information
                $(document).on('change', '#checkIn,  #checkOut, #resort', function () {
                    const check_in_date = $('#checkIn').val();
                    const check_out_date = $('#checkOut').val();
                    const resort_id = $('#resort').val();


                    if (check_in_date !== '' && check_out_date !== '' && resort_id !== '') {
                        const _token = $('input[name="_token"]').val();
                        const method = 'POST';

                        $.ajax("{{ route('get.quick.booking.rooms') }}", {
                            method: method,
                            data: {
                                resort_id: resort_id,
                                check_in: check_in_date,
                                check_out: check_out_date,
                                _token: _token
                            },
                            beforeSend: function (xhr) {
                                $('#room_list').html(`<tr>
                                    <td colspan="5">Room Loading..........</td>
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
                            <td colspan="5">No Room Display</td>
                        </tr>`);
                    }
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

            });

        }(jQuery))


        room_rent_calcution = function () {
            let room_rent = 0;
            //let vat = parseFloat($('#vat').html()) || 0;
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
                //vat calculation
                let sub_total = parseFloat($('#subTotal').val());
                //let vat_amount = Math.ceil(parseFloat((sub_total*vat)/100));
                let discount = parseFloat($('#discount').val()) || 0;
                let paid_amount = parseFloat($('#paidAmount').val()) || 0;
                let grand_total = sub_total-discount;
                //$('#vatAmount').val(vat_amount);
                $('#grandTotal').val(grand_total);
                $('#balance').val(grand_total-paid_amount);
                $('#roomRentDetails').html(`For ${day} dasys Room Rent: X ${day} = ${sub_total}`);
            } else {
                $('#roomRent, #subTotal, #vatAmount, #discount, #grandTotal, #paidAmount, #balance').val(null);
                $('#roomRentDetails').html('');
            }
        }

    </script>
@endpush
