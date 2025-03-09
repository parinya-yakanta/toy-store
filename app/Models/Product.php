<?php

namespace App\Models;

use App\Helpers\CommonHelper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'category_id',
        'brand_id',
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
        'deleted_by',
        'user_id',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function getImageAttribute($value)
    {
        return CommonHelper::getImage($value);
    }
}
