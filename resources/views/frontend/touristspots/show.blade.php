@extends('layouts.frontend')

@section('content')
    {{-- page-title --}}
    @include('partials._fr_page_title')

    <section class="tourist-spot-area pt-50 pb-50">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="spot-sliders owl-carousel">
                        @if($spot->galleries)
                            @foreach($spot->galleries as $gallery)
                                <div class="spot-slider">
                                    <img src="{{ asset($gallery->image) }}" alt="">
                                    <div class="spot-slider-caption">
                                        <p>{{ $gallery->caption }}</p>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                    <div class="spot-title mt-15">
                        <h2>{{ $spot->name }}</h2>
                        <p>
                            <i class="fas fa-map-marker-alt"></i>
                            <span>{{ $spot->district->name }}</span>
                        </p>
                    </div>

                    <div class="spot-description mt-15">
                        {!! $spot->description !!}
                        <p><strong>Route Plan:</strong>: {{ $spot->route_plan }}</p>
                    </div>

                    @if($spot->instruction)
                        <div class="spot-instruction mt-15">
                            <h3 class="spot-section-title">Instruction</h3>
                            {!! $spot->instruction !!}
                            @if($spot->instructions)
                                <div class="instructions">
                                    @foreach($spot->instructions as $ins)
                                        <div class="spot-route-instruction">
                                            <h4>{{ $ins->title }}</h4>
                                            {!! $ins->description !!}
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @endif

                    @if($spot->travel_cost)
                        <div class="spot-instruction mt-15">
                            <h3 class="spot-section-title">Travel Cost</h3>
                            {!! $spot->travel_cost !!}
                        </div>
                    @endif

                    @if($spot->warning)
                        <div class="spot-warning mt-15">
                            <h3 class="spot-section-title">Warning</h3>
                            {!! $spot->warning !!}
                        </div>
                    @endif
                </div>
                <div class="col-md-4">
                    @if($spot->articles->isNotEmpty())
                        <div class="sidebar-item">
                            <div class="sidebar-title">
                                <h3 class="title">Articles</h3>
                            </div>
                            <div class="sidebar-content">
                                @foreach($spot->articles as $article)
                                    <div class="article">
                                        <a href="{{ route('fr.tourist.spot.article.show', $article->id) }}">
                                            {{ $article->title }}
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                    @endif

                    @if($tourist_spots->isNotEmpty())
                        <div class="sidebar-title">
                            <h3 class="title">You may know</h3>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    @if($spot->resorts->isNotEmpty())
    <section class="resorts">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <!-- section title -->
                    <div class="section-title">
                        <h2 class="title">Resorts In {{  $spot->name }}</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="resorts">
                        <ul class="resort-list-grid">
                        @foreach ($spot->resorts as $resort)
                            <li>
                                <a href="{{ route('fr.resort.show', $resort->slug) }}"><h4>{{ $resort->name }}</h4></a>
                                <p><i class="fas fa-map-marker-alt"></i> {{ $resort->address }}</p>
                                <p><i class="fas fa-phone-alt"></i> {{ $resort->phone }}</p>
                            </li>
                        @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif
@endsection

@push('footer-scripts')
    <script>
        (function($){
            "use-strict"

            jQuery(document).ready(function(){
               if ($('.spot-sliders').length > 0) {
                   $('.spot-sliders').owlCarousel({
                       items: 1,
                       margin: 0,
                       autoplay: true,
                       autoplayTimeout:5000,
                       loop: true,
                       smartSpeed: 1000
                   })
               }
            });
        }(jQuery))
    </script>
@endpush
