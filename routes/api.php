<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('apikey')->group(function () {
    Route::get('/tes', function() {
        return 'ok';
    });
});
