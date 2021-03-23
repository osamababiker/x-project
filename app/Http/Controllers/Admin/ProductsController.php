<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Product;
use Validator;

class ProductsController extends Controller
{
    public function addProduct(Request $request){
        $rules = [ 
            'name'                  => 'required|string',
            'price'                 => 'required',
            'selling_price'         => 'required',
            'product_specification' => 'required',
            'colors'                => 'required',
            'size'                  => 'required',
            'description'           => 'required',
            'category_id'           => 'required',
            'vendor_id'             => 'required',
            'factory_id'            => 'required'
        ];
        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()){
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $product = Product::create($request->all());
        return response()->json(['data' => $product], 201);
    }
}
