@extends('layouts.app')

@section('content')
<div class="container bg-white rounded-5 p-5">
  <h1 class="mb-4 text-primary">{{ __('messages.links.details') }}</h1>

  @if(session('status'))
    <div class="alert alert-success">{{ session('status') }}</div>
  @endif

  <div class="card shadow-sm border-0 mb-4">
    <div class="card-body">
      <h5 class="card-title text-secondary fw-bold">{{ __('messages.links.short_url') }}</h5>
      <p>
        <a href="{{ route('links.redirect', $link->short_code) }}" target="_blank" class="link-primary text-break">
          {{ url($link->short_code) }}
        </a>
      </p>

      <h5 class="card-title text-secondary fw-bold mt-4">{{ __('messages.links.original') }}</h5>
      <p>
        <a href="{{ $link->original_url }}" target="_blank" class="text-break">
          {{ $link->original_url }}
        </a>
      </p>

      @if($link->expires_at)
        <p class="mt-4">
          <i class="bi bi-calendar2-week me-1"></i>
          <strong>{{ __('messages.links.expires_at') }}:</strong>
          {{ $link->expires_at->format('Y-m-d H:i') }}
        </p>
      @endif

      @if($link->password)
        <p class="text-danger"><i class="bi bi-lock-fill me-1"></i>{{ __('messages.links.protected') }}</p>
      @endif
    </div>
  </div>

  <div class="mb-4">
    <div class="row g-3">
      <div class="col-md-6">
        <div class="border-start border-4 border-primary ps-3">
          <h6 class="text-muted mb-1"> Всього переходів</h6>
          <h4 class="fw-bold">{{ $totalClicks }}</h4>
        </div>
      </div>
      <div class="col-md-6">
        <div class="border-start border-4 border-info ps-3">
          <h6 class="text-muted mb-1">Переходів за сьогодні</h6>
          <h4 class="fw-bold">{{ $todayClicks }}</h4>
        </div>
      </div>
    </div>
  </div>

  <h3 class="mt-5">{{ __('messages.links.clicks_history') }}</h3>
  @if($clicks->isEmpty())
    <p class="text-muted">{{ __('messages.links.no_clicks') }}</p>
  @else
    <div class="table-responsive">
      <table class="table table-hover align-middle">
        <thead class="table-light">
          <tr>
            <th>{{ __('messages.clicks.at') }}</th>
            <th>{{ __('messages.clicks.ip') }}</th>
            <th>{{ __('messages.clicks.referrer') }}</th>
          </tr>
        </thead>
        <tbody>
          @foreach($clicks as $c)
          <tr>
            <td>{{ $c->clicked_at->format('Y-m-d H:i') }}</td>
            <td>{{ $c->ip_address }}</td>
            <td>{{ $c->referrer ?? '—' }}</td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  @endif

  <a href="{{ route('dashboard') }}" class="btn btn-outline-primary mt-4">
    <i class="bi bi-arrow-left"></i> {{ __('messages.back') }}
  </a>
</div>
@endsection
