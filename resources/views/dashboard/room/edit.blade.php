@extends('layouts.master')

@section('content')
    <div class="box">
        <div class="box-header with-border">
            <div class="box-header-content">
                <h4 class="box-title">Edit Room</h4>
            </div>
            <div class="action">
                <a href="{{ route('room.list') }}" class="btn btn-primary">Room list</a>
            </div>
        </div>
        {!! Form::open(['route' => ['room.update', $room->id], 'method' => 'PUT']) !!}
        <div class="box-body">
            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="">Resort</label>
                        {!! Form::select('resorts', formSelectOptions($resorts), $room->resort_id, ['placeholder' => 'Select Resort', 'class' => 'form-control resort-select2   ', 'id' => 'resort']) !!}
                        <span class="text-danger"></span>
                    </div>
                    <div class="form-group">
                        <label for="">Room name</label>
                        <input type="text" name="name" class="form-control" placeholder="E.G. R-101" value="{{ $room->name }}">
                        <span class="text-danger"></span>
                    </div>
                    <div class="form-group">
                        <label for="">Room Category</label>
                        {!! Form::select('category', formSelectOptions($categories, 'id', 'full_name'), $room->room_category_id, ['class' => 'form-control', 'placeholder' => 'Select Category']) !!}
                        <span class="text-danger"></span>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="">Size (Square feet)</label>
                                <input type="text" name="size" class="form-control" value="{{ $room->size }}" placeholder="Room Size">
                                <span class="text-danger"></span>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="">Capacity</label>
                                <input type="number" name="capacity" class="form-control" value="{{ $room->capacity }}" placeholder="Room Capacity">
                                <span class="text-danger"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="">Regular Price</label>
                                <input type="text" name="regular_price" class="form-control" value="{{ $room->regular_price }}" placeholder="Regular price">
                                <span class="text-danger"></span>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="">Weekend Price</label>
                                <input type="text" name="weekend_price" class="form-control" value="{{ $room->holiday_price }}" placeholder="Weekend price">
                                <span class="text-danger"></span>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="">Holiday Price</label>
                                <input type="text" name="holiday_price" class="form-control" value="{{ $room->holiday_price }}" placeholder="Holiday price">
                                <span class="text-danger"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    @if($facilities->isNotEmpty())
                        <div class="form-group">
                            <label for="">Facilities (Room facilities)</label>
                            <div class="facilities-list">
                                @foreach($facilities as $key => $facility)
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" name="facilities[]" class="custom-control-input" value="{{ $facility->id }}" id="{{ $facility->name.'_'.$key }}" @if($room->hasFacility($facility->name)) checked @endif>
                                        <label for="{{ $facility->name.'_'.$key }}" class="custom-control-label">{{ $facility->name }}</label>
                                    </div>
                                @endforeach
                            </div>
                            <span class="text-danger"></span>
                        </div>
                    @endif
                </div>
            </div>
            <div class="form-group">
                <label>
                    <input type="checkbox" name="seasonal_pricing_checkbox" id="seasonal_pricing" {{ $room->seasonPrices->isNotEmpty() ? 'checked' : '' }}>
                    <span>Add Seasonal Pricing</span>
                </label>
            </div>

            <div id="occasion_list">
                <table id="season_price_table" class="table table-bordered">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Season Name</th>
                        <th>Price</th>
                        <th>Weekend Price</th>
                        <th>Holiday Price</th>
                    </tr>
                    </thead>
                    <tbody id="season_price_table_body">

                    </tbody>
                </table>
            </div>

            <div class="form-group">
                <label for="">Short Description</label>
                <textarea name="short_description" placeholder="Write Short Description" class="form-control" rows="5">{{ $room->short_description }}</textarea>
                <span class="text-danger"></span>
            </div>
            <div class="form-group">
                <label for="">Description</label>
                <textarea name="description" placeholder="Write Description" class="form-control summernote" rows="5">{!! $room->description !!}</textarea>
                <span class="text-danger"></span>
            </div>
        </div>
        <div class="box-footer">
            <button class="btn btn-success" onclick="formSubmit(this, event)">Update</button>
        </div>
        {!! Form::close() !!}
    </div>
    <template id="seasonPriceTemplate">
        <tr>
            <td class="price_serial"></td>
            <td class="season_name"></td>
            <td>
                <input type="hidden" name="seasons[]" class="season_id">
                <input type="text" name="season_price[]" placeholder="0.00" class="form-control season-price">
            </td>
            <td>
                <input type="text" name="season_weekend_price[]" placeholder="0.00" class="form-control season-weekend-price">
            </td>
            <td>
                <input type="text" name="season_holiday_price[]" placeholder="0.00" class="form-control season-holiday-price">
            </td>
        </tr>
    </template>
