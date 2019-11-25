<?php

namespace App\Http\Controllers;

use App\Models\INomenclature;
use Illuminate\Http\Request;

class NomenclatureController extends Controller
{

    protected $nomenclature;

    public function __construct(INomenclature $nomenclature)
    {
        $this->nomenclature = $nomenclature;
    }

    public function index()
    {
        return response([]);
    }
}
