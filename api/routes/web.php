<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test-plural', function () {
    return Str::plural('category'); // should return 'categories'
});
