@extends('layouts.master')

@section('content')
    <div class="box">
        <div class="box-header with-border">
            <div class="box-header-content">
                <h4 class="box-title">Update Spot</h4>
            </div>
            <div class="action">
                <a href="{{ route('tourist.spot.list') }}" class="btn btn-danger btn-sm">List</a>
            </div>
        </div>
        {!! Form::open(['route' => ['tourist.spot.update', $spot->id], 'method' => 'PUT']) !!}
        <div class="box-body">
            <div class="row">
                <div class="col-lg-4">
                    <div class="form-group">
                        <label>Tourist Spot Name</label>
                        <input type="text" name="name" placeholder="example: Sent Martin" value="{{ $spot->name }}" class="form-control">
                        <span class="text-danger"></span>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="form-group">
                        <div class="form-header d-flex justify-content-between">
                            <label for="">Google Map location</label>
                            <button type="button" data-toggle="modal" data-target="#googleMap" class="btn btn-sm btn-light">Get FromGoogle Map</button>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <input type="text" placeholder="Lat" name="lat" value="{{ $spot->lat }}" id="lat" class="form-control">
                                <span class="text-danger"></span>
                            </div>
                            <div class="col-sm-6">
                                <input type="text" placeholder="Lon" name="lon" value="{{ $spot->lon }}" id="lon" class="form-control">
                                <span class="text-danger"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4">
                    <div class="form-group">
                        <label for="division">Division</label>
                        {!! Form::select('division', formSelectOptions($divisions), $spot->division_id, ['class' => 'form-control', 'placeholder' => 'Select Division', 'id' => 'division']) !!}
                        <span class="text-danger"></span>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <label for="district">District</label>
                        {!! Form::select('district', formSelectOptions($districts), $spot->district_id, ['class' => 'form-control', 'placeholder' => 'Select District', 'id' => 'district']) !!}
                        <span class="text-danger"></span>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <label for="upzila">Upazila</label>
                        {!! Form::select('upazila', formSelectOptions($upazilas), $spot->upazila_id, ['class' => 'form-control', 'placeholder' => 'Select Upazila', 'id' => 'upazila']) !!}
                        <span class="text-danger"></span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="form-group">
                        <label for="">Short Description</label>
                        <textarea name="short_description" placeholder="Write short description" rows="3" class="form-control">{{ $spot->short_description }}</textarea>
                        <span class="text-danger"></span>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="form-group">
                        <label for="">Description</label>
                        <textarea name="description" class="form-control summernote">{{ $spot->description }}</textarea>
                        <span class="text-danger"></span>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label>Route Plan</label>
                <input type="text" name="route_plan" value="{{ $spot->route_plan }}" class="form-control" placeholder="Enter Route Plan">
                <span class="text-danger"></span>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="form-group">
                        <label for="">Warning</label>
                        <textarea name="instruction" class="form-control summernote">{!! $spot->instruction !!}</textarea>
                        <span class="text-danger"></span>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="form-group">
                        <label for="">Travel Cost</label>
                        <textarea name="travel_cost" class="form-control summernote">{!! $spot->travel_cost !!}</textarea>
                        <span class="text-danger"></span>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="form-group">
                        <label for="">Warning</label>
                        <textarea name="warning" class="form-control summernote">{!! $spot->warning !!}</textarea>
                        <span class="text-danger"></span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="">Tags (Separated by Comma)</label>
                        <input type="text" name="tags" placeholder="eg: Saint-marting, Dip" class="form-control" value="{{ $spot->tags ? implode(', ', json_decode($spot->tags)) : '' }}">
                        <span class="text-danger"></span>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="">Video Link (Optional)</label>
                        <input type="text" name="video_link" class="form-control" placeholder="Enter video link" value="{{ $spot->video_link }}">
                        <span class="text-danger"></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="box-footer text-right">
            <button class="btn btn-primary" type="submit" onclick="formSubmit(this, event)">Save</button>
        </div>
        {!! Form::close() !!}
    </div>
    <template id="selectOption">
        <option value=""></option>
    </template>
@endsection

