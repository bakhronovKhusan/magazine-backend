<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
        'id',
        'name',
        'price',
        'description',
        'is_exist',
    ];
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'product_category');
    }

    public function images()
    {
        return $this->hasMany(Image::class);
    }
}
