<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\NomenclatureTypeInterface;
use Illuminate\Http\Request;

class NomenclatureTypeController extends Controller
{
    protected $nomenclatureType;

    public function __construct(NomenclatureTypeInterface $nomenclatureType)
    {
        $this->nomenclatureType = $nomenclatureType;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $result = $this->nomenclatureType->allByUserId($this->authUserId());

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
        $fields = $request->validate($this->nomenclatureType->rules());
        $fields['user_id'] = $this->authUserId();

        $nomenclatureType = $this->nomenclatureType->tryToCreate($fields);
        if(!$nomenclatureType) return response()->json([],400);

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
        $nomenclatureType = $this->nomenclatureType->findByConditionsOrAbort($this->nomenclatureType, ['id'=>$id, 'user_id' => $this->authUserId()]);

        return response()->json($nomenclatureType);
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
        $fields = $request->validate($this->nomenclatureType->rules());

        $nomenclatureType = $this->nomenclatureType->findByConditionsOrAbort($this->nomenclatureType, ['id'=>$id, 'user_id' => $this->authUserId()]);
        $nomenclatureType->tryToUpdate($fields);

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
        $nomenclatureType = $this->nomenclatureType->findByConditionsOrAbort($this->nomenclatureType, ['id'=>$id, 'user_id' => $this->authUserId()]);

        $deleted = $nomenclatureType->tryToDelete();

        return response()->json([],$deleted ? 200 : 400);
    }

    private function authUserId()
    {
        return auth()->id();
    }
}
