<?php

declare(strict_types=1);

namespace App\Actions\Category;

use App\Actions\Category\Data\UpdateCategoryData;
use App\Models\Category;

class UpdateCategoryAction
{
    public function exec(Category $category, UpdateCategoryData $data): bool
    {
        return $category->update($data->toArray());
    }
}
