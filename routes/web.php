<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/{group?}', [\App\Http\Controllers\Common\IndexController::class, 'index'])->name('index')->where('group', '[0-9]+');

Route::group([
    'namespace' => 'App\Http\Controllers\Common',
    'middleware' => ['auth', 'active']
], function(){

    Route::get('/search/{group}', [\App\Http\Controllers\Common\SearchController::class, 'index'])->name('search.index');

    Route::get('/report/{group}', [ReportController::class, 'index'])->name('report.index')->where('group', '[0-9]+');

    Route::resource('/account', AccountController::class)->only('index');

});

require __DIR__.'/auth.php';
