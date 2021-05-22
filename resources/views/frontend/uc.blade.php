@extends('layouts.frontend')

@section('content')

{{-- slider --}}
@include('partials._fr_page_title')

    <div class="under-construction pb-50 pt-50">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <img src="{{ asset('frontend/assets/img/uc.jpg') }}" alt="">
                </div>
            </div>
        </div>
    </div>

@endsection
