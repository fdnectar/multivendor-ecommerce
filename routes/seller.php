<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Seller\SellerController;
use App\Http\Controllers\Seller\ProductController;

Route::prefix('seller')->name('seller.')->group(function() {

    Route::middleware(['guest:seller','PreventBackHistory'])->group(function() {
        Route::controller(SellerController::class)->group(function() {
            Route::get('/login', 'login')->name('login');
            Route::post('/login-handler', 'loginHandler')->name('login-handler');
            Route::get('/register', 'register')->name('register');
            Route::post('/create', 'createSeller')->name('create');
            Route::get('/account/verify/{token}', 'verifyAccount')->name('verify');
            Route::get('/register-success', 'registerSuccess')->name('register-success');
            Route::get('/forgot-password', 'forgotPassword')->name('forgot-password');
            Route::post('/send-password-reset-link', 'sendPasswordResetLink')->name('send-password-reset-link');
            Route::get('/password/reset/{token}', 'showResetForm')->name('reset-password');
            Route::post('/reset-password-handler', 'resetPasswordHandler')->name('reset-password-handler');
        });
    });

    Route::middleware(['auth:seller','PreventBackHistory'])->group(function() {
        Route::controller(SellerController::class)->group(function() {
            Route::get('/', 'home')->name('home');
            Route::post('/logout-handler', 'logoutHandler')->name('logout-handler');
            Route::get('/profile', 'profileView')->name('profile');
            Route::post('/change-profile-picture', 'changeProfilePicture')->name('change-profile-picture');
            Route::get('/shop-settings', 'shopSettings')->name('shop-settings');
            Route::post('/shop-setup', 'shopSetup')->name('shop-setup');
        });

        //Product Routes
        Route::prefix('product')->name('product.')->group(function() {
            Route::controller(ProductController::class)->group(function() {
                Route::get('/all-products', 'allProductList')->name('all-products');
                Route::get('/add-product', 'addProduct')->name('add-product');
                Route::get('/get-product-category', 'getProductcategory')->name('get-product-category');
                Route::post('/create', 'createProduct')->name('create');
                Route::get('/edit-product', 'editProduct')->name('edit-product');
                Route::post('/update-product', 'updateProduct')->name('update-product');

                Route::post('/upload-product-images', 'uploadProductImages')->name('upload-product-images');
                Route::get('/get-product-images', 'getProductImages')->name('get-product-images');
                Route::post('/delete-product-image', 'deleteProductImage')->name('delete-product-image');
                Route::post('/delete-product', 'deleteProduct')->name('delete-product');
            });
        });
    });

});
