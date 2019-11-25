<?php

namespace App\Models;

class Nomenclature extends AbstractDictionary implements INomenclature
{
    protected $fillable = [
        'name',
    ];
}
