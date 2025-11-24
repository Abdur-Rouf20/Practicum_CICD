<?php

Route::get('/', 'HomeController@index');
Route::get('/category', 'HomeController@category');
Route::get('/product', 'HomeController@product');

Route::get('/cart', 'CartController@index');
Route::post('/cart/add', 'CartController@add');
Route::get('/cart/remove', 'CartController@remove');
Route::get('/cart/clear', 'CartController@clear');

// AUTH
Route::get('/login', 'AuthController@loginPage');
Route::post('/login', 'AuthController@login');
Route::get('/logout', 'AuthController@logout');

// BUYER
Route::get('/checkout', 'CheckoutController@index');

// SELLER
Route::get('/seller/dashboard', 'SellerController@index');
Route::get('/seller/products', 'SellerController@products');

// ADMIN
Route::get('/admin/dashboard', 'AdminController@index');