@endsection

@push('plugin-styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css">
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
@endpush

@push('plugin-scripts')
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
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

                if ($('.summernote').length > 0) {
                    $(".summernote").summernote({
                        minHeight: 200,
                        maxHeight: null,
                        focus: !1,
                        toolbar: [
                            // [groupName, [list of button]]
                            ['style', ['bold', 'italic', 'underline', 'clear']],
                            ['fontsize', ['fontsize']],
                            ['para', ['ul', 'ol', 'paragraph']],
                        ],
                        placeholder: 'Write...........'
                    });
                }

                $('#season_price_table').hide();

                if ($('#seasonal_pricing').is(':checked')) {
                    let resort_id = $('#resort').val();
                    let room_id = '{{ $room->id }}';

                    if (!resort_id) {
                        $('#resort').siblings('.text-danger').html('Please Choose a Resort');
                        alert('No Resort Choose Yet');
                        $(this).prop('checked', false);
                    } else {
                        let _token = $('input[name="_token"]').val();
                        const method = 'POST';

                        $.ajax("{{ route('get.season.pricing.room') }}", {
                            method: method,
                            data: {
                                resort_id: resort_id,
                                room_id: room_id,
                                _token: _token
                            },
                            beforeSend: function (xhr) {
                                $('#season_price_table').show();
                                $('#season_price_table_body').html('');
                            },
                            success: function (res, status, xhr) {

                                if (res.status === 'success') {
                                    let seasons = res.data;
                                    let roomSeasons= res.room;

                                    const rowElement = document.getElementById('season_price_table_body');
                                    const rowTemplate = document.getElementById('seasonPriceTemplate');
                                    let i = 1;



                                    for (const season of seasons) {
                                        const rowEl = document.importNode(rowTemplate.content, true);
                                        rowEl.querySelector('.price_serial').textContent = i;
                                        rowEl.querySelector('.season_id').setAttribute('value', season.id);
                                        rowEl.querySelector('.season_name').textContent = season.name;

                                        //filter room season price
                                        var room_season = roomSeasons.filter(function(item) {
                                            if (item.season_id === season.id) {
                                                return item;
                                            }

                                            return null;
                                        });
                                        if (room_season.length > 0) {
                                            if (room_season[0].price) {
                                                rowEl.querySelector('.season-price').setAttribute('value', room_season[0].price);
                                            }

                                            if (room_season[0].weekend_price) {
                                                rowEl.querySelector('.season-weekend-price').setAttribute('value', room_season[0].weekend_price);
                                            }

                                            if (room_season[0].holiday_price) {
                                                rowEl.querySelector('.season-holiday-price').setAttribute('value', room_season[0].holiday_price);
                                            }

                                        }
                                        rowElement.append(rowEl);
                                        i++;
                                    }
                                }
                            }
                        });
                    }

                } else {
                    $('#season_price_table').hide();
                    $('#season_price_table_body').html('');
                }

                // division change
                $(document).on('change', '#seasonal_pricing', function () {
                    if ($(this).is(':checked')) {
                        let resort_id = $('#resort').val();
                        if (!resort_id) {
                            $('#resort').siblings('.text-danger').html('Please Choose a Resort');
                            alert('No Resort Choose Yet');
                            $(this).prop('checked', false);
                        } else {
                            let _token = $('input[name="_token"]').val();
                            const method = 'POST';

                            $.ajax("{{ route('get.season.pricing') }}", {
                                method: method,
                                data: {
                                    resort_id: resort_id,
                                    _token: _token
                                },
                                beforeSend: function (xhr) {
                                    $('#season_price_table').show();
                                    $('#season_price_table_body').html('');
                                },
                                success: function (res, status, xhr) {
                                    if (res.status === 'success') {
                                        let occasions = res.data;
                                        const rowElement = document.getElementById('season_price_table_body');
                                        const rowTemplate = document.getElementById('seasonPriceTemplate');
                                        let i = 1;
                                        for (const occasion of occasions) {
                                            const rowEl = document.importNode(rowTemplate.content, true);
                                            rowEl.querySelector('.price_serial').textContent = i;
                                            rowEl.querySelector('.season_id').setAttribute('value', occasion.id);
                                            rowEl.querySelector('.season_name').textContent = occasion.name;
                                            rowElement.append(rowEl);
                                            i++;
                                        }
                                    }
                                }
                            });
                        }

                    } else {
                        $('#season_price_table').hide();
                        $('#season_price_table_body').html('');
                    }
                });

            });

        }(jQuery))
    </script>
@endpush
