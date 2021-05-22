@extends('layouts.master')

@section('content')

    <div class="row">
        <div class="col-md-7">
            <div class="box">
                <div class="box-header with-border">
                    <div class="box-header-content">
                        <h5 class="box-title">Package Details</h5>
                    </div>
                    <div class="action">
                        <a href="{{ route('package.list') }}" class="btn btn-sm btn-light">Package List</a>
                    </div>
                </div>
                <div class="box-body">
                    <div class="mb-15">
                        <strong>Package Name: </strong>
                        {{ $package->name }}
                    </div>
                    <div class="mb-15">
                        <strong>Package Routes: </strong>
                        <table class="table table-bordered mt-10">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Routes</th>
                                    <th>Boarding Points</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($package->packageRoutes as $key => $p_route)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $p_route->route }}</td>
                                    <td>{{ $p_route->boarding_points }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                    <div class="mb-15">
                        <strong>Package Price: </strong>
                        <table class="table table-bordered mt-10">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Price(Per Unit)</th>
                                    <th>Unit</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($package->packagePrices as $key => $p_price)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $p_price->price }}</td>
                                    <td>{{ $p_price->unit }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                    <div class="mb-15">
                        <strong>Package Short Description: </strong><br>
                        <p>{{ $package->short_description }}</p>
                    </div>
                    <div class="mb-15">
                        <strong>Package Description: </strong><br>
                        {!! $package->description !!}
                    </div>
                    <div>
                        <strong>Package Thumbnail: </strong><br>
                        <img src="{{ asset($package->thumbnail) }}" alt="" class="mt-10">
                    </div>
                </div>
                <div class="box-footer">
                    <a href="{{ route('package.edit', $package->id) }}" class="btn btn-warning btn-sm">Edit Package</a>
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="box">
                <div class="box-header with-border">
                    <div class="box-header-content">
                        <h5 class="box-title">Assigned Package</h5>
                    </div>
                    <div class="action">
                        <button type="button" class="btn btn-sm btn-info" id="assignPackage" data-package_id="{{ $package->id }}" data-toggle="modal" data-target="#assignModal" title="Assign Package">
                            Package Assign
                        </button>
                    </div>
                </div>
                <div class="box-body">
                    <table class="table table-hover table-stripped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Check-in</th>
                                <th>Check-out</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($package->assignPackages as $key => $assign)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ user_formatted_date($assign->check_in) }}</td>
                                    <td>{{ user_formatted_date($assign->check_out) }}</td>
                                    <td>
                                        <div class="action-group">
                                            {!! Form::open(['route' => ['assign.package.delete', $assign->id], 'method' => 'DELETE']) !!}
                                            <button class="btn btn-sm btn-danger" data-toggle="tooltip" data-placement="top" title="Delete" onclick="deleteSubmit(this, event)">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                            {!! Form::close() !!}
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

<div class="modal fade" id="assignModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Package: <span class="text-success"></span> Assign</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            {!! Form::open(['route' => 'package.assign.store', 'method' => 'POST']) !!}
            <div class="modal-body">
                <input type="hidden" name="package" id="package_id">
                <div class="form-group">
                    <label for="">From Date</label>
                    <input type="text" name="from_date" class="form-control datepicker" id="package_form_date" placeholder="Package from date" autocomplete="off">
                    <span class="text-danger"></span>
                </div>
                <div class="form-group">
                    <label for="">To Date</label>
                    <input type="text" name="to_date" class="form-control datepicker" id="package_to_date" placeholder="Package to date" autocomplete="off">
                    <span class="text-danger"></span>
                </div>
                <div class="form-group">
                    <label for="">Thumbnail</label> <br>
                    <input type="file" name="thumbnail"> <br>
                    <span class="text-danger"></span>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" onclick="formSubmit(this, event)">Assign Package</button>
            </div>
            {!! Form::close() !!}
        </div>
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
