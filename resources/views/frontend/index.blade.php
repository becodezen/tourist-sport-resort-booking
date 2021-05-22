@extends('layouts.frontend')

@section('content')

{{-- slider --}}
@include('partials._fr_slider')

<!-- Popular Resorts -->
@if($resorts->isNotEmpty())
<section class="resort-area pt-40 pb-50">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <!-- section title -->
                <div class="section-title text-center mb-50">
                    <h2 class="title">Most Popular Resorts in Bangladesh</h2>
                    <p class="description">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Cupiditate dolore sapiente ratione.</p>
                </div>
            </div>
        </div>
        <div class="row web-view">
            <div class="col-lg-12">
                <div class="resorts owl-carousel" id="resortCarousel">
                    @foreach ($resorts as $key => $resort)
                    <div class="resort">
                        <div class="resort-thumbnail">
                            <img src="{{ $resort->thumbnail() ? $resort->thumbnail()->image : asset('frontend/assets/img/resort-dummy.jpg') }}" alt="">
                            <div class="resort-rating">
                                <div class="rating-icons">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </div>
                                <div class="rating">
                                    <span>4.8</span>
                                </div>
                            </div>
                        </div>
                        <div class="resort-content">
                            <div class="resort-title">
                                <a href="{{ route('fr.resort.show', $resort->slug) }}">
                                    <h4>{{ $resort->name }}</h4>
                                </a>
                            </div>
                            <div class="resort-location">
                                <i class="fas fa-map-marker"></i>
                                {{ $resort->address}}
                            </div>
                            <div class="resort-short-description">
                                {{ Str::substr($resort->short_description, 0, 100).'....' }}
                            </div>
                        </div>
                        <div class="resort-price">
                            <p>AVG/Night</p>
                            <span>{{ $resort->minRoomPrice() }} - {{ $resort->maxRoomPrice() }}</span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="resorts mobile-view">
            <div class="row">
                @foreach ($resorts as $key => $resort)
                    <div class="col-md-3">
                        <div class="resort mb-30">
                            <div class="resort-thumbnail">
                                <img src="{{ $resort->thumbnail() ? $resort->thumbnail()->image : asset('frontend/assets/img/resort-dummy.jpg') }}" alt="">
                                <div class="resort-rating">
                                    <div class="rating-icons">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                    </div>
                                    <div class="rating">
                                        <span>4.8</span>
                                    </div>
                                </div>
                            </div>
                            <div class="resort-content">
                                <div class="resort-title">
                                    <a href="{{ route('fr.resort.show', $resort->slug) }}">
                                        <h4>{{ $resort->name }}</h4>
                                    </a>
                                </div>
                                <div class="resort-location">
                                    <i class="fas fa-map-marker"></i>
                                    {{ $resort->address}}
                                </div>
                                <div class="resort-short-description">
                                    {{ Str::substr($resort->short_description, 0, 100).'....' }}
                                </div>
                            </div>
                            <div class="resort-price">
                                <p>AVG/Night</p>
                                <span>{{ $resort->minRoomPrice() }} - {{ $resort->maxRoomPrice() }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
@endif

<!-- Package Section -->
<section class="package-area pt-40 pb-40 bg-light-gray parallax-section overlary"  data-parallax="scroll" data-image-src="{{ asset('frontend/assets/img/slide-2.jpg') }}">
    <div class="package-items owl-carousel">
        @foreach($packages as $assign)
            <div class="single-package">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <div class="package-content">
                            <a href="{{ route('fr.package.show', ['slug' => $assign->package->slug, 'assign_id' => $assign->id]) }}"><h4 class="mb-15">{{ $assign->package->name }}</h4></a>
                            <p>{{ $assign->package->short_description }}</p>
                            <div class="package-date mt-15 mb-15">
                                <h4>{{ user_formatted_date($assign->check_in) }} To {{ user_formatted_date($assign->check_out) }} ({{ \Carbon\Carbon::createFromDate($assign->check_in)->dayName }} To {{ \Carbon\Carbon::createFromDate($assign->check_out)->dayName }})</h4>
                            </div>
                            <div class="package-button">
                                <a href="{{ route('fr.package.show', ['slug' => $assign->package->slug, 'assign_id' => $assign->id]) }}" class="btn btn-primary">Booked Now</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="package-thumbnail">
                            <a href="{{ route('fr.package.show', ['slug' => $assign->package->slug, 'assign_id' => $assign->id]) }}">
                                @if($assign->thumbnail)
                                    <img src="{{ asset($assign->thumbnail) }}" alt="">
                                @elseif($assign->package->thumbnail)
                                    <img src="{{ asset($assign->package->thumbnail) }}" alt="">
                                @endif
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</section>

{{-- popular tourist spot --}}
@if($tourist_spots->isNotEmpty())
<section class="tourist-spot-area pt-40 pb-40">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title text-center mb-50">
                    <h2 class="title">Popular Tourist Spots</h2>
                    <p class="descrition">
                        Explore some of the best tips from around the city from our partners and friends.
                    </p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="tourist-spot-items">
                    @foreach ($tourist_spots as $tourist_spot)
                        <div class="tourist-spot-item">
                            <img src="{{ $tourist_spot->thumbnail() ? $tourist_spot->thumbnail()->image : asset('frontend/assets/img/dummy.jpg') }}" alt="">
                            <div class="resort-counters">
                                <span>{{ $tourist_spot->resorts->count() }} Resorts</span>
                            </div>
                            <div class="tourist-spot-item-content">
                                <a href="{{ route('fr.tourist.spot.show', $tourist_spot->slug) }}">
                                    <h3>{{ $tourist_spot->name }}</h3>
                                </a>
                                <p>{{ Str::substr($tourist_spot->short_description, 0, 50).'....' }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="text-center mt-20">
                    <a href="{{ route('fr.tourist.spots') }}" class="btn btn-primary">All Tourist Spots in Bangladesh <i class="fas fa-long-arrow-alt-right"></i></a>
                </div>
            </div>
        </div>
    </div>
</section>
@endif

@if($divisions->isNotEmpty())
<!-- Destination Section -->
<section class="destination-area pt-40 pb-40 bg-light-gray parallax-section" data-parallax="scroll" data-image-src="{{ asset('frontend/assets/img/slide-1.jpg') }}">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title text-center mb-50 text-light">
                    <h2 class="title">Choose Your Destination</h2>
                    <p class="descrition">
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Minus, vel?
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="no-container">
        <div class="destinations owl-carousel">
            @foreach ($divisions as $division)
            <div class="destination">
                <img src="{{ asset('frontend/assets/img/resort-dummy.jpg') }}" alt="" class="thumbs">
                <div class="destination-content">
                    <a href="#">
                        <h2>{{ $division->name }}</h2>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

@if($blogs)
<!-- Tips Section -->
<section class="blog-area pt-40 pb-40">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title text-center">
                    <h2 class="title">Tip for Trips</h2>
                    <p class="descrition">
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Minus, vel?
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>
@endif

@if($testimonials)
<!-- Testimonials Section -->
<section class="testimonial-area pt-40 pb-40 bg-light-gray">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title mb-60 text-center">
                    <h2 class="title">What Our Travelers Says</h2>
                    <p class="descrition">
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Minus, vel?
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="testimonials owl-carousel">
                    <div class="testimonial">
                        <div class="guest-img">
                            <img src="{{ asset('frontend/assets/img/testimonial-img2.jpg') }}" alt="">
                        </div>
                        <div class="guest-content">
                            <strong>Guest Name</strong>
                            <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Animi dolorum enim, ea officia doloremque, quod libero odit delectus blanditiis amet, non vitae accusamus! Enim, harum!</p>
                        </div>
                    </div>
                    <div class="testimonial">
                        <div class="guest-img">
                            <img src="{{ asset('frontend/assets/img/testimonial-img2.jpg') }}" alt="">
                        </div>
                        <div class="guest-content">
                            <strong>Guest Name</strong>
                            <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Animi dolorum enim, ea officia doloremque, quod libero odit delectus blanditiis amet, non vitae accusamus! Enim, harum!</p>
                        </div>
                    </div>
                    <div class="testimonial">
                        <div class="guest-img">
                            <img src="{{ asset('frontend/assets/img/testimonial-img2.jpg') }}" alt="">
                        </div>
                        <div class="guest-content">
                            <strong>Guest Name</strong>
                            <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Animi dolorum enim, ea officia doloremque, quod libero odit delectus blanditiis amet, non vitae accusamus! Enim, harum!</p>
                        </div>
                    </div>
                    <div class="testimonial">
                        <div class="guest-img">
                            <img src="{{ asset('frontend/assets/img/testimonial-img2.jpg') }}" alt="">
                        </div>
                        <div class="guest-content">
                            <strong>Guest Name</strong>
                            <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Animi dolorum enim, ea officia doloremque, quod libero odit delectus blanditiis amet, non vitae accusamus! Enim, harum!</p>
                        </div>
                    </div>
                    <div class="testimonial">
                        <div class="guest-img">
                            <img src="{{ asset('frontend/assets/img/testimonial-img2.jpg') }}" alt="">
                        </div>
                        <div class="guest-content">
                            <strong>Guest Name</strong>
                            <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Animi dolorum enim, ea officia doloremque, quod libero odit delectus blanditiis amet, non vitae accusamus! Enim, harum!</p>
                        </div>
                    </div>
                    <div class="testimonial">
                        <div class="guest-img">
                            <img src="{{ asset('frontend/assets/img/testimonial-img2.jpg') }}" alt="">
                        </div>
                        <div class="guest-content">
                            <strong>Guest Name</strong>
                            <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Animi dolorum enim, ea officia doloremque, quod libero odit delectus blanditiis amet, non vitae accusamus! Enim, harum!</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif

@endsection
