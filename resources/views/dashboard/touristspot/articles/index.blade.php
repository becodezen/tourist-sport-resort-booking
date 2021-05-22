@extends('layouts.master')

@section('content')

    <div class="box">
        <div class="box-header with-border">
            <div class="box-header-content">
                <h4 class="box-title">Article of {{ $spot->name }} </h4>
            </div>
            <div class="action">
                <a href="{{ route('tourist.spot.article.create', $spot->id) }}" class="btn btn-primary">New Article</a>
            </div>
        </div>
        <div class="box-body">
            <table class="table table-hover table-bordered">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Image</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @if($spot->articles)
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
                @endif
                </tbody>
            </table>
        </div>
        <div class="box-footer">

        </div>
    </div>

@endsection
