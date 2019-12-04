<?php

namespace App\Models\Documents;
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

abstract class AbstractDocument extends Model implements ModelInterface
{
    use CRUDTrait;
}
