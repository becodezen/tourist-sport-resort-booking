@extends('layouts.master')

@section('content')
    <div class="box">
        <div class="box-header with-border">
            <div class="box-header-content">
                <h4 class="box-title">Resort: {{ $resort->name }}</h4>
            </div>
            <div class="action">
                <a href="{{ route('resort.list') }}" class="btn btn-dark"><i class="fas fa-long-arrow-alt-left"></i> Back to List</a>
                <a href="{{ route('resort.photo.gallery', $resort->id) }}" class="btn btn-primary"><i class="fas fa-image"></i> Gallery</a>
            </div>
        </div>

        <div class="box-body">
            <h4 class="view-section-title">Resort Generator Information</h4>
            <div class="resort-contact">
                <p><i class="fas fa-map-marker"></i> {{ $resort->address }}</p>
                <p><i class="fas fa-phone"></i> {{ $resort->phone }}</p>
                <p><i class="fas fa-envelope"></i> {{ $resort->email }}</p>
            </div>
            <div class="row mt-20">
                <div class="col-md-6">
                    <h4 class="view-section-title">Facility (Inside)</h4>
                    @if($resort->facilities->where('facility_type', 'inside'))
                        <ul>
                            @foreach($resort->facilities->where('facility_type', 'inside') as $key => $in_facility)
                                <li>{{ $in_facility->name }}</li>
                            @endforeach
                        </ul>
                    @endif
                </div>
                <div class="col-md-6">
                    <h4 class="view-section-title">Facility (Outside)</h4>
                    @if($resort->facilities->where('facility_type', 'outside'))
                        <ul>
                            @foreach($resort->facilities->where('facility_type', 'outside') as $key => $in_facility)
                                <li>{{ $in_facility->name }}</li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>

            <h4 class="view-section-title">Resort Short Description</h4>
            {{ $resort->short_description }}
            <h4 class="view-section-title">Resort Details</h4>
            {!! $resort->description !!}
            <h4 class="view-section-title">Instruction</h4>
            {!! $resort->instruction !!}

            <div class="row mt-20">
                <div class="col-lg-12">
                    <h4 class="view-section-title">Photo Gallery</h4>
                </div>
            </div>
        </div>

        <div class="box-footer text-right">
            <a href="{{ route('resort.edit', $resort->id) }}" class="btn btn-primary">Update Resort Information</a>
        </div>
    </div>
    <div class="box">
        <div class="box-header with-border">
            <div class="box-header-content">
                <h4 class="box-title">Resort User</h4>
            </div>
            <div class="action">
                <a href="{{ route('resort.user.create', $resort->id) }}" class="btn btn-success">Add New</a>
            </div>
        </div>
        <div class="box-body">
            <table class="table table-hover table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Type</th>
                        <th style="width: 110px">Photo</th>
                        <th>Action</th>
                    </tr>
                </thead>
                @if($resort->families->isNotEmpty())
                    <tbody>
                    @foreach($resort->families as $key => $family)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ $family->name }}</td>
                            <td>{{ $family->email }}</td>
                            <td>{{ $family->phone }}</td>
                            <td>{{ $family->type }}</td>
                            <td>
                                <img src="{{ asset($family->photo) }}" alt="{{ $family->name }}">
                            </td>
                            <td>
                                <div class="action-group">
                                    <a href="{{ route('resort.user.edit', ['resort_id' => $resort->id, 'id' => $family->id]) }}" class="btn btn-sm btn-primary" data-toggle="tooltip" data-placement="top" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    {!! Form::open(['route' => ['resort.user.delete', ['resort_id' => $resort->id, 'id' => $family->id]], 'method' => 'DELETE']) !!}
                                    <button class="btn btn-sm btn-danger" data-toggle="tooltip" data-placement="top" title="Delete" onclick="deleteSubmit(this, event)">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                    {!! Form::close() !!}
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                    @else
                    <tr>
                        <td colspan="6">No Resort Family Found</td>
                    </tr>
                @endif
            </table>
        </div>
        <div class="box-footer">

        </div>
    </div>
@endsection
