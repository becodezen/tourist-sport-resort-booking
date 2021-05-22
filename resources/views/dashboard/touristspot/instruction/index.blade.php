@extends('layouts.master')

@section('content')

    <div class="box">
        <div class="box-header with-border">
            <div class="box-header-content">
                <h4 class="box-title">Route Instruction of {{ $spot->name }} </h4>
            </div>
            <div class="action">
                <a href="{{ route('instruction.create', $spot->id) }}" class="btn btn-primary">New Route instruction</a>
            </div>
        </div>
        <div class="box-body">
            <table class="table table-bordered table-hover mt-10">
                <thead>
                <tr>
                    <th style="width:50px">#</th>
                    <th>Title</th>
                    <th>Content</th>
                    <th style="width:120px">Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($spot->instructions as $key => $instruction)
                    <tr>
                        <td>{{ $key+1 }}</td>
                        <td>{{ $instruction->title }}</td>
                        <td>{{ substr(strip_tags($instruction->description), 0, 100) }}</td>
                        <td>
                            <div class="action-group">
                                <a href="{{ route('instruction.edit', ['tourist_spot_id' => $spot->id, 'id' => $instruction->id]) }}" class="btn btn-sm btn-primary" data-toggle="tooltip" data-placement="top" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                {!! Form::open(['route' => ['instruction.delete', ['tourist_spot_id' => $spot->id, 'id' => $instruction->id]], 'method' => 'DELETE']) !!}
                                <button class="btn btn-sm btn-danger" data-toggle="tooltip" data-placement="top" title="Delete" onclick="deleteSubmit(this, event)">
                                    <i class="fas fa-trash"></i>
                                </button>
                                {!! Form::close() !!}
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="box-footer">

        </div>
    </div>

@endsection
