<?php

declare(strict_types=1);

namespace App\Actions\Category;

use App\Actions\Category\Data\CreateCategoryData;
use App\Models\Category;

class CreateCategoryAction
{
    public function exec(CreateCategoryData $data): Category
    {
        return Category::create($data->toArray());
    }
}
