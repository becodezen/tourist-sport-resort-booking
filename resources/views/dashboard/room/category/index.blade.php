@extends('layouts.master')

@section('content')
<div class="row">
    <div class="col-lg-5">
        @include('dashboard.room.category.create')
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
