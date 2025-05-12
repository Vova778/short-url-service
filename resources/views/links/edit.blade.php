@extends('layouts.app')

@section('content')
<div class="container bg-white rounded-5 py-5 px-4 shadow-sm" style="max-width: 480px; width: 100%; border-radius: .75rem;">
  <h1 class="mb-4 text-primary">{{ __('messages.links.edit') }}</h1>

  @if(session('status'))
    <div class="alert alert-success">{{ session('status') }}</div>
  @endif

  <form method="POST" action="{{ route('links.update', $link) }}">
    @csrf
    @method('PUT')

    <div class="mb-4">
      <label for="original_url" class="form-label fw-semibold">{{ __('messages.links.original') }}</label>
      <input
        type="url"
        name="original_url"
        id="original_url"
        value="{{ old('original_url', $link->original_url) }}"
        class="form-control @error('original_url') is-invalid @enderror"
        required
      >
      @error('original_url')
        <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>

    <div class="mb-4">
      <label for="expires_at" class="form-label fw-semibold">{{ __('messages.links.expires_at') }}</label>
      <input
        type="datetime-local"
        name="expires_at"
        id="expires_at"
        value="{{ old('expires_at', optional($link->expires_at)->format('Y-m-d\TH:i')) }}"
        class="form-control @error('expires_at') is-invalid @enderror"
      >
      @error('expires_at')
        <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>

    <div class="mb-4">
      <label for="password" class="form-label fw-semibold">{{ __('messages.links.password') }}</label>
      <input
        type="password"
        name="password"
        id="password"
        class="form-control @error('password') is-invalid @enderror"
        placeholder="{{ __('messages.links.password_leave_blank') }}"
      >
      @error('password')
        <div class="invalid-feedback">{{ $message }}</div>
      @enderror
      {{-- <div class="form-text">{{ __('messages.links.password_optional') }}</div> --}}
    </div>

    <div class="d-flex justify-content-start gap-3">
      <button type="submit" class="btn btn-outline-primary">
        <i class="bi bi-check-circle me-1"></i> {{ __('messages.update') }}
      </button>
      <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">
        <i class="bi bi-x-circle me-1"></i> {{ __('messages.cancel') }}
      </a>
    </div>
  </form>
</div>
@endsection
