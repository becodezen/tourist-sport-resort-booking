@extends('layouts.master')

@section('content')
    <div class="box">
        <div class="box-header with-border">
            <h5 class="box-title">Booking Calendar</h5>
        </div>
        <div class="box-body">
            {!! Form::open(['route' => 'booking.calendar.room', 'method' => 'POST']) !!}
            <div class="row">
                <div class="col-md-6 offset-3">
                    <div class="form-group">
                        <label for="">Resort</label>
                        {!! Form::select('resort', formSelectOptions($resorts), [], ['placeholder' => 'Select Resort', 'class' => 'form-control', 'id' => 'resort', 'required']) !!}
                        <span class="text-danger"></span>
                    </div>
                    <div class="mt-25">
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Get Calendar</button>
                        </div>
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection

@push('plugin-styles')
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
@endpush

@push('plugin-scripts')
    <script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}"></script>
@endpush

@push('footer-scripts')
<script>
    $(document).ready(function() {
        if($('#resort').length > 0) {
            $('#resort').select2({
                placeholder: "Select Resort"
            });
        }
    })
</script>
@endpush
