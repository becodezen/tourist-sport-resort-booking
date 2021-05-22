@extends('layouts.master')

@section('content')

    <div class="box">
        <div class="box-header with-border">
            <div class="box-header-content">
                <h5 class="box-title">Update Package</h5>
            </div>
            <div class="action">
                <a href="{{ route('package.list') }}" class="btn btn-danger">Package List</a>
            </div>
        </div>
        {!! Form::open(['route' => ['package.update', $package->id], 'method' => 'PUT']) !!}
        <div class="box-body">
            <div class="row">
                <div class="col-md-8">
                    <div class="form-group">
                        <label for="">Package Name</label>
                        <input type="text" name="name" placeholder="package name" class="form-control" value="{{ $package->name }}">
                        <span class="text-danger"></span>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="">Minimum Member</label>
                        <input type="number" step="1" name="min_member" placeholder="Min Member" class="form-control" value="{{ $package->min_member }}">
                        <span class="text-danger"></span>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="">Short Description</label>
                <textarea name="short_description"  rows="5" class="form-control" placeholder="write short description about the package">{{ $package->short_description }}</textarea>
                <span class="text-danger"></span>
            </div>
            <div class="form-group">
                <label for="">Description</label>
                <textarea name="description" class="form-control description-summernote">{!! $package->description !!}</textarea>
                <span class="text-danger"></span>
            </div>
            @if($package->packageRoutes->isNotEmpty())
                @foreach ($package->packageRoutes as $key => $p_route)
                    <div class="row">
                        <div class="col-md-5 col-sm-5">
                            <div class="form-group">
                                <label for="">Package Route</label>
                                <input type="text" name="routes[]" placeholder="package route" class="form-control" value="{{ $p_route->route }}">
                                <span class="text-danger"></span>
                            </div>
                        </div>
                        <div class="col-md-5 col-sm-5">
                            <div class="form-group">
                                <label for="">Boarding Point(Separated by(,)comma)</label>
                                <input type="text" name="boarding_points[]" placeholder="Dhaka, Cumilla, Sylhet....." class="form-control" value="{{ $p_route->boarding_points }}">
                                <span class="text-danger"></span>
                            </div>
                        </div>
                        <div class="col-md-2 col-sm-2">
                            <button type="button" class="btn {{ $key > 0 ? 'btn-danger' : 'btn-primary' }} btn-sm mt-25 float-right ml-auto {{ $key > 0 ? 'removePackageRoute' : '' }}" id="{{ $key == 0 ? 'addPackageRoute' : '' }}">{!! $key > 0 ? '<i class="fas fa-minus"></i>' : '<i class="fas fa-plus"></i>' !!}</button>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="row">
                    <div class="col-md-5 col-sm-5">
                        <div class="form-group">
                            <label for="">Package Route</label>
                            <input type="text" name="routes[]" placeholder="package route" class="form-control">
                            <span class="text-danger"></span>
                        </div>
                    </div>
                    <div class="col-md-5 col-sm-5">
                        <div class="form-group">
                            <label for="">Boarding Point(Separated by(,)comma)</label>
                            <input type="text" name="boarding_points[]" placeholder="Dhaka, Cumilla, Sylhet....." class="form-control">
                            <span class="text-danger"></span>
                        </div>
                    </div>
                    <div class="col-md-2 col-sm-2">
                        <button type="button" class="btn btn-primary btn-sm mt-25 float-right ml-auto" id="addPackageRoute"><i class="fas fa-plus"></i></button>
                    </div>
                </div>
            @endif
            <div id="moreRoutes"></div>
            @if($package->packagePrices->isNotEmpty())
                @foreach ($package->packagePrices as $key => $p_price)
                    <div class="row">
                        <div class="col-md-5 col-sm-5">
                            <div class="form-group">
                                <label>Unit</label>
                                <input type="text" name="package_units[]" class="form-control" placeholder="Package unit" value="{{ $p_price->unit }}">
                                <span class="text-danger"></span>
                            </div>
                        </div>
                        <div class="col-md-5 col-sm-5">
                            <div class="form-group">
                                <label>Package Price</label>
                                <input type="text" name="package_prices[]" class="form-control" placeholder="Price" value="{{ $p_price->price }}">
                                <span class="text-danger"></span>
                            </div>
                        </div>
                        <div class="col-md-2 col-sm-2">
                            <button type="button" class="btn {{ $key > 0 ? 'btn-danger' : 'btn-primary' }} btn-sm mt-25 float-right ml-auto {{ $key > 0 ? 'removePackagePrice' : '' }}" id="{{ $key == 0 ? 'addPackagePrice' : '' }}">{!! $key > 0 ? '<i class="fas fa-minus"></i>' : '<i class="fas fa-plus"></i>' !!}</button>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="row">
                    <div class="col-md-5 col-sm-5">
                        <div class="form-group">
                            <label>Unit</label>
                            <input type="text" name="package_units[]" class="form-control" placeholder="Package unit">
                            <span class="text-danger"></span>
                        </div>
                    </div>
                    <div class="col-md-5 col-sm-5">
                        <div class="form-group">
                            <label>Package Price</label>
                            <input type="text" name="package_prices[]" class="form-control" placeholder="Price">
                            <span class="text-danger"></span>
                        </div>
                    </div>
                    <div class="col-md-2 col-sm-2">
                        <button type="button" class="btn btn-success btn-sm mt-25 float-right ml-auto" id="addPackagePrice"><i class="fas fa-plus"></i></button>
                    </div>
                </div>
            @endif

            <div id="morePrices"></div>
            <div class="form-group">
                <label>Packge Thumbnail (Photo)</label><br>
                <input type="file" name="thumbnail"><br>
                <span class="text-danger"></span>
            </div>
        </div>
        <div class="box-footer">
            <button class="btn btn-primary btn-sm" type="submit" onclick="formSubmit(this, event)">Save Package</button>
        </div>
        {!! Form::close() !!}
    </div>

    <template id="packageRouteTemplate">
        <div class="row">
            <div class="col-md-5 col-sm-5">
                <div class="form-group">
                    <label for="">Package Route</label>
                    <input type="text" name="routes[]" placeholder="package route" class="form-control">
                    <span class="text-danger"></span>
                </div>
            </div>
            <div class="col-md-5 col-sm-5">
                <div class="form-group">
                    <label for="">Boarding Point(Separated by(,)comma)</label>
                    <input type="text" name="boarding_points[]" placeholder="Dhaka, Cumilla, Sylhet....." class="form-control">
                    <span class="text-danger"></span>
                </div>
            </div>
            <div class="col-md-2 col-sm-2">
                <button class="btn btn-danger btn-sm mt-25 float-right ml-auto removePackageRoute"><i class="fas fa-minus"></i></button>
            </div>
        </div>
    </template>

    <template id="packagePriceTemplate">
        <div class="row">
            <div class="col-md-5 col-sm-5">
                <div class="form-group">
                    <label>Unit</label>
                    <input type="text" name="package_units[]" class="form-control" placeholder="Package unit">
                    <span class="text-danger"></span>
                </div>
            </div>
            <div class="col-md-5 col-sm-5">
                <div class="form-group">
                    <label>Package Price</label>
                    <input type="text" name="package_prices[]" class="form-control" placeholder="Price">
                    <span class="text-danger"></span>
                </div>
            </div>
            <div class="col-md-2 col-sm-2">
                <button class="btn btn-danger btn-sm mt-25 float-right ml-auto removePackagePrice"><i class="fas fa-minus"></i></button>
            </div>
        </div>
    </template>

