@extends('layouts.app')

@section('content')
<div class="container py-5">
  <h1>{{ __('messages.links.create') }}</h1>

  @if(session('status'))
    <div class="alert alert-success">{{ session('status') }}</div>
  @endif

  <form method="POST" action="{{ route('links.store') }}">
    @csrf

    <div class="mb-3">
      <label for="original_url" class="form-label">{{ __('messages.links.original') }}</label>
      <input
        type="url"
        name="original_url"
        id="original_url"
        value="{{ old('original_url') }}"
        class="form-control @error('original_url') is-invalid @enderror"
        required
      >
      @error('original_url')
        <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>

    <div class="mb-3">
      <label for="expires_at" class="form-label">{{ __('messages.links.expires_at') }}</label>
      <input
        type="datetime-local"
        name="expires_at"
        id="expires_at"
        value="{{ old('expires_at') }}"
        class="form-control @error('expires_at') is-invalid @enderror"
      >
      @error('expires_at')
        <div class="invalid-feedback">{{ $message }}</div>
      @enderror
      <div class="form-text">{{ __('messages.links.expires_help') }}</div>
    </div>

    <div class="mb-3">
      <label for="password" class="form-label">{{ __('messages.links.password') }}</label>
      <input
        type="password"
        name="password"
        id="password"
        class="form-control @error('password') is-invalid @enderror"
      >
      @error('password')
        <div class="invalid-feedback">{{ $message }}</div>
      @enderror
      <div class="form-text">{{ __('messages.links.password_help') }}</div>
    </div>

    <button type="submit" class="btn btn-primary">{{ __('messages.create') }}</button>
    <a href="{{ route('dashboard') }}" class="btn btn-secondary">{{ __('messages.cancel') }}</a>
  </form>
</div>
@endsection
