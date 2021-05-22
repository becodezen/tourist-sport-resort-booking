@extends('layouts.master')

@section('content')
    <div class="box">
        <div class="box-header with-border">
            <div class="box-header-content">
                <h4 class="box-title">Create Room</h4>
            </div>
            <div class="action">
                <a href="{{ route('room.list') }}" class="btn btn-primary">Room list</a>
            </div>
        </div>
        {!! Form::open(['route' => 'room.store', 'method' => 'POST']) !!}
        <div class="box-body">
            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="">Resort</label>
                        {!! Form::select('resorts', formSelectOptions($resorts), null, ['placeholder' => 'Select Resort', 'class' => 'form-control resort-select2   ', 'id' => 'resort']) !!}
                        <span class="text-danger"></span>
                    </div>
                    <div class="form-group">
                        <label for="">Room name (Separate by commas)</label>
                        <input type="text" name="name" class="form-control" placeholder="E.G. R-101, R-102, R-103">
                        <span class="text-danger"></span>
                    </div>
                    <div class="form-group">
                        <label for="">Room Category</label>
                        {!! Form::select('category', formSelectOptions($categories, 'id', 'full_name'), null, ['class' => 'form-control', 'placeholder' => 'Select Category']) !!}
                        <span class="text-danger"></span>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="">Size (Square feet)</label>
                                <input type="text" name="size" class="form-control" placeholder="Room Size">
                                <span class="text-danger"></span>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="">Capacity</label>
                                <input type="number" name="capacity" class="form-control" placeholder="Room Capacity">
                                <span class="text-danger"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="">Regular Price</label>
                                <input type="text" name="regular_price" class="form-control" placeholder="Regular price">
                                <span class="text-danger"></span>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="">Weekend Price</label>
                                <input type="text" name="weekend_price" class="form-control" placeholder="Weekend price">
                                <span class="text-danger"></span>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="">Holiday Price</label>
                                <input type="text" name="holiday_price" class="form-control" placeholder="Holiday price">
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
                                        <input type="checkbox" name="facilities[]" class="custom-control-input" value="{{ $facility->id }}" id="{{ $facility->name.'_'.$key }}">
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
                    <input type="checkbox" name="seasonal_pricing_checkbox" id="seasonal_pricing">
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
                    <tbody id="season_price_table_body"></tbody>
                </table>
            </div>

            <div class="form-group">
                <label for="">Short Description</label>
                <textarea name="short_description" placeholder="Write Short Description" class="form-control" rows="5"></textarea>
                <span class="text-danger"></span>
            </div>
            <div class="form-group">
                <label for="">Description</label>
                <textarea name="description" placeholder="Write Description" class="form-control summernote" rows="5"></textarea>
                <span class="text-danger"></span>
            </div>
        </div>
        <div class="box-footer">
            <button class="btn btn-success" onclick="formSubmit(this, event)">Save</button>
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
