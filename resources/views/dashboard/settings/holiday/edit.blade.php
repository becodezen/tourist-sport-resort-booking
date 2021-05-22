@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-lg-6">
            <div class="box">
                <div class="box-header with-border">
                    <div class="box-header-content">
                        <h4 class="box-title">Update Holiday</h4>
                    </div>
                </div>
                {!! Form::open(['route' => ['holiday.update', $holiday->id], 'method' => 'PUT']) !!}
                <div class="box-body">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" name="name" id="name" placeholder="Holiday name" class="form-control" value="{{ $holiday->name }}">
                        <span class="text-danger"></span>
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea name="description" id="description" class="form-control" placeholder="Enter description">{{ $holiday->description }}</textarea>
                        <span class="text-danger"></span>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Select Dates</label>
                                <input type="text" class="form-control datepicker" id="holidayDate" placeholder="YYYY-MM-DD" autocomplete="off">
                                <spant class="text-danger"></spant>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">Holiday dates</label>
                        <div id="holidayDates">
                            @foreach ($holiday->holidayDates as $key => $date)
                                <div class="holiday_date">
                                    <input type="hidden" value="{{ $date->holiday_date }}" name="holiday_dates[]" class="holiday_date_input">
                                    <span>{{ $date->holiday_date }}</span>
                                    <span class="holiday_date_close">
                                        <i class="fas fa-times"></i>
                                    </span>
                                </div>
                            @endforeach
                        </div>
                        <span class="text-danger"></span>
                    </div>
                </div>
                <div class="box-footer">
                    <button class="btn btn-success" type="submit" onclick="formSubmit(this, event)">Save</button>
                </div>
                {!! Form::close() !!}
            </div>
            <template id="holidayDateTemplate">
                <div class="holiday_date">
                    <input type="hidden" name="holiday_dates[]" class="holiday_date_input">
                    <span></span>
                    <span class="holiday_date_close">
                        <i class="fas fa-times"></i>
                    </span>
                </div>
            </template>
        </div>
        <div class="col-lg-6">
            <div class="box">
                <div class="box-header with-border">
                    <div class="box-header-content">
                        <h4 class="box-title">Holidays</h4>
                    </div>
                </div>
                <div class="box-body">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        @if($holidays->isNotEmpty())
                            @foreach($holidays as $key => $holiday)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $holiday->name }}</td>
                                    <td>{!! $holiday->dates() !!}</td>
                                    <td>
                                        <div class="action-group">
                                            <a href="{{ route('holiday.edit', $holiday->id) }}" class="btn btn-sm btn-primary" data-toggle="tooltip" data-placement="top" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            {!! Form::open(['route' => ['holiday.delete', $holiday->id], 'method' => 'DELETE']) !!}
                                            <button class="btn btn-sm btn-danger" data-toggle="tooltip" data-placement="top" title="Delete" onclick="deleteSubmit(this, event)">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        {!! Form::close() !!}
                                    </td>
                                </tr>
                            @endforeach
                            @else
                            <tr>
                                <td colspan="5">No Holiday Found</td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
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
                $(document).on('change', '#holidayDate', function() {
                    let date = $(this).val();
                    const holidayTemplate = document.getElementById('holidayDateTemplate');
                    const holidayDateElement = document.getElementById('holidayDates');
                    let duplicate = 1;
                    
                    if ($('.holiday_date_input').length > 0) {
                        $('.holiday_date_input').each(function (i) {
                            let  s_date = $(this).val();
                            if (s_date == date) {
                                duplicate = 0;
                            }
                        });
                    }

                    if (date && duplicate != 0) {
                        const holidayDateEl = document.importNode(holidayTemplate.content, true);
                        holidayDateEl.querySelector('span').textContent = date;
                        holidayDateEl.querySelector('.holiday_date_input').value = date;
                        holidayDateElement.append(holidayDateEl);
                    }
                });

                $(document).on('click', '.holiday_date_close', function () {
                    if (confirm('Are you sure want to delete?')) {
                        $(this).closest('.holiday_date').remove();
                    }
                });
                

            });

        }(jQuery));
    </script>
@endpush
