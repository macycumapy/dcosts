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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $response = $this->costItem->all();

        return response()->json($response);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate($this->costItem::rules());

        $costItem = $this->costItem->tryToCreate($data);

        return response()->json($costItem);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $costItem = $this->findByIdOrAbort($id);

        return response()->json($costItem);
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
        $data = $request->validate($this->costItem::rules());

        $costItem = $this->findByIdOrAbort($id);
        $costItem->tryToUpdate($data);

        return response()->json($costItem);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $costItem = $this->findByIdOrAbort($id);
        $costItem->tryToDelete();

        return response()->json($costItem);
    }

    /**
     * Finding model by id
     *
     * @param $id
     * @return CostItemInterface|CostItemInterface[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null
     */
    private function findByIdOrAbort($id)
    {
        $costItem = $this->costItem->findById($id);
        if (!$costItem) abort(response()->json([],404));

        return $costItem;
    }
}
