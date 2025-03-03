<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'code',
        'description',
        'original_price',
        'price',
        'discount',
        'stock',
        'image',
        'status',
        'weight',
        'dimension',
        'color',
        'material',
        'cost',
        'profit',
        'category_id',
        'brand_id',
        'deleted_by',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
}
