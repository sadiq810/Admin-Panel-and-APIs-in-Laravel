<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\Api\{LanguageController, CategoriesController, FaqController, BlogController, PageController,
                    FeatureController, OrderController};

Route::get('languages',     [LanguageController::class,     'index']);
Route::get('categories',    [CategoriesController::class,   'index']);
Route::get('faqs',          [FaqController::class,          'index']);
Route::get('blogs',         [BlogController::class,         'index']);
Route::get('blog/{slug}',   [BlogController::class,         'single']);
Route::get('pages',         [PageController::class,         'index']);
Route::get('pages-list',    [PageController::class,         'list']);
Route::get('page/{slug}',   [PageController::class,         'bySlug']);
Route::get('detail-features-list', [FeatureController::class,'detailList']);

Route::get('orders',        [OrderController::class,        'list']);
Route::get('order/{id}',    [OrderController::class,        'getById']);
Route::post('order',        [OrderController::class,        'save']);

Route::middleware('auth:sanctum')->get('auth/customer', fn(\Illuminate\Http\Request $request) => auth()->guard('customers')->user());
