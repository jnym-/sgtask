<?php

use App\Http\Controllers\HomeOwnerImportsController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::as('home-owners.imports')->post('home-owners/import', [HomeOwnerImportsController::class, 'store']);
