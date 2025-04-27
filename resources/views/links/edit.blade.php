@extends('layouts.app')

@section('content')
<h1>{{ __('messages.links.edit') }}: {{ $link->short_code }}</h1>
<form method="POST" action="{{ route('links.update',$link) }}">
  @csrf @method('PUT')
  <div class="mb-3">
    <label>{{ __('messages.links.original') }}</label>
    <input type="url" name="original_url" value="{{ $link->original_url }}" class="form-control" required>
  </div>
  <div class="mb-3">
    <label>{{ __('messages.links.expires_at') }}</label>
    <input type="datetime-local" name="expires_at"
           value="{{ optional($link->expires_at)->format('Y-m-d\TH:i') }}"
           class="form-control">
  </div>
  <div class="mb-3">
    <label>{{ __('messages.links.password') }}</label>
    <input type="password" name="password" class="form-control" placeholder="{{ __('messages.leave_blank') }}">
  </div>
  <button class="btn btn-primary">{{ __('messages.update') }}</button>
</form>
@endsection
