@extends('layouts.frontend')

@section('content')
    {{-- page-title --}}
    @include('partials._fr_page_title')

    <div class="dashboard-area" id="dashboardArea">
        <div class="container">
            <div class="dashboard">
                @include('partials._fr_customer_dashboard_navigation')
                <div class="dashboard-content-area">
                    <div class="dashboard-page-title">
                        <h2>@yield('page_title', $page_title)</h2>
                    </div>
                    <div class="dashboard-content">
                        <div class="container-fluid">
                            @yield('dashboard.content')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
