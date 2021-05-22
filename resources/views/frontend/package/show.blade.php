@extends('layouts.frontend')

@section('content')

    {{-- slider --}}
    @include('partials._fr_page_title')

    <div class="package-area pb-50 pt-50">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="resort-box">
                        <div class="resort-box-header">
                            <h4 class="resort-box-title">Package Details</h4>
                        </div>
                        <div class="resort-box-body">
                            <div class="package">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="package-thumbnail mb-15">
                                            @if($assign->thumbnail)
                                                <img src="{{ asset($assign->thumbnail) }}" alt="">
                                                @else
                                                <img src="{{ asset($assign->package->thumbnail) }}" alt="">
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <h2 class="mb-15">{{ $assign->package->name }}</h2>
                                        <p>{{ $assign->package->short_description }}</p>
                                        <div class="package-description mt-15">
                                            <h4>Pricing</h4>
                                            <table class="table table-bordered mt-10">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Price(Per Unit)</th>
                                                        <th>Per Unit</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($assign->package->packagePrices as $key => $p_price)
                                                    <tr>
                                                        <td>{{ $key+1 }}</td>
                                                        <td>{{ $p_price->price }}</td>
                                                        <td>{{ $p_price->unit }}</td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            <h4>Route:</h4>
                                            <table class="table table-bordered mt-10">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Routes</th>
                                                        <th>Boarding Points</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($assign->package->packageRoutes as $key => $p_route)
                                                    <tr>
                                                        <td>{{ $key+1 }}</td>
                                                        <td>{{ $p_route->route }}</td>
                                                        <td>{{ $p_route->boarding_points }}</td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <h4 class="mt-15">About Package</h4>
                                {!! $assign->package->description !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="resort-box">
                        <div class="resort-box-header">
                            <h4 class="resort-box-title">Book in this package</h4>
                        </div>

                        <div class="resort-box-body">
                            {!! Form::open(['route' => ['fr.package.booking', $assign->id], 'method' => 'POST']) !!}
                                <div class="booking-form">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">Name</label>
                                                <div class="form-input-group">
                                                    <i class="fas fa-user"></i>
                                                    <input type="text" name="name" class="form-control" placeholder="Enter name" value="{{ Auth::guard('customer')->check() ? Auth::guard('customer')->user()->name : '' }}">
                                                </div>
                                                <span class="text-danger"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">Phone</label>
                                                <div class="form-input-group">
                                                    <i class="fas fa-phone"></i>
                                                    <input type="text" name="phone" class="form-control" placeholder="Enter phone" value="{{ Auth::guard('customer')->check() ? Auth::guard('customer')->user()->phone : '' }}">
                                                </div>
                                                <span class="text-danger"></span>
                                            </div>
                                            @if(!Auth::guard('customer')->user())
                                                <label>
                                                    <input type="checkbox" value="1" name="is_user" id="isUser">
                                                    <span>Registration as User?</span>
                                                </label>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">Email</label>
                                                <div class="form-input-group">
                                                    <i class="fas fa-envelope"></i>
                                                    <input type="email" name="email" class="form-control" placeholder="Enter email" value="{{ Auth::guard('customer')->check() ? Auth::guard('customer')->user()->email : '' }}">
                                                </div>
                                                <span class="text-danger"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">Address</label>
                                                <div class="form-input-group">
                                                    <i class="fas fa-map-marker-alt"></i>
                                                    <input type="text" name="address" class="form-control" placeholder="Enter address">
                                                </div>
                                                <span class="text-danger"></span>
                                            </div>
                                        </div>
                                    </div>

                                    @if(!Auth::guard('customer')->user())
                                    <div class="row" id="registerAsUser">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">Password</label>
                                                <div class="form-input-group">
                                                    <i class="fas fa-lock"></i>
                                                    <input type="password" name="password" class="form-control" placeholder="*******">
                                                </div>
                                                <span class="text-danger"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">Confirm Password</label>
                                                <div class="form-input-group">
                                                    <i class="fas fa-lock"></i>
                                                    <input type="password" name="password_confirmation" class="form-control" placeholder="*******">
                                                </div>
                                                <span class="text-danger"></span>
                                            </div>
                                        </div>
                                    </div>
                                    @endif

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">Routes</label>
                                                <div class="form-input-group">
                                                    <i class="fas fa-route"></i>
                                                    {!! Form::select('package_route', formSelectOptions($assign->package->packageRoutes, 'id', 'route'), null, ['placeholder' => 'Select Route', 'class' => 'form-control', 'id' => 'packageRoute']) !!}
                                                </div>
                                                <span class="text-danger"></span>
                                            </div>
                                            <div class="form-group">
                                                <label for="">Boarding Points</label>
                                                <div id="routeBoardingPoint"><span class="text-danger">Select a route first</span></div>
                                                <span class="text-danger"></span>
                                            </div>

                                            <div class="form-group" id="customBoardingPoint" style="display: none">
                                                <label for="">Custom Boarding Point</label>
                                                <div class="form-input-group">
                                                    <i class="fas fa-map-pin"></i>
                                                    <input type="text" placeholder="Custom boarding point" name="custom_boarding_point" class="form-control">
                                                </div>
                                                <span class="text-danger"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">Members</label>
                                                <div class="form-input-group">
                                                    <i class="fas fa-users"></i>
                                                    <input type="number" min="{{ $assign->package->min_member }}" value="{{ $assign->package->min_member }}" name="member" class="form-control" id="members">
                                                </div>
                                                <span class="text-danger"></span>
                                            </div>
                                            @if($assign->package->packagePrices->count() > 1)
                                                <div class="form-group">
                                                    <label for="">Price</label>
                                                    <div class="form-input-group">
                                                        <i class="fas fa-route"></i>
                                                        {!! Form::select('package_price', formSelectOptions($assign->package->packagePrices, 'id', 'price_unit'), null, ['class' => 'form-control']) !!}
                                                    </div>
                                                    <span class="text-danger"></span>
                                                </div>
                                            @else
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="">Price (Unit: {{ $assign->package->packagePrices->first()->unit }})</label>
                                                            <div class="form-input-group">
                                                                <i class="fas fa-dollar-sign"></i>
                                                                <input type="text" name="package_price" value="{{ $assign->package->packagePrices->first()->price }}" class="form-control" readonly>
                                                            </div>
                                                            <span class="text-danger"></span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="">Total (<span id="memberPrice">{{ $assign->package->packagePrices->first()->price }} X {{ $assign->package->min_member }}</span>)</label>
                                                            <div class="form-input-group">
                                                                <i class="fas fa-dollar-sign"></i>
                                                                <input type="text" name="total_price" value="{{ $assign->package->packagePrices->first()->price*$assign->package->min_member }}" class="form-control" readonly>
                                                            </div>
                                                            <span class="text-danger"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif

                                            <div class="form-group">
                                                <label for="">Note</label>
                                                <textarea name="note" class="form-control" placeholder="Write short note"></textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-3 offset-9">
                                            <div class="form-group form-group-submit mt-30">
                                                <button class="btn btn-primary w-100" type="submit" onclick="formSubmit(this, event)">Booked Now</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <template id="packageBoardingPointTemplate">
        <div class="bp-item">
            <label class="cursor-pointer">
                <input type="radio" name="boarding_point" class="boarding_point_input">
                <span></span>
            </label>
        </div>
    </template>

@endsection


@push('footer-scripts')
    <script>
        (function($){
            "use-strict"

            jQuery(document).ready(function() {
                //guest list find
                $(document).on('change', '#packageRoute', function () {
                    const package_route_id = $(this).val();

                    if (package_route_id) {
                        const _token = $('input[name="_token"]').val();
                        const method = 'GET';

                        $.ajax("{{ route('get.package.route.boardingpoints') }}", {
                            method: method,
                            data: {
                                package_route_id: package_route_id,
                                _token: _token
                            },
                            beforeSend: function (xhr) {
                                $('#routeBoardingPoint').html('');
                            },
                            success: function (res, status, xhr) {
                                if (res.status) {
                                    const bpElement = document.getElementById('routeBoardingPoint');
                                    const bpTemplate = document.getElementById('packageBoardingPointTemplate');
                                    let boarding_points = res.boarding_points;

                                    if (boarding_points.length > 0) {
                                        for (const boarding_point of boarding_points) {
                                            const bpEl = document.importNode(bpTemplate.content, true);
                                            bpEl.querySelector('.boarding_point_input').value = boarding_point;
                                            bpEl.querySelector('span').textContent = boarding_point
                                            bpElement.append(bpEl);
                                        }
                                    }
                                }
                            }
                        });
                    } else {
                        $('#routeBoardingPoint').html('<span class="text-danger">Select a route first</span>');
                        $('#customBoardingPoint').hide();
                        $('input[name="custom_boarding_point"]').val('');
                    }
                });

                $(document).on('change', '.boarding_point_input', function() {
                    let boarding_point = $(this).val();

                    if (boarding_point == 'Other') {
                        $('#customBoardingPoint').show();
                    } else {
                        $('#customBoardingPoint').hide();
                        $('input[name="custom_boarding_point"]').val('');
                    }
                });

                $(document).on('keyup change', '#members', function () {
                    let member = $(this).val();
                    if ($('input[name="package_price"]').length > 0) {
                        let price = $('input[name="package_price"]').val();
                        $('#memberPrice').html(price+' X '+member);
                        $('input[name="total_price"]').val(price*member);

                    }
                });

                $('#registerAsUser').hide();
                $(document).on('change', '#isUser', function () {
                    if($(this).is(':checked')) {
                        $('#registerAsUser').slideDown();
                    } else {
                        $('#registerAsUser').slideUp();
                        $('input[type="password"]').val('');
                    }
                });

            });

        }(jQuery))

    </script>
@endpush
