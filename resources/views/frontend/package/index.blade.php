@extends('layouts.frontend')

@section('content')

    {{-- slider --}}
    @include('partials._fr_page_title')

    <div class="package-area package-list pb-50 pt-50">
        <div class="container">
            <div class="row">
                @foreach ($assigns as $assign)
                    <div class="col-md-6">
                        <div class="package-item">
                            <a href="{{ route('fr.package.show', ['slug' => $assign->package->slug, 'assign_id' => $assign->id]) }}">
                                <div class="package-thumbnail">
                                    @if($assign->thumbnail)
                                        <img src="{{ asset($assign->thumbnail) }}" alt="">
                                    @else
                                        <img src="{{ asset($assign->package->thumbnail) }}" alt="">
                                    @endif
                                </div>
                                <div class="package-content">
                                    <h4>{{ $assign->package->name }} ({{ user_formatted_date($assign->check_in) .' to '. user_formatted_date($assign->check_out)}})</h4>
                                    <p><strong>Price (Start From): </strong> {{ $assign->package->packagePrices->first()->price }}</p>
                                </div>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="row">
                <div class="col-md-12 text-center">
                    {{ $assigns->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
