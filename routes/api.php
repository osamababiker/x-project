<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
| 
*/

// Routes for auth users only
Route::middleware('auth:api')->group(function () {
    // Route to return the auth user info
    Route::get('/user', function (Request $request) {return $request->user();});
    // Route to log user out
    Route::post('/logout', 'Api\AuthController@logout');
    // Route to get user favorite list
    Route::get('favorites','Api\ProductsController@getFavorite');
    // Route to add product to favorite list
    Route::post('favorites/add','Api\ProductsController@addToFavorite');
    // Route to get user all orders
    Route::post('orders','Api\OrdersController@getOrders');
    // Route to delete user order
    Route::delete('orders/delete','Api\OrdersController@deleteOrder');
});

// Route to login user in
Route::post('/login','Api\AuthController@login');
// Route to register new user 
Route::post('/register','Api\AuthController@register');

// Route to get all products
Route::get('products/{vendor_id}','Api\ProductsController@getAll');

// Route to get products by category id
Route::post('products/categories','Api\ProductsController@getByCategory');

// Route to get product by id
Route::get('products/single/{id}','Api\ProductsController@getById');

// Route for searching products by name
Route::post('products/search','Api\ProductsController@searchByName');

// Route filtering products
Route::get('products/filter','Api\ProductsController@productsFilter');
