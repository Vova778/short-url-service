@extends('layouts.app')

@push('styles')
    @vite('resources/sass/pages/home.scss')
@endpush

@section('content')

<section class="home-hero text-center text-white py-5" style="background: linear-gradient(135deg, #20c997 0%, #fd7e14 100%);">
  <div class="container">
    <h1 class="display-4 fw-bold">{{ __('home.hero_title') }}</h1>
    <p class="lead mb-4">{{ __('home.hero_subtitle') }}</p>

    <form id="shorten-form" class="row g-2 justify-content-center">
      <div class="col-md-8">
        <input type="url"
               class="form-control form-control-lg"
               id="originalUrl"
               placeholder="{{ __('home.url_placeholder') }}"
               required>
      </div>
      <div class="col-md-2">
        <button type="submit" class="btn btn-warning btn-lg w-100">{{ __('home.shorten_button') }}</button>
      </div>
    </form>

    <div id="shortenedResult" class="mt-5 d-none">
      <div class="card border-0 shadow-lg mx-auto" style="max-width: 600px;">
        <div class="card-body text-center">
          <h5 class="card-title mb-3">{{ __('home.result_title') }}</h5>
          <a href="#" id="shortUrl" target="_blank" class="h4 text-warning text-decoration-none"></a>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="features py-5 bg-light">
  <div class="container">
    <div class="row g-4 text-center">
      <div class="col-md-4">
        <div class="card h-100 border-0">
          <div class="card-body">
            <i class="bi bi-card-list display-4 mb-3 text-info"></i>
            <h5 class="card-title">{{ __('home.feature_bulk_title') }}</h5>
            <p class="card-text text-muted">{{ __('home.feature_bulk_desc') }}</p>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card h-100 border-0">
          <div class="card-body">
            <i class="bi bi-graph-up display-4 mb-3 text-success"></i>
            <h5 class="card-title">{{ __('home.feature_stats_title') }}</h5>
            <p class="card-text text-muted">{{ __('home.feature_stats_desc') }}</p>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card h-100 border-0">
          <div class="card-body">
            <i class="bi bi-lock display-4 mb-3 text-danger"></i>
            <h5 class="card-title">{{ __('home.feature_protected_title') }}</h5>
            <p class="card-text text-muted">{{ __('home.feature_protected_desc') }}</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="how-it-works py-5">
  <div class="container">
    <h2 class="text-center mb-4">{{ __('home.how_title') }}</h2>
    <div class="row text-center">
      <div class="col-md-4 mb-4">
        <i class="bi bi-clipboard-check display-4 mb-3 text-primary"></i>
        <h5>{{ __('home.how_step1_title') }}</h5>
        <p class="text-muted">{{ __('home.how_step1_desc') }}</p>
      </div>
      <div class="col-md-4 mb-4">
        <i class="bi bi-gear display-4 mb-3 text-secondary"></i>
        <h5>{{ __('home.how_step2_title') }}</h5>
        <p class="text-muted">{{ __('home.how_step2_desc') }}</p>
      </div>
      <div class="col-md-4 mb-4">
        <i class="bi bi-rocket display-4 mb-3 text-warning"></i>
        <h5>{{ __('home.how_step3_title') }}</h5>
        <p class="text-muted">{{ __('home.how_step3_desc') }}</p>
      </div>
    </div>
  </div>
</section>

<section class="testimonials bg-light py-5">
  <div class="container">
    <h2 class="text-center mb-4">{{ __('home.testimonials_title') }}</h2>
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div id="testimonialCarousel" class="carousel slide" data-bs-ride="carousel">
          <div class="carousel-inner">
            <div class="carousel-item active">
              <blockquote class="blockquote text-center">
                <p class="mb-4">“{{ __('home.testimonial1_text') }}”</p>
                <footer class="blockquote-footer">{{ __('home.testimonial1_author') }}</footer>
              </blockquote>
            </div>
            <div class="carousel-item">
              <blockquote class="blockquote text-center">
                <p class="mb-4">“{{ __('home.testimonial2_text') }}”</p>
                <footer class="blockquote-footer">{{ __('home.testimonial2_author') }}</footer>
              </blockquote>
            </div>
          </div>
          <button class="carousel-control-prev" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
          </button>
          <button class="carousel-control-next" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon text-dark"></span>
          </button>
        </div>
      </div>
    </div>
  </div>
</section>

@endsection

@push('scripts')
    @vite('resources/js/pages/home.js')
@endpush
