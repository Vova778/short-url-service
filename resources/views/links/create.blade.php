@extends('layouts.app')

@push('styles')
    @vite('resources/sass/pages/home.scss')
@endpush

@section('content')
    <div class="create-page d-flex justify-content-center align-items-center">
        <div class="card shadow-sm bg-white p-4" style="max-width: 480px; width: 100%; border-radius: .75rem;">
            <div class="card-body">
                <h2 class="card-title mb-4 text-center">New Link</h2>
                <form id="newLinkForm" action="{{ route('home.shorten') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="original_url" class="form-label small">Original URL</label>
                        <input type="url" class="form-control form-control-sm" id="original_url" name="original_url"
                            required>
                        <div class="invalid-feedback small" id="error-original_url"></div>
                    </div>

                    <div class="mb-3">
                        <label for="custom_code" class="form-label small">Custom code <span
                                class="text-muted">(optional)</span></label>
                        <input type="text" class="form-control form-control-sm" id="custom_code" name="custom_code">
                        <div class="invalid-feedback small" id="error-custom_code"></div>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label small">Password <span
                                class="text-muted">(optional)</span></label>
                        <input type="password" class="form-control form-control-sm" id="password" name="password">
                        <div class="invalid-feedback small" id="error-password"></div>
                    </div>

                    <div class="mb-4">
                        <label for="expires_at" class="form-label small">Expires At <span
                                class="text-muted">(optional)</span></label>
                        <input type="datetime-local" class="form-control form-control-sm" id="expires_at" name="expires_at">
                        <div class="invalid-feedback small" id="error-expires_at"></div>
                    </div>

                    <button type="submit" class="btn btn-primary btn-sm w-100">Create</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    @vite('resources/js/shorten.js')
@endpush
