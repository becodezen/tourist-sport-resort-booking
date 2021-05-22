@extends('layouts.master')

@section('content')

    <div class="box">
        <div class="box-header with-border">
            <div class="box-header-content">
                <h4 class="box-title">Update Resort</h4>
            </div>
            <div class="action">
                <a href="{{ route('resort.list') }}" class="btn btn-dark">Resort List</a>
            </div>
        </div>
        {!! Form::open(['route' => ['resort.update', $resort->id], 'method' => 'PUT']) !!}
        <div class="box-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">Name</label>
                        <input type="text" class="form-control" value="{{ $resort->name }}" name="name" placeholder="Enter resort name">
                        <span class="text-danger"></span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">Address</label>
                        <input type="text" class="form-control" name="address"  value="{{ $resort->address }}" placeholder="Enter resort address">
                        <span class="text-danger"></span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">Phone (Resort Contact Number)</label>
                        <input type="text" class="form-control" name="phone" value="{{ $resort->phone }}" placeholder="Enter resort address">
                        <span class="text-danger"></span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">Email (Resort Contact Email)</label>
                        <input type="text" class="form-control" name="email" value="{{ $resort->email }}" placeholder="Enter resort address">
                        <span class="text-danger"></span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="">Nearest Tourist Spot</label>
                        {!! Form::select('tourist_spots[]', formSelectOptions($tourist_spots), $resort->touristSpots->pluck('id')->toArray(), ['class' => 'form-control multiple-select2', 'multiple']) !!}
                        <span class="text-danger"></span>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <div class="form-header d-flex justify-content-between">
                            <label for="">Google Map location</label>
                            <button type="button" data-toggle="modal" data-target="#googleMap" class="btn btn-sm btn-light">Get FromGoogle Map</button>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <input type="text" placeholder="Lat" name="lat" value="{{ $resort->lat }}" id="lat" class="form-control">
                                <span class="text-danger"></span>
                            </div>
                            <div class="col-sm-6">
                                <input type="text" placeholder="Lon" name="lon" value="{{ $resort->lon }}" id="lon" class="form-control">
                                <span class="text-danger"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    @if($inside_facilities->isNotEmpty())
                        <div class="form-group">
                            <label for="">Outside Facilities (Resort facilities)</label>
                            <div class="facilities-list">
                                @foreach($inside_facilities as $key => $facility)
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" name="facilities[]" class="custom-control-input" value="{{ $facility->id }}" id="{{ $facility->name.'_'.$key }}" @if($resort->hasFacility($facility->name)) checked @endif>
                                        <label for="{{ $facility->name.'_'.$key }}" class="custom-control-label">{{ $facility->name }}</label>
                                    </div>
                                @endforeach
                            </div>
                            <span class="text-danger"></span>
                        </div>
                    @endif
                </div>
                <div class="col-md-6">
                    @if($outside_facilities->isNotEmpty())
                        <div class="form-group">
                            <label for="">Outside Facilities (Resort near facilities)</label>
                            <div class="facilities-list">
                                @foreach($outside_facilities as $key => $facility)
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" name="facilities[]" value="{{ $facility->id }}" id="{{ $facility->name.'_'.$key }}" @if($resort->hasFacility($facility->name)) checked @endif>
                                        <label for="{{ $facility->name.'_'.$key }}" class="custom-control-label">{{ $facility->name }}</label>
                                    </div>
                                @endforeach
                            </div>
                            <span class="text-danger"></span>
                        </div>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">Resort Video Link</label>
                        <input type="text" name="video_link" placeholder="Enter video link" value="{{ $resort->video_link }}" id="" class="form-control">
                        <span class="text-danger"></span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">Resort 3D Video Link</label>
                        <input type="text" name="video_link_3d" placeholder="Enter 3d video link" value="{{ $resort->video_link_3d }}" class="form-control">
                        <span class="text-danger"></span>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="">Short Description</label>
                <textarea name="short_description" id="" rows="4" class="form-control" placeholder="Short description">{{ $resort->short_description }}</textarea>
            </div>

            <div class="form-group">
                <label for="">Description</label>
                <textarea name="resort_description" class="form-control summernote">{!! $resort->description !!}</textarea>
                <span class="text-danger"></span>
            </div>

            <div class="form-group">
                <label for="">Location Instruction</label>
                <div class="form-group">
                    <textarea name="resort_instruction" class="form-control summernote">{!! $resort->instruction !!}</textarea>
                    <span class="text-danger"></span>
                </div>
            </div>
        </div>
        <div class="box-footer">
            <button class="btn btn-success" type="submit" onclick="formSubmit(this, event)">Update</button>
        </div>
        {!! Form::close() !!}
    </div>


    <div class="modal fade" id="googleMap">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Google Maps</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="map" class="google-map"></div>
                </div>
            </div>
        </div>
    </div>
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

                //select2 multiple
                if($('.multiple-select2').length > 0) {
                    $('.multiple-select2').select2({
                        placeholder: "Select Tourist Spot"
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
