@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="box">
                <div class="box-header with-border">
                    <div class="box-header-content">
                        <h4 class="box-title">Tourist Spots List</h4>
                    </div>
                    <div class="action">
                        <a href="{{ route('tourist.spot.create') }}" class="btn btn-primary">Add new</a>
                    </div>
                </div>
                <div class="box-body">
                    <table class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Division</th>
                            <th>District</th>
                            <th>Short Description</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                            @if($spots->isNotEmpty())
                                @foreach($spots as $key => $spot)
                                    <tr>
                                        <td>{{ $key+1 }}</td>
                                        <td>{{ $spot->name }}</td>
                                        <td>{{ $spot->division->name }}</td>
                                        <td>{{ $spot->district->name }}</td>
                                        <td>{{ substr($spot->short_description, 0, 100) }}........</td>
                                        <td>
                                            <div class="action-group">
                                                <a href="{{ route('tourist.spot.article.list', $spot->id) }}" class="btn btn-sm btn-outline-info" data-toggle="tooltip" data-placement="top" title="{{ $spot->name }}'s Galleries">
                                                    Articles
                                                </a>
                                                <a href="{{ route('tourist.spot.gallery', $spot->id) }}" class="btn btn-sm btn-warning" data-toggle="tooltip" data-placement="top" title="{{ $spot->name }}'s Galleries">
                                                    <i class="fas fa-images"></i>
                                                </a>
                                                <a href="{{ route('tourist.spot.show', $spot->id) }}" class="btn btn-sm btn-success" data-toggle="tooltip" data-placement="top" title="View Details">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('tourist.spot.edit', $spot->id) }}" class="btn btn-sm btn-primary" data-toggle="tooltip" data-placement="top" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                {!! Form::open(['route' => ['tourist.spot.delete', $spot->id], 'method' => 'DELETE']) !!}
                                                    <button class="btn btn-sm btn-danger" data-toggle="tooltip" data-placement="top" title="Delete" onclick="deleteSubmit(this, event)">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                {!! Form::close() !!}
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                @else
                                <tr>
                                    <td colspan="6">No tourist spt add yet.</td>
                                </tr>
                            @endif
                        </tbody>

                    </table>
                </div>
                <div class="box-footer">

                </div>
            </div>
        </div>
    </div>
@endsection
