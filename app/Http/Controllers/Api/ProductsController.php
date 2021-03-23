<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Http\Resources\api\ProductsResource;
use Validator;
use App\Models\User;
use App\Models\Favorite;

class ProductsController extends Controller
{
    // to get all products 
    public function getAll($vendor_id){
        $products = Product::where('vendor_id',$vendor_id)->where('is_deleted',0)->get();
        if(count($products) == 0){
            return response()->json(['message' => 'there are no products'],404);
        }
        return response()->json(['data' => $products],200);
    }

    // to get products by category id
    public function getByCategory(Request $request){
        $rules = [ 
            'category_id' => 'required',
            'vendor_id'   => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()){
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $products = Product::where('category_id',$request->category_id)
                        ->where('vendor_id',$request->vendor_id)
                        ->where('is_deleted',0)->get();
        if(count($products) == 0){
            return response()->json(['message' => 'there are no products in this category'],404);
        }
        return response()->json(['data' => $products],200);
    }

    // to get product by id
    public function getById($id){
        $product = Product::where('id',$id)->where('is_deleted',0)->first();
        if($product == null){
            return response()->json(['message' => 'product not found'],404);
        }
        return response()->json(['data' => $product],200);
    }

    // search products by name
    public function searchByName(Request $request){
        $rules = [ 
            'vendor_id' => 'required',
            'name'    => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()){
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $products = Product::search($request->name)
                        ->where('vendor_id',$request->vendor_id)
                        ->where('is_deleted',0)->get();
        if(count($products) == 0){
            return response()->json(['message' => 'no results match this query'],404);
        }
        return response()->json(['data' => $products],200);
    }

    // to filter products 
    public function productsFilter(Request $request, Product $product){
        $product = $product->newQuery();
        if($request->color != null){
            $product->whereJsonContains('colors',$request->color);
        }
        if($request->name != null){
            $product->where('name',$request->name);
        }
        if($request->category_id != null){
            $product->join('categories','product.id','categories.product_id')
                ->where('category_id','<=',$request->category_id);
        }
        return response()->json($product->where('is_deleted',0)
            ->with('images')
            ->get());
    }

    // to get user favorite list
    public function getFavorite(Request $request){
        $favorites = Favorite::where('user_id',$request->user_id)
                            ->with('product')
                            ->with('user')
                            ->get();
        if(count($favorites) == 0){
            return response()->json(['message' => 'favorite list is empty'],404);
        }
        return response()->json(['data' => $favorites],200);
    }

    // to add new product to the favorite list
    public function addToFavorite(Request $request){
        $rules = [ 
            'product_id' => 'required',
            'user_id'    => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()){
            return response()->json(['errors' => $validator->errors()], 400);
        }
        $favorite = Favorite::create($request->all());
        return response()->json(['data' => $favorite],200);
    }

    
}
