<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\EbookController;
use App\Http\Controllers\Admin\FileUploadController;


Route::get('/', function () {
    return view('welcome');
});

Route::prefix('admin')->group(function () {
    Route::resource('ebooks', EbookController::class);
});

Route::post('/file-upload', [FileUploadController::class, 'upload'])->name('file.upload');
