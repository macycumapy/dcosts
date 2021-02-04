<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\NomenclatureTypeRequest;
use App\Models\Dictionaries\NomenclatureType;

class NomenclatureTypeController extends Controller
{
    protected NomenclatureType $nomenclatureType;

    public function __construct(NomenclatureType $nomenclatureType)
    {
        $this->nomenclatureType = $nomenclatureType;
        $this->nomenclatureType->whereAuthUserOwner();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $result = $this->nomenclatureType->all();

        return response()->json($result);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param NomenclatureTypeRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(NomenclatureTypeRequest $request)
    {
        $nomenclatureType = $this->nomenclatureType->create($request->validated());

        return response()->json($nomenclatureType);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $nomenclatureType = $this->nomenclatureType->findOrFail($id);

        return response()->json($nomenclatureType);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param NomenclatureTypeRequest $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(NomenclatureTypeRequest $request, $id)
    {
        $nomenclatureType = $this->nomenclatureType->findOrFail($id);
        $nomenclatureType->update($request->validated());

        return response()->json($nomenclatureType);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $nomenclatureType = $this->nomenclatureType->findOrFail($id);
        $nomenclatureType->delete();

        return response()->json([]);
    }
}
