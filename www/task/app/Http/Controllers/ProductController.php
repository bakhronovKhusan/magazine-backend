<?php

namespace App\Http\Controllers;

use App\DTO\ResponseProductDTO;
use App\Helpers\FileHelper;
use App\Http\Requests\ProductAddRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Http\Response\BaseResponse;
use App\Models\Image;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceResponse;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    private ProductService $productService;

    public function __construct(ProductService $productService)
    {

        $this->productService = $productService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $result = [];
        $products = new Product;
        foreach ($products->all() as $product)
        {
            $result[] = new ResponseProductDTO($product);
        }
        return BaseResponse::success($result);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductAddRequest $request)
    {
        $requestDTO = $request->getDTO();
        $product = $this->productService->productAdd($requestDTO);
        if(isset($request['file']) && !empty($request['file'])) {
            $this->productService->addImage($request['file'], $product);
        }
        return BaseResponse::success(new ResponseProductDTO($product));
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return BaseResponse::success(new ResponseProductDTO($product));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductUpdateRequest $request, Product $product)
    {
        $product = $this->productService->productUpdate($request, $product);
        $this->productService->updateImage($request, $product);

        return BaseResponse::success(new ResponseProductDTO($product));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $this->productService->deleteImage($product);
        if($this->productService->productDelete($product)){
            return BaseResponse::success('Delete Successfully!');
        }
        return BaseResponse::error('Delete Error!');
    }
}
