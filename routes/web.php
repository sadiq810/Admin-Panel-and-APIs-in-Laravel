<?php

use Illuminate\Support\Facades\Route;

Route::post('customer/login', [\App\Http\Controllers\Auth\CustomerController::class, 'authenticate']);
Route::get('auth/customer', fn(\Illuminate\Http\Request $request) => auth()->guard('customers')->user())->middleware('auth:sanctum');

Route::get('/', function () {
    return redirect('/admin/'.app()->getLocale());
});
