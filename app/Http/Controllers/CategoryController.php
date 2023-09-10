<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\Category\CreateCategoryAction;
use App\Actions\Category\DeleteCategoryAction;
use App\Actions\Category\UpdateCategoryAction;
use App\Http\Requests\Category\CategoryStoreRequest;
use App\Http\Requests\Category\CategoryUpdateRequest;
use App\Models\Category;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller
{
    public function index(): JsonResponse
    {
        return $this->successResponse('Список получен', Category::all());
    }

    public function store(CategoryStoreRequest $request, CreateCategoryAction $createCategoryAction): JsonResponse
    {
        return $this->successResponse(
            'Статья затрат добавлена',
            $createCategoryAction->exec($request->validated())
        );
    }

    public function show(Category $category): JsonResponse
    {
        return $this->successResponse(
            'Статья затрат получена',
            $category
        );
    }

    public function update(CategoryUpdateRequest $request, Category $category, UpdateCategoryAction $updateCategoryAction): JsonResponse
    {
        return $this->successResponse(
            'Статья затрат обновлена',
            $updateCategoryAction->exec($category, $request->validated())
        );
    }

    public function destroy(Category $category, DeleteCategoryAction $deleteCategoryAction): JsonResponse
    {
        $deleteCategoryAction->exec($category);

        return $this->successResponse('Статья затрат удалена');
    }
}
