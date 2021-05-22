@extends('layouts.master')

@section('content')

<div class="box">
    <div class="box-header with-border">
        <div class="box-header-content">
            <h5 class="box-title">Package Booking list</h5>
        </div>
    </div>
    <div class="box-body">
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Booking No</th>
                    <th>Package</th>
                    <th>Date</th>
                    <th>Guest</th>
                    <th>Boarding Point</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            @if($bookings->isNotEmpty())
                @foreach ($bookings as $key => $booking)
                    <tr>
                        <td>{{ $key+1 }}</td>
                        <td>{{ $booking->booking_no }}</td>
                        <td>{{ $booking->assignPackage->package->name }}</td>
                        <td>{!! $booking->assignPackage->check_in . '<br>' . $booking->assignPackage->check_out !!}</td>
                        <td>{{ $booking->guest->name }}</td>
                        <td>{{ $booking->boarding_point }}</td>
                        <td>{{ $booking->status }}</td>
                        <td>
                            <div class="action-group">
                                <a href="{{ route('package.booking.show', $booking->id) }}" class="btn btn-sm btn-success" data-toggle="tooltip" data-placement="top" title="View Details">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforeach
            @else
            <tr>
                <td colspan="5">No Package Found</td>
            </tr>
            @endif
            </tbody>
        </table>
    </div>
</div>
@endsection


@push('plugin-styles')
    <link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}">
@endpush


@push('plugin-scripts')
    <script src="{{ asset('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
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
                        autoclose: true,
                        autocomplete: true,
                        startDate: new Date()
                    });
                }



                $(document).on('click', '#assignPackage', function () {
                    const package_id = $(this).data('package_id');
                    const _token = $('input[name="_token"]').val();

                    $.ajax("{{ route('get.package') }}", {
                        method: "GET",
                        data: {
                            package_id: package_id
                        },
                        beforeSend: function (xhr) {
                            $('#package_form_date').val('');
                            $('#package_to_date').val('');
                            $('#package_id').val('');
                            $('#package_price').val('');
                        },
                        success: function (res, status, xhr) {
                            if (res.status) {
                                $('#package_id').val(res.data.id);
                                $('#package_price').val(res.data.price);
                            }
                        },
                        error: function (jqXhr, textStatus, errorMessage) {
                            console.log(textStatus);
                        }
                    });
                });


            });

        }(jQuery));
    </script>
@endpush
