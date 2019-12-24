<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Documents\CashFlowInterface;
use Illuminate\Http\Request;

class CashFlowController extends Controller
{
    private $cashFlow;

    public function __construct(CashFlowInterface $cashFlow)
    {
        $this->cashFlow = $cashFlow;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $result = $this->cashFlow->allByUserId($this->authUserId());

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
        $attr = $request->validate($this->cashFlow->rules());

        $details = isset($attr['details']) ? $attr['details'] : null;
        $attr['user_id'] = $this->authUserId();
        $attr['sum'] = $this->cashFlow->getSumByDetails($details);

        $newCashFlow = $this->cashFlow->create($attr);
        if (!$newCashFlow) abort(response()->json([],400));

        if ($details) {
            foreach ($details as $detail){
                $newCashFlow->addDetails($detail);
            }
        }

        return response()->json($newCashFlow->firstWithDetails());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $cashFlow = $this->cashFlow->findByConditionsOrAbort($this->cashFlow, ['id'=>$id, 'user_id' => $this->authUserId()]);

        return response()->json($cashFlow->firstWithDetails());
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
        $attr = $request->validate($this->cashFlow->rules());

        $cashFlow = $this->cashFlow->findByConditionsOrAbort($this->cashFlow, ['id'=>$id, 'user_id' => $this->authUserId()]);;

        $details = isset($attr['details']) ? $attr['details'] : null;
        $attr['sum'] = $this->cashFlow::getSumByDetails($details);

        $cashFlow->update($attr);
        if ($details) {
            $cashFlow->updateDetails($details);
        }

        return response()->json($cashFlow->firstWithDetails());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $cashFlow = $this->cashFlow->findByConditionsOrAbort($this->cashFlow, ['id'=>$id, 'user_id' => $this->authUserId()]);;
        $cashFlow->delete();

        return response()->json([]);
    }

    private function authUserId()
    {
        return auth()->id();
    }
}
