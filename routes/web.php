<?php

use App\Http\Controllers\BranchController;
use App\Http\Controllers\BusinessController;
use Illuminate\Support\Facades\Route;

Route::get('/', function ()
{
    return view('welcome');
});

Route::resource('businesses', BusinessController::class)->except([ 'edit', 'update' ]);
Route::resource('branches', BranchController::class)->except([ 'edit', 'update' ]);