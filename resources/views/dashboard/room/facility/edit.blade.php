@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-lg-5">
            <div class="box">
                <div class="box-header with-border">
                    <div class="box-header-content">
                        <h4 class="box-title">Update Facility</h4>
                    </div>
                </div>
                {!! Form::open(['route' => ['room.facility.update', $facility->id], 'method' => 'PUT']) !!}
                <div class="box-body">
                    {{--@if($user_type === 'system_user')
                        <div class="form-group">
                            <label for="">Resort</label>
                            {!! Form::select('resort', formSelectOptions($resorts), null, ['class' => 'form-control', 'placeholder' => 'Select Resort']) !!}
                            <span class="text-danger"></span>
                        </div>
                    @elseif($user_type === 'resort_user')
                        <input type="hidden" name="resort" value="{{ $resorts }}">
                    @endif--}}
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" name="name" id="name" placeholder="Facility name" class="form-control" value="{{ $facility->name }}">
                        <span class="text-danger"></span>
                    </div>
                    <div class="form-group">
                        <label for="description">Description (Optional)</label>
                        <textarea name="description" id="description" rows="2"  placeholder="Description name" class="form-control">{{ $facility->description }}</textarea>
                        <span class="text-danger"></span>
                    </div>
                    <div class="form-group">
                        <label for="name">Facility Type</label>
                        {!! Form::select('facility_type', getFacilityType(), $facility->facility_type, ['placeholder' => 'Select Facility Type', 'class' => "form-control"]) !!}
                        <span class="text-danger"></span>
                    </div>
                </div>
                <div class="box-footer">
                    <button class="btn btn-success" type="submit" onclick="formSubmit(this, event)">Update</button>
                </div>
                {!! Form::close() !!}
            </div>

        </div>
        <div class="col-lg-7">
            <div class="box">
                <div class="box-header with-border">
                    <div class="box-header-content">
                        <h4 class="box-title">Room Facilities</h4>
                    </div>
                </div>
                <div class="box-body">
                    <table class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Type</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if($facilities->isNotEmpty())
                            @foreach($facilities as $key => $facility)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $facility->name }}</td>
                                    <td>{{ $facility->description }}</td>
                                    <td>{{ ucfirst($facility->facility_type) }}</td>
                                    <td>
                                        @if($facility->created_by === Auth::user()->id)
                                            <div class="action-group">
                                                <a href="{{ route('room.facility.edit', $facility->id) }}" class="btn btn-sm btn-primary" data-toggle="tooltip" data-placement="top" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                {!! Form::open(['route' => ['room.facility.delete', $facility->id], 'method' => 'DELETE']) !!}
                                                <button class="btn btn-sm btn-danger" data-toggle="tooltip" data-placement="top" title="Delete" onclick="deleteSubmit(this, event)">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            {!! Form::close() !!}
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="5">No Facility Found</td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
