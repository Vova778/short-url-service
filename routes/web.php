<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LinkController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Mcamara\LaravelLocalization\Middleware\LocaleSessionRedirect;
use Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRedirectFilter;

/*
|--------------------------------------------------------------------------
| Localized Web Routes
|--------------------------------------------------------------------------
*/
Route::group([
    'prefix'     => LaravelLocalization::setLocale(),
    'middleware' => [
        LocaleSessionRedirect::class,
        LaravelLocalizationRedirectFilter::class,
    ],
], function(){
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::post('/shorten', [HomeController::class, 'shorten'])->name('home.shorten');

    Auth::routes();

    Route::middleware('auth')->group(function(){
        Route::get('/dashboard', [LinkController::class,'index'])->name('dashboard');
        Route::resource('links', LinkController::class)->except(['index']);
    });

    Route::post('/{code}/unlock', [LinkController::class,'unlock'])->name('links.unlock');
    Route::get('/{code}',       [LinkController::class,'redirect'])->name('links.redirect');
});
