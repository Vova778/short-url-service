{{-- resources/views/dashboard/index.blade.php --}}
@extends('layouts.app')

@push('styles')
    @vite('resources/sass/pages/dashboard.scss')
@endpush

@section('content')
    <div class="bg-white rounded-5 container py-4">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="mb-0">{{ __('Dashboard') }}</h1>
            <a href="{{ route('links.create') }}" class="btn btn-outline-primary">
                <i class="fas fa-plus"></i> {{ __('New Short Link') }}
            </a>
        </div>

        <div class="row mb-5 stats-overview">
            @foreach ([['color' => 'primary', 'icon' => 'link', 'title' => __('Total Links'), 'value' => $totalLinks], ['color' => 'success', 'icon' => 'mouse-pointer', 'title' => __('All Clicks'), 'value' => $totalClicks], ['color' => 'warning', 'icon' => 'calendar-day', 'title' => __('Clicks Today'), 'value' => $todayClicks]] as $stat)
                <div class="col-md-4 mb-3">
                    <div class="card text-white bg-{{ $stat['color'] }} h-100 stat-card">
                        <div class="card-body d-flex align-items-center">
                            <i class="fas fa-{{ $stat['icon'] }} fa-3x me-3"></i>
                            <div>
                                <h5 class="card-title mb-1">{{ $stat['title'] }}</h5>
                                <p class="card-text fs-2">{{ $stat['value'] }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="row mb-3">
            <div class="col-auto">
                <input type="text" id="dateRange" class="form-control form-control-sm"
                    placeholder="{{ __('Last 7 days') }}">
            </div>
            <div class="col">
                <button id="applyFilter" class="btn btn-sm btn-secondary">{{ __('Apply') }}</button>
            </div>
        </div>

        <div class="row">
            <div class="col">
                @include('dashboard.partials.links-table')
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    @vite('resources/js/pages/dashboard.js')
@endpush
