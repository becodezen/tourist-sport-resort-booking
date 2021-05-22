@extends('layouts.frontend')

@section('content')
    {{-- page-title --}}
    @include('partials._fr_page_title')
    <section class="search-result-area pt-40  pb-40">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <div class="search-filter-header mb-15">
                        <h4>Filter</h4>
                    </div>
                    <div class="search-filter">
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
                        <div class="form-group">
                            <label for="">Check In</label>
                            <div class="form-input-group">
                                <i class="fas fa-calendar"></i>
                                <input type="text" name="check_in" id="checkIn" autocomplete="off"  class="form-control check-in-datepicker datepicker" placeholder="dd-mm-yyyy">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="">Check Out</label>
                            <div class="form-input-group">
                                <i class="fas fa-calendar"></i>
                                <input type="text" name="check_out" autocomplete="off" id="checkOut" class="form-control check-out-datepicker datepicker" placeholder="dd-mm-yyyy">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="">Guest</label>
                            <div class="guests" id="guests" {{ in_array(Session::get('guest_number'), [1, 2, 3, 4]) ? 'style="display:flex"' : 'style="display:none"'}}>
                                <label>
                                    <input type="radio" class="guest" name="guest_number" value="1" {{ Session::get('guest_number') == 1 ? 'checked' : '' }}>
                                    <span>1</span>
                                </label>
                                <label>
                                    <input type="radio" class="guest" name="guest_number" value="2" {{ Session::get('guest_number') == 2 ? 'checked' : '' }}>
                                    <span>2</span>
                                </label>
                                <label>
                                    <input type="radio" class="guest" name="guest_number" value="3" {{ Session::get('guest_number') == 3 ? 'checked' : '' }}>
                                    <span>3</span>
                                </label>
                                <label>
                                    <input type="radio" class="guest" name="guest_number" value="4" {{ Session::get('guest_number') == 4 ? 'checked' : '' }}>
                                    <span>4</span>
                                </label>
                                <div id="add-guest-btn">
                                    <span><i class="fas fa-plus"></i></span>
                                </div>
                            </div>
                            <div class="form-input-group" id="guest_input">
                                <i class="fas fa-user"></i>
                                <input type="text" name="guest_number_input" class="form-control guest-input" placeholder="e.g: 5" value="{{ Session::get('guest_number') }}">
                                <spna id="close_guest_input"><i class="fas fa-times"></i></spna>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-vb-default mt-10 w-100">Search Filter</button>
                        {!! Form::close() !!}
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="search-result">
                        <div class="search-result-body resort-area search-result-resorts">
                            @if($resorts->isNotEmpty())
                            <div class="resorts">
                                @foreach ($resorts as $resort)
                                <div class="resort">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="resort-thumbnail">
                                                <img src="{{ $resort->thumbnail() ? $resort->thumbnail()->image : asset('frontend/assets/img/resort-dummy.jpg') }}" alt="">
                                                <div class="resort-rating">
                                                    <div class="rating-icons">
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                    </div>
                                                    <div class="rating">
                                                        <span>4.8</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="resort-content">
                                                <div class="resort-title">
                                                    <a href="{{ route('fr.resort.show', $resort->slug) }}">
                                                        <h4>{{ $resort->name }}</h4>
                                                    </a>
                                                </div>
                                                <div class="resort-location">
                                                    <i class="fas fa-map-marker"></i>
                                                    {{ $resort->address}}
                                                </div>
                                                <div class="resort-short-description mt-15">
                                                    {{ Str::substr($resort->short_description, 0, 250).'....' }}
                                                </div>
                                                <div class="resort-price">
                                                    <span class="mr-10">AVG/Night</span>
                                                    <strong>{{ $resort->minRoomPrice() }}-{{ $resort->maxRoomPrice() }}</strong>
                                                </div>
                                                <div class="resort-link">
                                                    <a href="{{ route('fr.resort.show', $resort->slug) }}" class="btn btn-sm btn-primary">View Details <i class="fas fa-long-arrow-alt-right"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            @endif
                        </div>
                        <div class="search-result-footer">
                            <div class="row mt-50">
                                <div class="col-md-12">
                                    <div class="pagination-center">
                                        {{ $resorts->links() }}
                                    </div>
                                    <div class="pagination-center responsive-pagination">
                                        {{ $resorts->links('pagination::simple-default') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection


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
