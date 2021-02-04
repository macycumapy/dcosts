<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PartnerRequest;
use App\Models\Dictionaries\Partner;

class PartnerController extends Controller
{
    protected Partner $partner;

    public function __construct(Partner $partner)
    {
        $this->partner = $partner;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $result = $this->partner->all()();

        return response()->json($result);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(PartnerRequest $request)
    {
        $partner = $this->partner->create($request->validated());

        return response()->json($partner);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $partner = $this->partner->findOrFail($id);
        if (!$partner) {
            return response()->json([],404);
        }

        return response()->json($partner);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(PartnerRequest $request, $id)
    {
        $partner = $this->partner->findOrFail($id);
        $partner->update($request->validated());

        return response()->json($partner);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $partner = $this->partner->findOrFail($id);
        $partner->delete();

        return response()->json([]);
    }
}
