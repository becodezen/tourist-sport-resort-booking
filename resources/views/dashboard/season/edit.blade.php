@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-lg-6">
            <div class="box">
                <div class="box-header with-border">
                    <div class="box-header-content">
                        <h4 class="box-title">Update Season</h4>
                    </div>
                    <div class="action">
                        <a href="{{ route('season.list') }}" class="btn btn-light">Season list</a>
                    </div>
                </div>
                {!! Form::open(['route' => ['season.update', $season->id], 'method' => 'PUT']) !!}
                <div class="box-body">                    
                    <div class="form-group">
                        <label for="">Resort</label>
                        {!! Form::select('resort[]', formSelectOptions($resorts), $season->resorts->pluck('id')->toArray(), ['class' => 'form-control multiple-select2', 'multiple']) !!}
                        <span class="text-danger"></span>
                    </div>
                    <div class="form-group">
                        <label for="">Name</label>
                        <input type="text" name="name" class="form-control" placeholder="Enter name" value="{{ $season->name }}">
                        <spant class="text-danger"></spant>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Select Dates</label>
                                <input type="text" class="form-control datepicker" id="seasonDate" placeholder="YYYY-MM-DD" autocomplete="off">
                                <spant class="text-danger"></spant>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">Season dates</label>
                        <div id="seasonDates">
                            @foreach ($dates as $key => $item)
                                <div class="season_date">
                                    <input type="hidden" value="{{ $item }}" name="season_dates[]" class="season_date_input">
                                    <span>{{ $item }}</span>
                                    <span class="season_date_close">
                                        <i class="fas fa-times"></i>
                                    </span>
                                </div>
                            @endforeach
                        </div>
                        <span class="text-danger"></span>
                    </div>
                </div>
                <div class="box-footer">
                    <button class="btn btn-success" onclick="formSubmit(this, event)" type="submit">Update</button>
                </div>
            </div>
        </div>
    </div>
    <template id="seasonDateTemplate">
        <div class="season_date">
            <input type="hidden" name="season_dates[]" class="season_date_input">
            <span></span>
            <span class="season_date_close">
                <i class="fas fa-times"></i>
            </span>
        </div>
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
                        autoclose: false,
                        autocomplete: true,
                    });
                }

                //select2 multiple
                if($('.multiple-select2').length > 0) {
                    $('.multiple-select2').select2({
                        placeholder: "Select Resort"
                    });
                }
                
                //datepicker
                $(document).on('change', '#seasonDate', function() {
                    let date = $(this).val();
                    const seasonTemplate = document.getElementById('seasonDateTemplate');
                    const seasonDateElement = document.getElementById('seasonDates');
                    let duplicate = 1;
                    
                    if ($('.season_date_input').length > 0) {
                        $('.season_date_input').each(function (i) {
                            let  s_date = $(this).val();
                            if (s_date == date) {
                                duplicate = 0;
                            }
                        });
                    }

                    if (date && duplicate != 0) {
                        const seasonDateEl = document.importNode(seasonTemplate.content, true);
                        seasonDateEl.querySelector('span').textContent = date;
                        seasonDateEl.querySelector('.season_date_input').value = date;
                        seasonDateElement.append(seasonDateEl);
                    }
                });

                $(document).on('click', '.season_date_close', function () {
                    if (confirm('Are you sure want to delete?')) {
                        $(this).closest('.season_date').remove();
                    }
                });
                

            });

        }(jQuery));
    </script>
@endpush
