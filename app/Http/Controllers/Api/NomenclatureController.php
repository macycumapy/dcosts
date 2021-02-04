<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\NomenclatureRequest;
use App\Models\Dictionaries\Nomenclature;

class NomenclatureController extends Controller
{
    protected Nomenclature $nomenclature;

    public function __construct(Nomenclature $nomenclature)
    {
        $this->nomenclature = $nomenclature;
        $this->nomenclature->whereAuthUserOwner();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $result = $this->nomenclature->allByAuthUser();

        return response()->json($result);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param NomenclatureRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(NomenclatureRequest $request)
    {
        $nomenclature = $this->nomenclature->create($request->validated());

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
        $nomenclature = $this->nomenclature->whereAuthUserOwner()->find($id);
        if (!$nomenclature) {
            return response()->json([],404);
        }

        return response()->json($nomenclature);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param NomenclatureRequest $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(NomenclatureRequest $request, $id)
    {
        $nomenclature = $this->nomenclature->whereAuthUserOwner()->find($id);
        if (!$nomenclature) {
            return response()->json([],404);
        }

        $nomenclature->update($request->validated());

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
        $nomenclature = $this->nomenclature->whereAuthUserOwner()->find($id);
        if (!$nomenclature) {
            return response()->json([],404);
        }
        $deleted = $nomenclature->delete();

        return response()->json([],$deleted ? 200 : 400);
    }
}
