@extends('layouts.app')

@section('content')
<h1>{{ __('messages.links.details') }}: {{ $link->short_code }}</h1>
<ul class="list-group mb-3">
  <li class="list-group-item">{{ __('messages.links.original') }}: {{ $link->original_url }}</li>
  <li class="list-group-item">{{ __('messages.links.expires_at') }}: {{ $link->expires_at?->toDateTimeString() ?? __('messages.never') }}</li>
  <li class="list-group-item">{{ __('messages.links.clicks') }}: {{ $link->clicks->count() }}</li>
</ul>
<h2>{{ __('messages.statistics') }}</h2>
<table class="table">
  <thead>
    <tr>
      <th>{{ __('messages.clicks.at') }}</th>
      <th>{{ __('messages.clicks.referrer') }}</th>
      <th>{{ __('messages.clicks.ip') }}</th>
    </tr>
  </thead>
  <tbody>
    @foreach($clicks as $click)
    <tr>
      <td>{{ $click->clicked_at }}</td>
      <td>{{ $click->referrer }}</td>
      <td>{{ $click->ip_address }}</td>
    </tr>
    @endforeach
  </tbody>
</table>
@endsection
