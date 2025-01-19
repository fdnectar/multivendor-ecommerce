<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\CategoriesController;

Route::prefix('admin')->name('admin.')->group(function() {

    //guest routes middleware
    Route::middleware(['guest:admin','PreventBackHistory'])->group(function() {
        Route::view('/login', 'back.pages.admin.auth.login')->name('login');
        Route::view('/forgot-password', 'back.pages.admin.auth.forgot-password')->name('forgot-password');

        Route::controller(AdminController::class)->group(function () {
            Route::post('/login-handler', 'loginHandler')->name('login-handler');
            Route::post('/send-password-reset-link', 'sendPasswordResetLink')->name('send-password-reset-link');
            Route::get('/password/reset/{token}', 'resetPassword')->name('reset-password');
            Route::post('reset-password-handler', 'resetPasswordHandler')->name('reset-password-handler');
        });
    });

    //Admin authenticated routes
    Route::middleware(['auth:admin','PreventBackHistory'])->group(function() {
        Route::view('/home', 'back.pages.admin.home')->name('home');
        Route::view('/settings', 'back.pages.settings')->name('settings');

        Route::controller(AdminController::class)->group(function () {
            Route::post('/logout-handler', 'logoutHandler')->name('logout-handler');
            Route::get('/profile', 'profileView')->name('profile');
            Route::post('change-profile-picture', 'changeProfilePicture')->name('change-profile-picture');
            Route::post('change-logo', 'changeLogo')->name('change-logo');
            Route::post('change-favicon', 'changeFavicon')->name('change-favicon');
        });

        // Manage Categories and subcategories routes
        Route::prefix('manage-categories')->name('manage-categories.')->group(function() {
            Route::controller(CategoriesController::class)->group(function() {
                Route::get('/', 'catSubcatList')->name('cat-subcats-list');
                Route::get('/add-category', 'addCategory')->name('add-category');
                Route::post('/store-category', 'storeCategory')->name('store-category');
                Route::get('/edit-category', 'editCategory')->name('edit-category');
                Route::post('/store-updated-category', 'updateCategory')->name('store-updated-category');
                Route::get('/add-subcategory', 'addSubCategory')->name('add-subcategory');
                Route::post('/store-subcategory', 'storeSubCategory')->name('store-subcategory');
                Route::get('/edit-subcategory', 'editSubCategory')->name('edit-subcategory');
                Route::post('/update-subcategory', 'updateSubcategory')->name('update-subcategory');
            });
        });
    });
});
