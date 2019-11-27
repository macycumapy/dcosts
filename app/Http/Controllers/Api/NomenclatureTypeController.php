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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result = $this->nomenclatureType->all();

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
        $fields = $request->validate($this->nomenclatureType->rules());

        $result = $this->nomenclatureType->create($fields);

        return response()->json($result);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $nomenclatureType = $this->nomenclatureType->find($id);
        if (!$nomenclatureType) return response([],404);

        return response()->json($nomenclatureType);
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
        $fields = $request->validate($this->nomenclatureType->rules());

        $nomenclatureType = $this->nomenclatureType->find($id);
        if (!$nomenclatureType) return response([],404);

        $nomenclatureType->update($fields);

        return response()->json($nomenclatureType);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $nomenclatureType = $this->nomenclatureType->find($id);
        if (!$nomenclatureType) return response([],404);

        $nomenclatureType->delete();

        return response([]);
    }
}
