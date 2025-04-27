<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ShortLinkController;
use App\Http\Controllers\LinkRedirectController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Mcamara\LaravelLocalization\Middleware\LocaleSessionRedirect;
use Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRedirectFilter;

Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => [
        LocaleSessionRedirect::class,
        LaravelLocalizationRedirectFilter::class,
    ],
], function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::post('/shorten', [HomeController::class, 'shorten'])->name('home.shorten');

    Auth::routes();

    Route::middleware('auth')->group(function () {
        Route::get('/dashboard', [ShortLinkController::class, 'index'])->name('dashboard');
        Route::resource('links', ShortLinkController::class)->except('index');
    });

    Route::post('/{code}/unlock', [LinkRedirectController::class, 'unlock'])
        ->name('links.unlock');
    Route::get('/{code}', [LinkRedirectController::class, 'redirect'])
        ->name('links.redirect');
});
