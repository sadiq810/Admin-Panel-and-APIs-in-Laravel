<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\{LanguageController, DashboardController, CategoryController, PagesController,
    FaqController, UserController, BlogController, RoleController, FeatureController, OptionController,
    ItemController, OrderController
};


Route::get('/admin', function () {
    return redirect(app()->getLocale().'/admin');
});

Route::group(['prefix' => '{locale}', 'where' => ['locale' => '[a-zA-Z]{2}'], 'middleware' => ['setlocale']], function () {
    Route::group(['prefix' => 'admin'], function () {
        Auth::routes();

        Route::group(['middleware' => 'auth',], function () {
            Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

            Route::get('language', [LanguageController::class, 'index'])->name('language.index')->middleware('can:languages');
            Route::post('language', [LanguageController::class, 'store'])->name('language.store')->middleware('can:languages');
            Route::delete('language/{id}', [LanguageController::class, 'destroy'])->name('language.destroy')->middleware('can:languages');
            Route::get('languages-list-datatables', [LanguageController::class, 'list'])->name('languages.datatables.list')->middleware('can:languages');
            Route::get('change-language/{lang}', [LanguageController::class, 'changeLanguage'])->name('change.lang');
            Route::post('add-update-lang', [LanguageController::class, 'updateField'])->name('add.update.lang')->middleware('can:languages');

            Route::get('category', [CategoryController::class, 'index'])->name('category.index')->middleware('can:categories');
            Route::get('categories-list', [CategoryController::class, 'listCategories'])->name('categories.list')->middleware('can:categories');
            Route::post('category-save', [CategoryController::class, 'save'])->name('category.save')->middleware('can:categories');
            Route::delete('category/{id}/{lang_id}', [CategoryController::class, 'destroy'])->name('category.destroy')->middleware('can:categories');
            Route::get('category-details', [CategoryController::class, 'getDetailList'])->name('category.details')->middleware('can:categories');
            Route::post('update-category-field', [CategoryController::class, 'updateField'])->name('update.category.field')->middleware('can:categories');

            Route::get('pages', [PagesController::class, 'index'])->name('pages.index')->middleware('can:pages');
            Route::get('page-list-datatable', [PagesController::class, 'listPagesForDataTables'])->name('pages.list')->middleware('can:pages');
            Route::post('update-page-field', [PagesController::class, 'updateField'])->name('update.page.field')->middleware('can:pages');
            Route::get('page-detail-list', [PagesController::class, 'populatePageDetailGrid'])->name('page.detail.grid')->middleware('can:pages');
            Route::post('page-save', [PagesController::class, 'save'])->name('page.save')->middleware('can:pages');

            Route::get('faqs', [FaqController::class, 'index'])->name('faqs.index')->middleware('can:faqs');
            Route::get('faqs-list-datatable', [FaqController::class, 'listFaqsForDataTables'])->name('faqs.list')->middleware('can:faqs');
            Route::post('update-faq-field', [FaqController::class, 'updateField'])->name('update.faq.field')->middleware('can:faqs');
            Route::get('faqs-detail-list', [FaqController::class, 'populateFaqDetailGrid'])->name('faqs.detail.grid')->middleware('can:faqs');
            Route::post('faq-save', [FaqController::class, 'save'])->name('faqs.save')->middleware('can:faqs');

            Route::get('users', [UserController::class, 'index'])->name('users.index')->middleware('can:users');
            Route::get('users-list', [UserController::class, 'loadUsersForDataTable'])->name('users.list')->middleware('can:users');
            Route::post('users-save', [UserController::class, 'save'])->name('users.save')->middleware('can:users');
            Route::post('update-user-field', [UserController::class, 'updateField'])->name('update.user.field')->middleware('can:users');
            Route::delete('delete-user/{id}', [UserController::class, 'delete'])->name('users.destroy')->middleware('can:users');
            Route::get('change-password', [UserController::class, 'loadChangePasswordView'])->name('change.password');
            Route::post('change-password', [UserController::class, 'changePassword'])->name('change.password');

            Route::get('blog', [BlogController::class, 'index'])->name('blog.index')->middleware('can:blogs');
            Route::post('blog/save', [BlogController::class, 'store'])->name('blog.store')->middleware('can:blogs');
            Route::delete('blog/{id}', [BlogController::class, 'destroy'])->name('blog.destroy')->middleware('can:blogs');
            Route::get('blog-list-datatables', [BlogController::class, 'list'])->name('blogs.datatables.list')->middleware('can:blogs');
            Route::post('update-blog-field', [BlogController::class, 'updateField'])->name('update.blog.field')->middleware('can:blogs');
            Route::get('blog-detail-grid', [BlogController::class, 'detailGrid'])->name('blog.detail.grid')->middleware('can:blogs');

            Route::get('roles', [RoleController::class, 'index'])->name('roles.index')->middleware('can:roles');
            Route::get('roles-for-datatables', [RoleController::class, 'list'])->name('roles.list')->middleware('can:roles');
            Route::post('update-role-field', [RoleController::class, 'updateField'])->name('update.role.field')->middleware('can:roles');
            Route::post('save-role', [RoleController::class, 'save'])->name('roles.save')->middleware('can:roles');
            Route::delete('role/{id}', [RoleController::class, 'delete'])->name('role.destroy')->middleware('can:roles');
            Route::get('role-menu-view', [RoleController::class, 'roleMenus'])->name('role.menu.view')->middleware('can:roles');
            Route::post('role-menus-save', [RoleController::class, 'saveRoleMenus'])->name('role.menus.save')->middleware('can:roles');

            Route::get('features',              [FeatureController::class, 'index'])->name('features.index')->middleware('can:features');
            Route::get('features-datatables',   [FeatureController::class, 'list'])->name('features.datatables.list')->middleware('can:features');
            Route::get('features-detail-datatables', [FeatureController::class, 'detailGrid'])->name('features.detail.grid')->middleware('can:features');
            Route::post('features',             [FeatureController::class, 'save'])->name('features.save')->middleware('can:features');
            Route::post('feature-update-field', [FeatureController::class, 'updateField'])->name('update.feature.field')->middleware('can:features');
            Route::delete('features/{id}',      [FeatureController::class, 'delete'])->name('features.destroy')->middleware('can:features');

            Route::get('feature/options/{id}',      [OptionController::class, 'index'])->name('features.options')->middleware('can:features');
            Route::post('option/save/{feature_id}', [OptionController::class, 'save'])->name('option.save')->middleware('can:features');
            Route::get('options-datatables',        [OptionController::class, 'list'])->name('options.datatables.list')->middleware('can:features');
            Route::get('options-detail-datatables', [OptionController::class, 'detailGrid'])->name('options.detail.grid')->middleware('can:features');
            Route::delete('option/{id}',            [OptionController::class, 'delete'])->name('option.destroy')->middleware('can:features');
            Route::post('update-option-field',      [OptionController::class, 'updateField'])->name('update.option.field')->middleware('can:features');

            Route::get('feature/items/{id}',        [ItemController::class, 'index'])->name('features.items')->middleware('can:features');
            Route::post('item/save/{feature_id}',   [ItemController::class, 'save'])->name('item.save')->middleware('can:features');
            Route::get('items-datatables',          [ItemController::class, 'list'])->name('items.datatables.list')->middleware('can:features');
            Route::get('items-detail-datatables',   [ItemController::class, 'detailGrid'])->name('items.detail.grid')->middleware('can:features');
            Route::delete('item/{id}',              [ItemController::class, 'delete'])->name('item.destroy')->middleware('can:features');
            Route::post('update-item-field',        [ItemController::class, 'updateField'])->name('update.item.field')->middleware('can:features');

            Route::get('orders',            [OrderController::class, 'index'])->name('orders.index')->middleware('can:orders');
            Route::get('orders-list',       [OrderController::class, 'list'])->name('orders.datatables')->middleware('can:orders');
            Route::get('order-detail-list', [OrderController::class, 'detail'])->name('order.detail.grid')->middleware('can:orders');
        });
    });
});
