<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Product extends Model
{
    use HasFactory;
    use Sluggable;

    protected $fillable = [
        'user_type',
        'seller_id',
        'product_name',
        'slug',
        'product_summary',
        'category_id',
        'subcategory_id',
        'product_price',
        'compare_price',
        'product_image',
        'visibility'
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'product_name'
            ]
        ];
    }

    public function images() {
        return $this->hasMany(ProductImage::class, 'product_id', 'id');
    }
}
