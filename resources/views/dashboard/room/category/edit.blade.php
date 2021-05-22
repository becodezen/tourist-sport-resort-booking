@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-lg-5">
            <div class="box">
                <div class="box-header with-border">
                    <div class="box-header-content">
                        <h4 class="box-title">Update Category</h4>
                    </div>
                </div>
                {!! Form::open(['route' => ['room.category.update', $category->id], 'method' => 'PUT']) !!}
                <div class="box-body">
                    {{--@if($user_type === 'system_user')
                        <div class="form-group">
                            <label for="">Resort</label>
                            {!! Form::select('resort', formSelectOptions($resorts), $category->resort_id, ['class' => 'form-control', 'placeholder' => 'Select Resort']) !!}
                            <span class="text-danger"></span>
                        </div>
                    @elseif($user_type === 'resort_user')
                        <input type="hidden" name="resort" value="{{ $category->resort_id }}">
                    @endif--}}
                    <div class="form-group">
                        <label for="room_type">Room Type</label>
                        <input type="text" name="room_type" id="room_type" placeholder="E.G. AC" class="form-control" value="{{ $category->room_type }}">
                        <span class="text-danger"></span>
                    </div>
                    <div class="form-group">
                        <label for="bed_size">Bed Size</label>
                        <input type="text" name="bed_size" id="bed_size" placeholder="E.G. Single" class="form-control" value="{{ $category->bed_size }}">
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
                        <h4 class="box-title">Room Category</h4>
                    </div>
                </div>
                <div class="box-body">
                    <table class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Type</th>
                            <th>Bed Size</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if($categories->isNotEmpty())
                            @foreach($categories as $key => $category)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $category->room_type }}</td>
                                    <td>{{ $category->bed_size }}</td>
                                    <td>
                                        <div class="action-group">
                                            <a href="{{ route('room.category.edit', $category->id) }}" class="btn btn-sm btn-primary" data-toggle="tooltip" data-placement="top" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            {!! Form::open(['route' => ['room.category.delete', $category->id], 'method' => 'DELETE']) !!}
                                            <button class="btn btn-sm btn-danger" data-toggle="tooltip" data-placement="top" title="Delete" onclick="deleteSubmit(this, event)">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        {!! Form::close() !!}
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
