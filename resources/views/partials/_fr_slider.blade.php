<!-- Slider Section -->
<section class="welcome-area">
    <div class="sliders owl-carousel" id="welcome_slider">
        @if($sliders->isNotEmpty())
            @foreach ($sliders as $slider)
                <div class="slider-item">
                    <div class="slider-bg" style="background-image: url('{{ asset($slider->image) }}');"></div>
                    <div class="slider-table">
                        <div class="slider-tablecell">
                            <div class="slider-content" style="display: none;">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-lg-8">
                                            <h1>Resorts & Suits</h1>
                                            <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Ea incidunt minus excepturi sed odit voluptates.</p>
                                            <a href="">More Info</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            @include('partials._fr_slider_default')
        @endif

    </div>
    <!-- search form -->
    <div class="resort-search">
        <div class="container">
            <div class="row">
                <div class="col-lg-6"></div>
                <div class="col-lg-6">
                    {!! Form::open(['route' => 'resort.search', 'method' => 'GET']) !!}
                        @csrf
                        <div class="form-group has-options">
                            <label for="">Choose your Destination</label>
                            <div class="form-input-group">
                                <i class="fas fa-map-marker-alt"></i>
                                <input type="text" name="destination" id="destination" autocomplete="off" class="form-control" placeholder="Destination, Tourist Spot, City" required>
                            </div>
                            <ul id="destinationOptions" class="search-options"></ul>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Check In</label>
                                    <div class="form-input-group">
                                        <i class="fas fa-calendar"></i>
                                        <input type="text" name="check_in" id="checkIn" autocomplete="off"  class="form-control check-in-datepicker datepicker" placeholder="dd-mm-yyyy" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Check Out</label>
                                    <div class="form-input-group">
                                        <i class="fas fa-calendar"></i>
                                        <input type="text" name="check_out" autocomplete="off" id="checkOut" class="form-control check-out-datepicker datepicker" placeholder="dd-mm-yyyy" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            {{-- <div class="col-md-6">
                                <div class="form-group  has-options"">
                                    <label for="">Resort</label>
                                    <div class="form-input-group">
                                        <i class="fas fa-building"></i>
                                        <input type="text" name="resort" id="resort" class="form-control" placeholder="e.g: Samadru Bilash">
                                    </div>
                                    <ul id="resortsOptions" class="search-options"></ul>
                                </div>
                            </div> --}}
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Guest</label>
                                    <div class="guests" id="guests">
                                        <label>
                                            <input type="radio" class="guest" name="guest_number" value="1">
                                            <span>1</span>
                                        </label>
                                        <label>
                                            <input type="radio" class="guest" name="guest_number" value="2">
                                            <span>2</span>
                                        </label>
                                        <label>
                                            <input type="radio" class="guest" name="guest_number" value="3">
                                            <span>3</span>
                                        </label>
                                        <label>
                                            <input type="radio" class="guest" name="guest_number" value="4">
                                            <span>4</span>
                                        </label>
                                        <div id="add-guest-btn">
                                            <span><i class="fas fa-plus"></i></span>
                                        </div>
                                    </div>
                                    <div class="form-input-group" id="guest_input">
                                        <i class="fas fa-user"></i>
                                        <input type="text" name="guest_number_input" class="form-control guest-input" placeholder="e.g: 5">
                                        <spna id="close_guest_input"><i class="fas fa-times"></i></spna>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-vb-default mt-10">SEARCH NOW</button>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
</section>

@push('plugin-styles')
    <link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}">
@endpush

@push('plugin-scripts')
    <script src="{{ asset('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
@endpush

@push('footer-scripts')
    <script>
        (function ($) {
            "use-strict"

            jQuery(document).ready(function () {

                //bootstrap datepicker
                if ($('.check-in-datepicker').length > 0) {
                    $('.check-in-datepicker').datepicker({
                        format: 'dd-mm-yyyy',
                        todayHighlight: true,
                        autoclose: true,
                        autocomplete: true,
                        startDate: new Date(),
                        endDate: new Date(new Date().setDate(new Date().getDate() + 15))
                    });
                }

                if ($('.check-out-datepicker').length > 0) {
                    $('.check-out-datepicker').datepicker({
                        format: 'dd-mm-yyyy',
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

                /* Destination list show */
                $(document).on('keyup','#destination', function () {

                    let destination = $(this).val();
                    const _token = $('input[name="_token"]').val();

                    if (destination.length > 0) {
                        $.ajax("{{ route('get.destination') }}", {
                            method: "POST",
                            data: {
                                _token: _token,
                                destination: destination
                            },
                            beforeSend: function (xhr) {
                                $('#destinationOptions').html('');
                            },
                            success: function(res, status, xhr) {
                                if(status === 'success') {
                                    if (res.status) {
                                        let destinations = res.data;
                                        $.each(destinations, function(i, destination){
                                            $('#destinationOptions').append(`<li class="search_destination" data-destination="${destination}">${destination}</li>`);
                                        });
                                    }else {
                                        $('#destinationOptions').html('');
                                    }
                                }
                            }
                        });
                    }else {
                        $('#destinationOptions').html('');
                    }
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

            });

        }(jQuery))
    </script>
@endpush
