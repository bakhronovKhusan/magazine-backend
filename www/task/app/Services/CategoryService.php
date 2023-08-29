<?php

namespace App\Services;

use App\DTO\CreateProductDTO;
use App\DTO\ResponseCategoryDTO;
use App\Helpers\FileHelper;
use App\Http\Requests\CategoryAddRequest;
use App\Http\Requests\CategoryUpdateRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Models\Category;
use App\Models\Image;
use App\Models\Product;
use App\Models\ProductCategory;

class CategoryService
{
    public function add(CategoryAddRequest $request): ResponseCategoryDTO {
        return New ResponseCategoryDTO(
            Category::firstOrCreate($request->validated())
        );
    }

    public function show(Category $category = null): array {
        $result = [];
        if($category){
            $result[] = new ResponseCategoryDTO($category);
        }else{
            $categories = Category::whereNull('parent_id')->get();
            foreach ($categories as $category) {
                $result[] = new ResponseCategoryDTO($category);
            }
        }
        return $result;
    }

    public function update(CategoryUpdateRequest $request, Category $category): array {
        $request = $request->validated();
        $category->update($request);
        if( isset($request['has_child'])  && $request['has_child']==0){
            foreach($category->children as $child){
                $child->update([ 'parent_id'=> null ]);
            }
        }
        return self::show($category);
    }

    public function delete(Category $category){

        if($ProductCategory = ProductCategory::where('category_id',$category->id)->get()){
            foreach ($ProductCategory as $item){
                $item->delete();
            }
        }
        foreach($category->children as $child){
            $child->update([ 'parent_id'=> null ]);
        }

        return $category->delete();
    }
}
