@extends('layouts.master')

@section('content')
    <div class="box">
        <div class="box-header with-border">
            <div class="box-header-content">
                <h5 class="box-title">View Details</h5>
            </div>
            <div class="action">
                <a href="{{ route('tourist.spot.gallery', $spot->id) }}" class="btn btn-outline-info">Galleries</a>
                <a href="{{ route('tourist.spot.edit', $spot->id) }}" class="btn btn-success">Edit</a>
                <a href="{{ route('tourist.spot.list') }}" class="btn btn-primary">View list</a>
            </div>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-lg-7">
                    <div class="title mb-10">
                        <h5>Details of {{ $spot->name }}</h5>
                        <p class="mt-10">
                            <span><strong>Division: </strong> {{ $spot->division->name }}</span>
                            <span><strong>District: </strong> {{ $spot->district->name }}</span>
                            <span><strong>Upazila: </strong> {{ $spot->upazila ? $spot->upazila->name : 'Not Define' }}</span>
                        </p>
                    </div>
                    <div class="description mb-10">
                        {!! $spot->description !!}
                    </div>

                    <div class="route-plan mb-10">
                        <strong>Route Plan: </strong>
                        {{ $spot->route_plan }}
                    </div>

                    <div class="mb-10">
                        <h5>Travel Cost</h5>
                        <div>
                            {!! $spot->travel_cost !!}
                        </div>
                    </div>

                    <div class="mb-10">
                        <h5>Warnings</h5>
                        <div>
                            {!! $spot->warning !!}
                        </div>
                    </div>
                </div>
                <div class="col-lg-5">
                    @if($spot->galleries->first())
                        <img src="{{ asset($spot->galleries->first()->image) }}" alt="">
                    @endif
                    <h4 class="mt-10 mb-10">{{ $spot->name }}</h4>
                    <p>{{ $spot->short_description }}</p>
                    <p class="mt-10"><strong>Tags: </strong>{{ $spot->tags ? implode(', ', json_decode($spot->tags)) : '' }}</p>
                    <div class="google-map mt-15">
                        <h5 class="mb-10">View on Google Map</h5>
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d5280.883161998116!2d92.32124976488886!3d20.622811393776544!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x30ae2363dee2d61b%3A0xfb3463713589d312!2sSt.%20Martin&#39;s%20Island!5e0!3m2!1sen!2sbd!4v1609901934382!5m2!1sen!2sbd" width="100%" height="250" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="box">
        <div class="box-header with-border">
            <div class="box-header-content">
                <h4 class="box-title">Instruction</h4>
            </div>
            <div class="action">
                <a href="{{ route('instruction.create', $spot->id) }}" class="btn btn-danger">Add More Route Instruction</a>
            </div>
        </div>
        <div class="box-body">
            {!! $spot->instruction !!}
            @if($spot->instructions->isNotEmpty())
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

            @else
                <p class="mt-10"><strong>No More Route Instruction found yet.</strong></p>
            @endif
        </div>
        <div class="box-footer"></div>
    </div>

    <div class="box">
        <div class="box-header with-border">
            <div class="box-header-content">
                <h4 class="box-title">Article on {{ $spot->name }}</h4>
            </div>
            <div class="action">
                <a href="{{ route('tourist.spot.article.create', $spot->id) }}" class="btn btn-dark">Add new article</a>
            </div>
        </div>
        <div class="box-body">
            @if($spot->articles->isNotEmpty())
            <table class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Titile</th>
                    <th>Short Description</th>
                    <th>Thumbnail</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($spot->articles as $key => $article)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ $article->title }}</td>
                            <td>{{ substr(strip_tags($article->description), 0, 100) }}.......</td>
                            <td>
                                <img src="{{ asset($article->thumbnail) }}" style="max-width: 100px" alt="">
                            </td>
                            <td>
                                <div class="action-group">
                                    <a href="{{ route('tourist.spot.article.show', ['tourist_spot_id' => $spot->id, 'id' => $article->id]) }}" class="btn btn-sm btn-success" data-toggle="tooltip" data-placement="top" title="View Details">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('tourist.spot.article.edit', ['tourist_spot_id' => $spot->id, 'id' => $article->id]) }}" class="btn btn-sm btn-primary" data-toggle="tooltip" data-placement="top" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    {!! Form::open(['route' => ['tourist.spot.article.delete', ['tourist_spot_id' => $spot->id, 'id' => $article->id]], 'method' => 'DELETE']) !!}
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
            @else
                 <p>No articles found yet. <a href="{{ route('tourist.spot.article.create', $spot->id) }}">Add New</a></p>
            @endif

        </div>
        <div class="box-footer">

        </div>
    </div>

@endsection
