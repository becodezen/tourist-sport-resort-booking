@extends('layouts.frontend')

@section('content')
    {{-- page-title --}}
    @include('partials._fr_page_title')

    <section class="filtering-area pt-20 pb-20">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    {!! Form::open(['method' => 'GET', 'class' => 'hz-form-filter']) !!}
                        <div class="filter-icon">
                            <i class="fas fa-filter"></i>
                            <strong>Filter by</strong>
                        </div>
                        <div class="form-group">
                            <div class="form-input-group">
                                <i class="fas fa-map-marker-alt"></i>
                                <input type="text" name="" placeholder="Tourist spot" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-input-group">
                                <i class="fas fa-city"></i>
                                {!! Form::select('division', formSelectOptions($divisions), null, ['placeholder' => 'Select from division', 'class' => 'form-control', 'id' => 'division']) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-input-group">
                                <i class="fas fa-city"></i>
                                {!! Form::select('district', formSelectOptions($districts), null, ['placeholder' => 'Select from district', 'class' => 'form-control', 'id' => 'district']) !!}
                            </div>
                        </div>
                        <div class="form-input-search">
                            <button class="btn btn-primary radius-50" type="submit">Search</button>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </section>

    <section class="tourist-spot-area pt-50 pb-50">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="tourist-spot-items">
                        @foreach ($spots as $spot)
                            <div class="tourist-spot-item">
                                <img src="{{ $spot->thumbnail() ? $spot->thumbnail()->image : asset('frontend/assets/img/dummy.jpg') }}" alt="">
                                <div class="resort-counters">
                                    <span>{{ $spot->resorts->count() }} Resorts</span>
                                </div>
                                <div class="tourist-spot-item-content">
                                    <a href="{{ route('fr.tourist.spot.show', $spot->slug) }}">
                                        <h3>{{ $spot->name }}</h3>
                                    </a>
                                    <p>{{ Str::substr($spot->short_description, 0, 50).'....' }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="mt-50">
                        <div class="pagination-center">
                            {{ $spots->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
