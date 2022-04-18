<?php

namespace App\Http\Controllers;

use App\PurchaseItems;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Response;


class PurchaseItemsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
             $pitems = PurchaseItems::query();
            $query = request('query');

            $pitems->select('purchase_items.*', 'units.unit as unit_name', 'item_groups.group_name')
                ->join('item_groups', 'item_groups.id', '=', 'purchase_items.item_group_id', 'left')
                ->join('units', 'units.id', '=', 'purchase_items.unit_id', 'left');


            if (!empty($request->get('group_id'))) {
                $pitems->where('item_group_id', $request->get('group_id'));
            }

            $pitems->when(($query !== null), function ($q) use ($query) {
                $q->where('purchase_items.item_name', 'like', '%' . $query . '%')
                    ->orderBy('purchase_items.id', 'desc')
                    ->paginate(10);
                return response()->json(['purchase_items' => $q]);
            });

            $pitems->orderBy('purchase_items.id', 'desc')
                ->paginate(10);
            return response()->json([
                'purchase_items' => $pitems
            ]);
            
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => $e->getMessage() . ' ' . $e->getLine()]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $vendor = new PurchaseItems();
            $vendor->item_name = $request->item_name;
            $vendor->item_group_id = $request->item_group_id;
            $vendor->unit_id =  $request->unit_id;
            $vendor->save();
            return response()->json($vendor);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => $e->getMessage() . ' ' . $e->getLine()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $vendor = PurchaseItems::where('id', $id)->first();
            return response()->json($vendor);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => $e->getMessage() . ' ' . $e->getLine()]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        try {
            PurchaseItems::where('id', $id)->update([
                'item_name' => $request->item_name,
                'item_group_id' => $request->item_group_id,
                'unit_id' => $request->unit_id
            ]);
            $vendor = PurchaseItems::where('id', $id)->first();
            return response()->json($vendor);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => $e->getMessage() . ' ' . $e->getLine()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            PurchaseItems::find($id)->delete();
            return response()->json([
                'status' => true,
            ]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => $e->getMessage() . ' ' . $e->getLine()]);
        }
    }
}
