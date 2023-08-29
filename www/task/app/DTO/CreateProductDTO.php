<?php

namespace App\DTO;

use App\Models\Category;
use App\Models\Product;

class CreateProductDTO
{
    public string   $name;
    public string   $description;
    public string   $price;
    public bool     $is_exist;
    public int      $product_id;
    public array    $category;

    public array    $file;
    public function __construct(string   $name,
                                string   $description,
                                string   $price,
                                bool     $is_exist,
                                int      $product_id,
                                array    $category
    )
    {
        $this->name        = $name;
        $this->description = $description;
        $this->price       = $price;
        $this->is_exist    = $is_exist;
        $this->product_id  = $product_id;
        $this->category = $category;
    }
}
