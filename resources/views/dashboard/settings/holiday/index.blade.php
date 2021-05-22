@extends('layouts.master')

@section('content')
<div class="row">
    <div class="col-lg-6">
        @include('dashboard.settings.holiday.create')
    </div>
    <div class="col-lg-6">
        <div class="box">
            <div class="box-header with-border">
                <div class="box-header-content">
                    <h4 class="box-title">Holidays</h4>
                </div>
            </div>
            <div class="box-body">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    @if($holidays->isNotEmpty())
                        @foreach($holidays as $key => $holiday)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $holiday->name }}</td>
                                <td>{!! $holiday->dates() !!}</td>
                                <td>
                                    <div class="action-group">
                                        <a href="{{ route('holiday.edit', $holiday->id) }}" class="btn btn-sm btn-primary" data-toggle="tooltip" data-placement="top" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        {!! Form::open(['route' => ['holiday.delete', $holiday->id], 'method' => 'DELETE']) !!}
                                        <button class="btn btn-sm btn-danger" data-toggle="tooltip" data-placement="top" title="Delete" onclick="deleteSubmit(this, event)">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    {!! Form::close() !!}
                                </td>
                            </tr>
                        @endforeach
                        @else
                        <tr>
                            <td colspan="5">No Holiday Found</td>
                        </tr>
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
