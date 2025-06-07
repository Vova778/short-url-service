<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LinkBulkController;
use App\Http\Controllers\ShortLinkController;
use App\Http\Controllers\LinkRedirectController;
use App\Http\Controllers\StatsController;
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
    Route::get('/home', [HomeController::class, 'index']);
    Route::post('/shorten', [HomeController::class, 'shorten'])->name('home.shorten');

    Auth::routes();

    Route::middleware('auth')->group(function () {
        Route::get('/dashboard', [ShortLinkController::class, 'index'])->name('dashboard');
        Route::get('/links/bulk', [LinkBulkController::class, 'bulkForm'])->name('links.bulk.form');
        Route::post('links/bulk/process', [LinkBulkController::class, 'bulkProcess'])->name('links.bulk.process');
        Route::get('links/bulk/download/{filename}', [LinkBulkController::class, 'bulkDownload'])->name('links.bulk.download');
        Route::resource('links', ShortLinkController::class)->except('index');
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    });

    Route::post('/{code}/unlock', [LinkRedirectController::class, 'unlock'])
        ->name('links.unlock');
    Route::get('/{code}', [LinkRedirectController::class, 'redirect'])
        ->name('links.redirect');

    Route::get('/stats/countries', [StatsController::class, 'countries']);
    Route::get('/stats/browsers', [StatsController::class, 'browsers']);
    Route::get('/stats/devices', [StatsController::class, 'devices']);
    Route::get('/stats/referrers', [StatsController::class, 'referrers']);
});

Route::get('/{code}', [LinkRedirectController::class, 'redirect'])
    ->name('links.redirect');
