@extends('layouts.master')

@section('content')

<div class="row mb-15">
    <div class="col-md-3">
        <div class="dashboard-widget dw-one">
            <div class="dashboard-widget-content">
                <strong>Resorts</strong>
                <h3>{{ $resorts }}+</h3>
            </div>
            <div class="dashboard-widget-icon">
                <i class="fas fa-image"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="dashboard-widget dw-two">
            <div class="dashboard-widget-content">
                <strong>Tourist Spot</strong>
                <h3>{{ $spots }}+</h3>
            </div>
            <div class="dashboard-widget-icon">
                <i class="fas fa-image"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="dashboard-widget dw-three">
            <div class="dashboard-widget-content">
                <strong>Bookings</strong>
                <h3>{{ $bookings }}+</h3>
            </div>
            <div class="dashboard-widget-icon">
                <i class="fas fa-list"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="dashboard-widget dw-four">
            <div class="dashboard-widget-content">
                <strong>Customers</strong>
                <h3>{{ $guests }}+</h3>
            </div>
            <div class="dashboard-widget-icon">
                <i class="fas fa-user"></i>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header with-border">
                <div class="box-header-content">
                    <h5 class="box-title">Latest Booking Request</h5>
                </div>
                <div class="action">
                    <a href="" class="btn btn-sm btn-light">All Booking</a>
                </div>
            </div>
            <div class="box-body">
                <table class="table-bordered table table-striped">
                    <thead>
                        <tr>
                            <th>Booking No</th>
                            <th>Resort</th>
                            <th>Guest</th>
                            <th>Date</th>
                            <td>Action</td>
                        </tr>
                    </thead>
                </table>
            </div>
            <div class="box-footer"></div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="box">
            <div class="box-header with-border">
                <div class="box-header-content">
                    <h5 class="box-title">Package Booking</h5>
                </div>
                <div class="action">
                    <a href="" class="btn btn-sm btn-light">All Package Booking Request</a>
                </div>
            </div>
            <div class="box-body">
            </div>
            <div class="box-footer"></div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="box">
            <div class="box-header with-border">
                <div class="box-header-content">
                    <h5 class="box-title">Latest Registered Guest</h5>
                </div>
                <div class="action">
                    <a href="" class="btn btn-sm btn-light">All Guest</a>
                </div>
            </div>
            <div class="box-body">
            </div>
            <div class="box-footer"></div>
        </div>
    </div>
</div>

{{-- <div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header with-border">
                <div class="box-header-content">Calendar</div>
                <div class="action">
                    <a href="" class="btn btn-sm btn-light">View Details Calendar</a>
                </div>
            </div>
            <div class="box-body">
            </div>
            <div class="box-footer"></div>
        </div>
    </div>
</div> --}}

@endsection
