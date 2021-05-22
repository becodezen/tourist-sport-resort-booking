@extends('layouts.master')

@section('content')
    <div class="box">
        <div class="box-header">
            <div class="box-header-content">
                <h4 class="box-title">Sliders Manage</h4>
            </div>
            <div class="action">
                <a href="{{ route('slider.create') }}" class="btn btn-light">New Slider</a>
            </div>
        </div>
        <div class="box-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Image</th>
                        <th>Title</th>
                        <th>Created At</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                @if($sliders->isNotEmpty())
                    @foreach($sliders as $key => $slider)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>
                                <img src="{{ asset($slider->image) }}" alt="" style="width: 100px">
                            </td>
                            <td>{{ $slider->title }}</td>
                            <td>{{ $slider->created_at }}</td>
                            <td>
                                <div class="action-group">
                                    <a href="{{ route('slider.edit', $slider->id) }}" class="btn btn-sm btn-primary" data-toggle="tooltip" data-placement="top" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    {!! Form::open(['route' => ['slider.delete', $slider->id], 'method' => 'DELETE']) !!}
                                    <button class="btn btn-sm btn-danger" data-toggle="tooltip" data-placement="top" title="Delete" onclick="deleteSubmit(this, event)">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                {!! Form::close() !!}
                            </td>
                        </tr>
                    @endforeach
                @endif
                </tbody>
            </table>
        </div>
        <div class="box-footer"></div>
    </div>
@endsection
