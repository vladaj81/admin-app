<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DataImportController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' => ['auth']], function() {
    Route::resource('permissions', PermissionController::class);
    Route::resource('users', UserController::class);
    Route::get('/data-import', [DataImportController::class, 'index'])->name('data-import');
    Route::post('/data-import', [DataImportController::class, 'importFiles'])->name('import-files');
    Route::get('/get-required-headers', [DataImportController::class, 'getImportTypeRequiredHeaders'])->name('get-required-headers');
});
