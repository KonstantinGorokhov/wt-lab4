<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PresidentController;

Route::get('/', function () {
    return redirect()->route('presidents.index');
});

Route::resource('presidents', PresidentController::class);
