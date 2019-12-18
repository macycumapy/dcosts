<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CostItemInterface;
use App\Models\Documents\CashFlowInterface;
use Illuminate\Http\Request;

class CostItemController extends Controller
{
    private $costItem;

    public function __construct(CostItemInterface $costItem)
    {
        $this->costItem = $costItem;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $response = $this->costItem->allByUserId($this->authUserId());

        return response()->json($response);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $data = $request->validate($this->costItem::rules());
        $data['user_id'] = $this->authUserId();

        $costItem = $this->costItem->create($data);

        return response()->json($costItem);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $costItem = $this->costItem->findByConditionsOrAbort($this->costItem, ['id'=>$id, 'user_id' => $this->authUserId()]);

        return response()->json($costItem);
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
        $data = $request->validate($this->costItem::rules());

        $costItem = $this->costItem->findByConditionsOrAbort($this->costItem, ['id'=>$id, 'user_id' => $this->authUserId()]);
        $costItem->update($data);

        return response()->json($costItem);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $costItem = $this->costItem->findByConditionsOrAbort($this->costItem, ['id'=>$id, 'user_id' => $this->authUserId()]);
        $costItem->delete();

        return response()->json($costItem);
    }

    private function authUserId()
    {
        return auth()->id();
    }
}
