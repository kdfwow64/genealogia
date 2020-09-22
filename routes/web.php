<?php

use Illuminate\Support\Facades\Route;

Route::get('/storage/app/dna/output/{file}', function ($file) {
    return response()->file(storage_path('app'.DIRECTORY_SEPARATOR.'dna'.DIRECTORY_SEPARATOR.'output'.DIRECTORY_SEPARATOR.$file)); 
});

Route::view('/{any}', 'index')->where('any', '.*');
