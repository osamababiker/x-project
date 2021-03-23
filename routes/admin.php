<?php

use Illuminate\Http\Request;


Route::post('products/add', [
    'uses' => 'Admin\ProductsController@addProduct'
]);