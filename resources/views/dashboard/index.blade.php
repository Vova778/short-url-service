@extends('layouts.app')

@section('content')
<h1>{{ __('messages.dashboard.title') }}</h1>
<div class="mb-3">
  <a href="{{ route('links.create') }}" class="btn btn-success">
    {{ __('messages.links.create') }}
  </a>
</div>
<table class="table">
  <thead>
    <tr>
      <th>{{ __('messages.links.code') }}</th>
      <th>{{ __('messages.links.original') }}</th>
      <th>{{ __('messages.links.clicks') }}</th>
      <th>{{ __('messages.actions') }}</th>
    </tr>
  </thead>
  <tbody>
    @foreach($links as $link)
    <tr>
      <td><a href="{{ route('links.redirect', $link->short_code) }}" target="_blank">{{ $link->short_code }}</a></td>
      <td>{{ Str::limit($link->original_url,50) }}</td>
      <td>{{ $link->clicks()->count() }}</td>
      <td>
        <a href="{{ route('links.show',$link) }}" class="btn btn-sm btn-info">{{ __('messages.view') }}</a>
        <a href="{{ route('links.edit',$link) }}" class="btn btn-sm btn-warning">{{ __('messages.edit') }}</a>
        <form action="{{ route('links.destroy',$link) }}" method="POST" class="d-inline">
          @csrf @method('DELETE')
          <button class="btn btn-sm btn-danger">{{ __('messages.delete') }}</button>
        </form>
      </td>
    </tr>
    @endforeach
  </tbody>
</table>
{{ $links->links() }}
@endsection
