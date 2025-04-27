@extends('layouts.app')

@section('content')
<div class="container py-5">
  <h1>{{ __('messages.links.details') }}</h1>

  @if(session('status'))
    <div class="alert alert-success">{{ session('status') }}</div>
  @endif

  <div class="card mb-4">
    <div class="card-body">
      <h5 class="card-title">{{ __('messages.links.short_url') }}</h5>
      <a href="{{ route('links.redirect', $link->short_code) }}" target="_blank" class="card-link">
        {{ url($link->short_code) }}
      </a>

      <h5 class="card-title mt-3">{{ __('messages.links.original') }}</h5>
      <a href="{{ $link->original_url }}" target="_blank">{{ $link->original_url }}</a>

      @if($link->expires_at)
        <p class="mt-3"><strong>{{ __('messages.links.expires_at') }}:</strong>
          {{ $link->expires_at->format('Y-m-d H:i') }}
        </p>
      @endif

      @if($link->password)
        <p><strong>{{ __('messages.links.protected') }}</strong></p>
      @endif
    </div>
  </div>

  <h3>{{ __('messages.links.clicks_history') }}</h3>
  @if($clicks->isEmpty())
    <p class="text-muted">{{ __('messages.links.no_clicks') }}</p>
  @else
    <table class="table">
      <thead>
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
  @endif

  <a href="{{ route('dashboard') }}" class="btn btn-secondary">{{ __('messages.back') }}</a>
</div>
@endsection
