<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PartnerInterface;
use Illuminate\Http\Request;

class PartnerController extends Controller
{
    protected $partner;

    public function __construct(PartnerInterface $partner)
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
        $result = $this->partner->allByUserId($this->authUserId());

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
        $fields = $request->validate($this->partner->rules());
        $fields['user_id'] = $this->authUserId();

        $partner = $this->partner->create($fields);

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
        $partner = $this->partner->findByConditionsOrAbort($this->partner, ['id'=>$id, 'user_id' => $this->authUserId()]);

        return response()->json($partner);
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
        $fields = $request->validate($this->partner->rules());

        $partner = $this->partner->findByConditionsOrAbort($this->partner, ['id'=>$id, 'user_id' => $this->authUserId()]);
        $partner->update($fields);

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
        $partner = $this->partner->findByConditionsOrAbort($this->partner, ['id'=>$id, 'user_id' => $this->authUserId()]);

        $deleted = $partner->delete();

        return response()->json([],$deleted ? 200 : 400);
    }

    private function authUserId()
    {
        return auth()->id();
    }
}