@endsection

@push('plugin-styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css">
@endpush

@push('plugin-scripts')
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
@endpush


@push('footer-scripts')
    <script>
        (function($){
            "use-strict"

            jQuery(document).ready(function() {

                if ($('.description-summernote').length > 0) {
                    $(".description-summernote").summernote({
                        minHeight: 200,
                        maxHeight: null,
                        focus: !1,
                        toolbar: [
                            // [groupName, [list of button]]
                            ['style', ['bold', 'italic', 'underline', 'clear']],
                            ['fontsize', ['fontsize']],
                            ['para', ['ul', 'ol', 'paragraph']],
                        ],
                        placeholder: 'Write description...........'
                    });
                }

                $(document).on('click', '#addPackageRoute', function(){
                    const packageRouteElement = document.getElementById('moreRoutes');
                    const packageRouteTemplate = document.getElementById('packageRouteTemplate');

                    const packageRouteEl = document.importNode(packageRouteTemplate.content, true);

                    packageRouteElement.append(packageRouteEl);
                });

                $(document).on('click', '.removePackageRoute', function() {
                    $(this).closest('.row').remove();
                });

                $(document).on('click', '#addPackagePrice', function(){
                    const packagePriceElement = document.getElementById('morePrices');
                    const packagePriceTemplate = document.getElementById('packagePriceTemplate');

                    const packagePriceEl = document.importNode(packagePriceTemplate.content, true);

                    packagePriceElement.append(packagePriceEl);
                });

                $(document).on('click', '.removePackagePrice', function() {
                    $(this).closest('.row').remove();
                });

            });

        }(jQuery))


    </script>
@endpush
