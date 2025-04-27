@extends('layouts.app')

@section('content')
<div class="container py-5">
  <h1>{{ __('messages.links.protected') }}</h1>
  <p>{{ __('messages.links.enter_password') }}</p>

  <form method="POST" action="{{ route('links.unlock', $link->short_code) }}">
    @csrf

    <div class="mb-3">
      <label for="password" class="form-label">{{ __('messages.links.password') }}</label>
      <input
        type="password"
        name="password"
        id="password"
        class="form-control @error('password') is-invalid @enderror"
        required
      >
      @error('password')
        <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>

    <button type="submit" class="btn btn-primary">{{ __('messages.submit') }}</button>
  </form>
</div>
@endsection
