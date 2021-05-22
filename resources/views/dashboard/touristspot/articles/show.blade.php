@extends('layouts.master')

@section('content')

    <div class="box">
        <div class="box-header with-border">
            <div class="box-header-content">
                <h4 class="box-title">Article Details</h4>
            </div>
            <div class="action">
                <a href="{{ route('tourist.spot.article.edit', ['tourist_spot_id' => $article->tourist_spot_id, 'id' => $article->id]) }}" class="btn btn-primary">Update Article</a>
                <a href="{{ route('tourist.spot.article.list', $article->tourist_spot_id) }}" class="btn btn-dark">Back to Article List</a>
            </div>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-lg-8">
                    <h5>{{ $article->title }}</h5>
                    <div class="mt-15">
                        {!! $article->description !!}
                    </div>
                </div>
                <div class="col-lg-4">
                    <h5>Article Thumbnail</h5>
                    <img src="{{ asset($article->thumbnail) }}" alt="">
                </div>
            </div>
        </div>
        <div class="box-footer">

        </div>
    </div>

@endsection
