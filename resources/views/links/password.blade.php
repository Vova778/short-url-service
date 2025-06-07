{{-- resources/views/links/password.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-center align-items-center min-vh-100 bg-light">
  <div class="card shadow-lg rounded-4 w-100" style="max-width:480px;">
    {{-- Заголовок --}}
    <div class="bg-primary text-white text-center py-4 rounded-top-4">
      <h2 class="mb-0">{{ __('messages.links.protected') }}</h2>
    </div>
    {{-- Тіло картки --}}
    <div class="card-body p-5">
      <p class="text-center mb-5 fs-5">{{ __('messages.links.enter_password') }}</p>

      <form method="POST" action="{{ route('links.unlock', $link->short_code) }}">
        @csrf

        <div class="mb-4">
          <label for="password" class="form-label fs-6">{{ __('messages.links.password-needed') }}</label>
          <input
            type="password"
            id="password"
            name="password"
            class="form-control form-control-lg @error('password') is-invalid @enderror"
            placeholder="{{ __('messages.links.password_placeholder') }}"
            required
            autofocus
          >
          @error('password')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <button type="submit" class="btn btn-primary btn-lg w-100">
          {{ __('messages.buttons.submit') }}
        </button>
      </form>
    </div>
  </div>
</div>
@endsection
