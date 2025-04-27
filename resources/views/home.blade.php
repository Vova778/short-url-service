@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
  <div class="col-md-8">
    <h1>{{ __('messages.home.title') }}</h1>
    <form id="home-form">
      @csrf
      <div class="mb-3">
        <input type="url" name="original_url"
               class="form-control"
               placeholder="{{ __('messages.home.input_placeholder') }}"
               required>
      </div>
      <button class="btn btn-primary">{{ __('messages.home.button') }}</button>
    </form>
    <div id="home-result" class="mt-3"></div>
  </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="@mix('resources/sass/pages/home.scss')">
@endpush

@push('scripts')
<script src="@mix('resources/js/pages/home.js')"></script>
@endpush
