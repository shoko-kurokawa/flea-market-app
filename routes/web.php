<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/mypage/profile', function () {
    return view('profile.edit');
})->middleware('auth')->name('profile.edit');