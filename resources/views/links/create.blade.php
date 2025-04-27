@extends('layouts.app')

@section('content')
<h1>{{ __('messages.links.create_with_options') }}</h1>
<form method="POST" action="{{ route('links.store') }}">
  @csrf
  <div class="mb-3">
    <label>{{ __('messages.links.original') }}</label>
    <input type="url" name="original_url" class="form-control" required>
  </div>
  <div class="mb-3">
    <label>{{ __('messages.links.expires_at') }}</label>
    <input type="datetime-local" name="expires_at" class="form-control">
  </div>
  <div class="mb-3">
    <label>{{ __('messages.links.password') }}</label>
    <input type="password" name="password" class="form-control">
  </div>
  <button class="btn btn-primary">{{ __('messages.save') }}</button>
</form>
@endsection
