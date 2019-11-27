<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\NomenclatureInterface;
use App\Models\NomenclatureTypeInterface;
use Illuminate\Http\Request;

class NomenclatureController extends Controller
{
    protected $nomenclature;
    protected $nomenclatureType;

    public function __construct(NomenclatureInterface $nomenclature, NomenclatureTypeInterface $nomenclatureType)
    {
        $this->nomenclature = $nomenclature;
        $this->nomenclatureType = $nomenclatureType;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
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
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $fields = $request->validate($this->nomenclature->rules());

        $nomenclatureType = $this->nomenclatureType->find($fields['nomenclature_type_id']);
        if (!$nomenclatureType) return response([],404);

        $nomenclature = $this->nomenclature->create($fields);

        return response()->json($nomenclature);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $nomenclature = $this->nomenclature->find($id);
        if (!$nomenclature) return response([],404);

        return response()->json($nomenclature);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $fields = $request->validate($this->nomenclature->rules());

        $nomenclature = $this->nomenclature->find($id);
        $nomenclatureType = $this->nomenclatureType->find($fields['nomenclature_type_id']);
        if (!$nomenclature || !$nomenclatureType) return response([],404);

        $nomenclature->update($fields);

        return response()->json($nomenclature);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $nomenclature = $this->nomenclature->find($id);
        if (!$nomenclature) return response([],404);

        $nomenclature->delete();

        return response([]);
    }
}
