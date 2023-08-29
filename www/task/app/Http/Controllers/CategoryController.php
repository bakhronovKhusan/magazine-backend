<?php

namespace App\Http\Controllers;

use App\DTO\ResponseCategoryDTO;
use App\Http\Requests\CategoryAddRequest;
use App\Http\Requests\CategoryUpdateRequest;
use App\Http\Requests\ProductAddRequest;
use App\Http\Response\BaseResponse;
use App\Models\Category;
use App\Models\ProductCategory;
use App\Services\CategoryService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    private CategoryService $categoryService;

    public function __construct(CategoryService $categoryService)
    {

        $this->categoryService = $categoryService;
    }

    public function index()
    {
        return BaseResponse::success($this->categoryService->show());
    }

    public function store(CategoryAddRequest $request)
    {
        return BaseResponse::success($this->categoryService->add($request));
    }

    public function show(Category $category)
    {
        return BaseResponse::success($this->categoryService->show($category));
    }

    public function update(CategoryUpdateRequest $request, Category $category)
    {
        return BaseResponse::success($this->categoryService->update($request, $category));
    }


    public function destroy(Category $category)
    {
        if($this->categoryService->delete($category)) {
            return BaseResponse::success('Category deleted successfully');
        }

        return BaseResponse::error('Category deleted error');
    }
}
