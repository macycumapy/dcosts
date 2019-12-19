<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Documents\CashInflowInterface;
use Illuminate\Http\Request;

class CashInflowController extends Controller
{
    protected $cashInflow;

    public function __construct(CashInflowInterface $cashInflow)
    {
        $this->cashInflow = $cashInflow;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $cashInflow = $this->cashInflow->allByUserId($this->authUserId());

        return response()->json($cashInflow);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $attr = $request->validate($this->cashInflow->rules());

        $attr['user_id'] = $this->authUserId();

        $cashInflow = $this->cashInflow->create($attr);

        return response()->json($cashInflow);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $cashInflow = $this->cashInflow->findByConditionsOrAbort($this->cashInflow, ['id'=>$id, 'user_id' => $this->authUserId()]);

        return response()->json($cashInflow);
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
        $data = $request->validate($this->cashInflow::rules());

        $cashInflow = $this->cashInflow->findByConditionsOrAbort($this->cashInflow, ['id'=>$id, 'user_id' => $this->authUserId()]);
        $cashInflow->update($data);

        return response()->json($cashInflow);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $costItem = $this->cashInflow->findByConditionsOrAbort($this->cashInflow, ['id'=>$id, 'user_id' => $this->authUserId()]);
        $costItem->delete();

        return response()->json($costItem);
    }

    private function authUserId()
    {
        return auth()->id();
    }
}
