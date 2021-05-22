@extends('layouts.master')

@section('content')

<div class="box">
    <div class="box-header with-border">
        <div class="box-header-content">
            <h5 class="box-title">Package list</h5>
        </div>
        <div class="action">
            <a href="{{ route('package.create') }}" class="btn btn-sm btn-light">Create new Package</a>
        </div>
    </div>
    <div class="box-body">
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Short Description</th>
                    <th>Assign Package</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            @if($packages->isNotEmpty())
                @foreach ($packages as $key => $package)
                    <tr>
                        <td>{{ $key+1 }}</td>
                        <td>{{ $package->name }}</td>
                        <td>{{ $package->short_description }}</td>
                        <td>
                            <button type="button" class="btn btn-sm btn-info" id="assignPackage" data-package_id="{{ $package->id }}" data-toggle="modal" data-target="#assignModal" title="Assign Package">
                                Package Assign
                            </button>
                        </td>
                        <td>
                            <div class="action-group">
                                <a href="{{ route('package.show', $package->id) }}" class="btn btn-sm btn-success" data-toggle="tooltip" data-placement="top" title="View Details">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('package.edit', $package->id) }}" class="btn btn-sm btn-primary" data-toggle="tooltip" data-placement="top" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                {!! Form::open(['route' => ['package.delete', $package->id], 'method' => 'DELETE']) !!}
                                <button class="btn btn-sm btn-danger" data-toggle="tooltip" data-placement="top" title="Delete" onclick="deleteSubmit(this, event)">
                                    <i class="fas fa-trash"></i>
                                </button>
                                {!! Form::close() !!}
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
