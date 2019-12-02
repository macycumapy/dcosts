<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\NomenclatureInterface;
use Illuminate\Http\Request;

class NomenclatureController extends Controller
{
    protected $nomenclature;

    public function __construct(NomenclatureInterface $nomenclature)
    {
        $this->nomenclature = $nomenclature;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $result = $this->nomenclature->all();

        return response()->json($result);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $fields = $request->validate($this->nomenclature->rules());

        $nomenclature = $this->nomenclature->tryToCreate($fields);
        if (!$nomenclature) return response()->json([],400);

        return response()->json($nomenclature);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $nomenclature = $this->nomenclature->findById($id);
        if (!$nomenclature) return response()->json([],404);

        return response()->json($nomenclature);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $fields = $request->validate($this->nomenclature->rules());

        $nomenclature = $this->nomenclature->findById($id);
        if (!$nomenclature) return response()->json([],404);

        if (!$nomenclature->tryToUpdate($fields)) return response()->json($nomenclature,400);

        return response()->json($nomenclature);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $nomenclature = $this->nomenclature->findById($id);
        if (!$nomenclature) return response()->json([],404);

        $deleted = $nomenclature->tryToDelete();

        return response()->json([],$deleted ? 200 : 400);
    }
}
