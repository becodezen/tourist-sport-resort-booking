@extends('layouts.master')

@section('content')
    <div class="box">
        <div class="box-header">
            <div class="box-header-content">
                <h4 class="box-title">Sessional Pricing Setup</h4>
            </div>
            <div class="action">
                <a href="{{ route('season.create') }}" class="btn btn-light">Add new</a>
            </div>
        </div>
        <div class="box-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                @if($pricings->isNotEmpty())
                    @foreach($pricings as $key => $pricing)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ $pricing->name }}</td>
                            <td>{{ $pricing->from_date }} To {{ $pricing->to_date }}</td>
                            <td>
                                @if($pricing->created_by === Auth::user()->id)
                                    <div class="action-group">
                                        <a href="{{ route('season.edit', $pricing->id) }}" class="btn btn-sm btn-primary" data-toggle="tooltip" data-placement="top" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        {!! Form::open(['route' => ['season.delete', $pricing->id], 'method' => 'DELETE']) !!}
                                        <button class="btn btn-sm btn-danger" data-toggle="tooltip" data-placement="top" title="Delete" onclick="deleteSubmit(this, event)">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    {!! Form::close() !!}
                                @endif
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