@push('plugin-styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css">
@endpush

@push('plugin-scripts')
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
@endpush

@push('footer-scripts')
    <script>
        (function($){
            "use-strict"

            //image preview functions
            function imagePrev(i, img)
            {
                if (i.files && i.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function (e) {
                        $(img).attr('src', e.target.result);
                        if ($(img).siblings('#close').length > 0) {
                            $(img).siblings('#close').css({
                                opacity: 1
                            });
                        }

                        if ($(img).siblings('#img-name').length > 0) {
                            $(img).siblings('#img-name').html(i.files[0].name).css({
                                opacity: 1
                            });
                        }
                    }

                    reader.readAsDataURL(i.files[0]);
                }
            }

            jQuery(document).ready(function() {
                //image preview
                $(document).on('change', '#imgInp', function () {
                    imagePrev(this, '#imgPrev');
                });

                $(document).on('click', '#close', function () {
                    $('#imgInp').val('');
                    $(this).css({
                        opacity: 0
                    }).siblings('#imgPrev').attr('src', '');
                    $('#img-name').html('').css({
                        opacity: 0
                    });
                });

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
                        placeholder: 'Write description...........'
                    });
                }
                // division change
                $(document).on('change', '#division', function () {
                    let division_id = $(this).val();

                    if (division_id) {
                        let _token = $('input[name="_token"]').val();
                        const method = 'POST';

                        $.ajax("{{ route('get.district') }}", {
                            method: method,
                            data: {
                                division_id: division_id,
                                _token:_token
                            },
                            beforeSend: function (xhr) {
                                $('#district').html('<option>Loading......</option>');
                                $('#upazila').html('<option>Select Upazila</option>');
                            },
                            success: function (res, status, xhr) {
                                if (res.status) {
                                    let districts = res.data;
                                    const selectElement = document.getElementById('district');
                                    const optionTemplate = document.getElementById('selectOption');
                                    $('#district').html('<option>Select District</option>');

                                    for (const district of districts) {
                                        const optionEl = document.importNode(optionTemplate.content, true);
                                        optionEl.querySelector('option').textContent = district.name;
                                        optionEl.querySelector('option').value = district.id;
                                        selectElement.append(optionEl);
                                    }
                                }
                            },
                            errors: function (jqXhr, textStatus, errorMessage) {
                                console.log(textStatus);
                            }
                        });
                    } else {
                        $('#upazila').html('<option>Select Upazila</option>');
                        $('#district').html('<option>Select District</option>');
                    }
                });

                $(document).on('change', '#district', function () {
                    let district_id = $(this).val();

                    if (district_id) {
                        let _token = $('input[name="_token"]').val();
                        const method = 'POST';

                        $.ajax("{{ route('get.upazila') }}", {
                            method: method,
                            data: {
                                district_id: district_id,
                                _token:_token
                            },
                            beforeSend: function (xhr) {
                                $('#upazila').html('<option>Loading......</option>');
                            },
                            success: function (res, status, xhr) {
                                if (res.status) {
                                    let upazilas = res.data;
                                    const selectElement = document.getElementById('upazila');
                                    const optionTemplate = document.getElementById('selectOption');
                                    $('#upazila').html('<option>Select Upazila</option>');

                                    for (const upazila of upazilas) {
                                        const optionEl = document.importNode(optionTemplate.content, true);
                                        optionEl.querySelector('option').textContent = upazila.name;
                                        optionEl.querySelector('option').value = upazila.id;
                                        selectElement.append(optionEl);
                                    }
                                }
                            },
                            errors: function (jqXhr, textStatus, errorMessage) {
                                console.log(textStatus);
                            }
                        });
                    } else {
                        $('#district').html('<option>Select Upazila</option>');
                    }
                });

            });

        }(jQuery))

        // Initialize and add the map
        function initMap() {
            let _lat = parseFloat($('#lat').val());
            let _lon = parseFloat($('#lon').val());

            let lat = 23.8518404;
            let lng = 89.830699;

            if (_lat) {
                lat = _lat;
            }

            if (_lon) {
                lng = _lon;
            }

            // The location of Uluru
            const myLatlng = { lat: lat, lng:lng };
            // The map, centered at Uluru
            const map = new google.maps.Map(document.getElementById("map"), {
                zoom: 8.5,
                center: myLatlng,
            });
            // The marker, positioned at Uluru
            const marker = new google.maps.Marker({
                position: myLatlng,
                map: map,
            });

            // Create the initial InfoWindow.
            let infoWindow = new google.maps.InfoWindow({
                content: "Click the map to get Lat/Lng!",
                position: myLatlng,
            });

            infoWindow.open(map);
            // Configure the click listener.
            map.addListener("click", (mapsMouseEvent) => {
                // Close the current InfoWindow.
                infoWindow.close();
                // Create a new InfoWindow.
                infoWindow = new google.maps.InfoWindow({
                    position: mapsMouseEvent.latLng,
                });

                infoWindow.setContent(
                    JSON.stringify(mapsMouseEvent.latLng.toJSON(), null, 2)
                );

                //get lat lon and placed into form
                let glatlon = JSON.parse(infoWindow.content)

                if (glatlon) {
                    $('#lat').val(glatlon.lat);
                    $('#lon').val(glatlon.lng);
                }

                infoWindow.open(map);
            });
        }
    </script>
@endpush
