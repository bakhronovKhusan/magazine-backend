<?php

namespace App\DTO;

use App\Models\Category;
use App\Models\Product;
use \Illuminate\Database\Eloquent\Collection;

class ResponseCategoryDTO
{
    public string   $id;
    public string   $name;
    public ?string  $parent_id;
    public string   $has_child;
    public Collection  $child;
    public Collection  $parent;

    public function __construct(Category $category)
    {
        $this->id        = $category->id;
        $this->name        = $category->name;
        $this->parent_id   = $category->parent_id;
        $this->has_child   = $category->has_child;
        $this->child       = $category->children()->get();
        $this->parent       = $category->parent()->get();
    }
}
