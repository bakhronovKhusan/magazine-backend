<?php

namespace App\DTO;

use App\Models\Category;
use App\Models\Product;
use \Illuminate\Database\Eloquent\Collection;

class ResponseProductDTO
{
    public string   $name;
    public string   $description;
    public string   $price;
    public bool     $is_exist;

    public int      $id;
    public array    $categories;
    public array    $images;
    public Collection $product;
    public function __construct(Product $product)
    {
        $this->name        = $product->name;
        $this->description = $product->description;
        $this->price       = $product->price;
        $this->is_exist    = $product->is_exist;
        $this->id          = $product->id;
        $this->categories  = $product->categories()->select('categories.id as coty_id','name','parent_id','has_child')->get()->toArray();
        $this->images      = $product->images()->select('name','url')->get()->toArray();
    }
}
