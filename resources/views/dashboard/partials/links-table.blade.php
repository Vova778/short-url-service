{{-- resources/views/dashboard/partials/links-table.blade.php --}}
<table id="linksTable" class="table table-striped table-hover nowrap w-100">
    <thead class="table-light">
      <tr>
        <th>{{ __('Short Code') }}</th>
        <th>{{ __('Original URL') }}</th>
        <th>{{ __('Clicks') }}</th>
        <th>{{ __('Expires At') }}</th>
        <th class="text-center">{{ __('Actions') }}</th>
      </tr>
    </thead>
    <tbody>
      @foreach($links as $link)
      <tr>
        <td>
          <a href="{{ route('links.show', $link) }}" class="link-primary">
            {{ $link->short_code }}
          </a>
        </td>
        <td class="text-truncate" style="max-width:220px;">
          <a href="{{ $link->original_url }}" target="_blank">{{ $link->original_url }}</a>
        </td>
        <td>{{ $link->clicks_count }}</td>
        <td>
          @if($link->expires_at)
            {{ $link->expires_at->format('Y-m-d') }}
          @else
            <span class="text-muted">{{ __('Never') }}</span>
          @endif
        </td>
        <td class="text-center">
          <a href="{{ route('links.show', $link) }}"   class="btn btn-sm btn-info me-1"><i class="fas fa-eye"></i></a>
          <a href="{{ route('links.edit', $link) }}"   class="btn btn-sm btn-warning me-1"><i class="fas fa-edit"></i></a>
          <button class="btn btn-sm btn-danger delete-btn"><i class="fas fa-trash"></i></button>
          <form action="{{ route('links.destroy', $link) }}" method="POST" class="d-none delete-form">
            @csrf @method('DELETE')
          </form>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
