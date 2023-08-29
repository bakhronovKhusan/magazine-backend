<?php

namespace App\Services;

use App\DTO\CreateProductDTO;
use App\Helpers\FileHelper;
use App\Http\Requests\ProductUpdateRequest;
use App\Models\Image;
use App\Models\Product;
use App\Models\ProductCategory;

class ProductService
{
    public function productAdd(CreateProductDTO $params): Product {
        $product = Product::firstOrCreate([
                'name'        => $params->name,
                'description' => $params->description,
                'price'       => $params->price,
                'is_exist'    => $params->is_exist,
        ]);
        foreach ($params->category as $category) {
            ProductCategory::firstOrCreate([
                'product_id' => $product->id,
                'category_id' => $category,
            ]);
        }
        return $product;
    }

    public function addImage(array $images,Product $product): void
    {
        foreach ($images as $file) {
            if(isset($product->id)){
                $filename = FileHelper::uploadFile($file);
                Image::create([
                    'name'       => $filename,
                    'product_id' => $product->id,
                    'url'        => $filename,
                ]);
            }
        }
    }

    public function updateImage(ProductUpdateRequest $request, Product $product): void
    {
        if($images = Image::where('product_id', $product->id)->get()) {
            Image::where('product_id', $product->id)->delete();
            $this->addImage($request['file'], $product);
            foreach ($images as $image) {
                FileHelper::deleteFile($image->name);
            }
        }
    }

    public function productUpdate(ProductUpdateRequest $request, Product $product): Product
    {
        $request = $request->validated();
        $product->update($request);
//      delete from ProductCategory
        if(isset($request['category']) && !empty($request['category'])){
            foreach($product->categories as $coty){
                $coty->pivot->delete();
            }
//      insert to ProductCategory
            foreach ($request['category'] as $category) {
                ProductCategory::firstOrCreate([
                    'product_id' => $product->id,
                    'category_id' => $category
                ]);
            }
        }
        return $product;
    }

    public function productDelete(Product $product) {
        $result = false;
        if($ProductCategory = ProductCategory::where('product_id', $product->id)){
            $ProductCategory->delete();
        }
        if($product->delete()){
            $result = true;
        }
        return $result;
    }
    public function deleteImage(Product $product): void {
        if($images = Image::where('product_id', $product->id)->get()) {
            Image::where('product_id', $product->id)->delete();
            foreach ($images as $image) {
                FileHelper::deleteFile($image->name);
            }
        }
    }
}
