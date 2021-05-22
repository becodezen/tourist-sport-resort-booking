@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="box">
                <div class="box-header with-border">
                    <div class="box-header-content">
                        <h4 class="box-title">Resort List</h4>
                    </div>
                    <div class="action">
                        <a href="{{ route('resort.create') }}" class="btn btn-primary">Add new</a>
                    </div>
                </div>
                <div class="box-body">
                    <div class="resort-pagination d-flex justify-content-end mb-10">
                        {{ $resorts->links() }}
                    </div>
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th style="width: 110px">Thumbnail</th>
                            <th>Name</th>
                            <th>Contact</th>
                            <th>Price</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        @if($resorts->isNotEmpty())
                            <tbody>
                                @foreach($resorts as $key => $resort)
                                    <tr>
                                        <td>{{ $key+1 }}</td>
                                        <td>
                                            @if($resort->thumbnail())
                                                <img src="{{ asset($resort->thumbnail()->image) }}" alt="">
                                                @else
                                                <img src="{{ asset('assets/images/thumbnail.png') }}" alt="">
                                            @endif
                                        </td>
                                        <td>{{ $resort->name }}</td>
                                        <td>
                                            <p><i class="fas fa-map-marker"></i> {{ $resort->address }}</p>
                                            <p><i class="fas fa-phone"></i> {{ $resort->phone }}</p>
                                            <p><i class="fas fa-envelope"></i> {{ $resort->email }}</p>
                                        </td>
                                        <td>
                                            <strong>৳</strong>. 1500 - 7500
                                        </td>
                                        <td>
                                            <div class="action-group">
                                                <a href="{{ route('resort.photo.gallery', $resort->id) }}" class="btn btn-sm btn-dark" data-toggle="tooltip" data-placement="top" title="Add Gallery">
                                                    <i class="fas fa-images"></i>
                                                </a>
                                                <a href="{{ route('resort.show', $resort->id) }}" class="btn btn-sm btn-success" data-toggle="tooltip" data-placement="top" title="View Details">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('resort.edit', $resort->id) }}" class="btn btn-sm btn-primary" data-toggle="tooltip" data-placement="top" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                {!! Form::open(['route' => ['resort.delete', $resort->id], 'method' => 'DELETE']) !!}
                                                <button class="btn btn-sm btn-danger" data-toggle="tooltip" data-placement="top" title="Delete" onclick="deleteSubmit(this, event)">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                                {!! Form::close() !!}
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        @endif
                    </table>
                </div>
                <div class="box-footer">
                    <div class="resort-pagination d-flex justify-content-end">
                        {{ $resorts->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
