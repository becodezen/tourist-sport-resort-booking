<div class="box">
    <div class="box-header with-border">
        <div class="box-header-content">
            <h4 class="box-title">Create Holiday</h4>
        </div>
    </div>
    {!! Form::open(['route' => 'holiday.store', 'method' => 'POST']) !!}
    <div class="box-body">
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" id="name" placeholder="Holiday name" class="form-control">
            <span class="text-danger"></span>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" id="description" class="form-control" placeholder="Enter description"></textarea>
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
            <div id="holidayDates"></div>
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
