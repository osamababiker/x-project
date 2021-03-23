<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;
//use Laravel\Scout\Searchable;

class Product extends Model
{
    //use Searchable;
    use SearchableTrait;

    protected $table = 'products';
    protected $fillable = [
        'name',
        'price',
        'selling_price',
        'product_specification',
        'colors',
        'size',
        'description',
        'category_id',
        'vendor_id',
        'factory_id'
    ];
    protected $searchable = [
        /**
         * Columns and their priority in search results.
         * Columns with higher values are more important.
         * Columns with equal values have equal importance.
         *
         * @var array
         */
        'columns' => [
            'products.name' => 10,
            //'products.description' => 10,
        ],
        // 'joins' => [
        //     'posts' => ['products.id','posts.user_id'],
        // ],
    ];

    // public function category(){
    //     return $this->belongsTo('App\Models\Category');
    // }
}
