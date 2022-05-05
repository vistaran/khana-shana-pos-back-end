<?php

namespace App\Http\Controllers;

use App\PurchaseOrder as AppPurchaseOrder;
use App\PurchaseOrderItems;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;

class PurchaseOrder extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $orders = AppPurchaseOrder::join('vendors', 'vendors.id', '=', 'purchase_orders.vendor_id', 'left')
                ->join('outlets', 'outlets.id', '=', 'purchase_orders.outlet_id', 'left')
                ->select('vendors.name', 'outlets.outlet_name', 'purchase_orders.*')
                ->orderBy('purchase_orders.id', 'desc')->paginate(10);
            return response()->json([
                'orders' => $orders
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
            $purchaseOrder = new AppPurchaseOrder();
            $purchase_item_data = [];
            $exception = DB::transaction(function () use ($request, &$purchaseOrder, &$purchase_item_data) {
                $user = JWTAuth::parseToken()->toUser();

                // create order entry
                $purchaseOrder->vendor_id = $request->vendor_id;
                $purchaseOrder->outlet_id =  $request->outlet_id;
                $purchaseOrder->user_id =  $user->id;
                $purchaseOrder->notes =  $request->notes;
                $purchaseOrder->shipping_charge =  $request->shipping_charge;
                $purchaseOrder->total_amount =  $request->total_amount;
                $purchaseOrder->purchase_date =  $request->purchase_date;
                $purchaseOrder->save();
                // create items entry
                foreach ($request->items as $item) {
                    $purchase_item = new PurchaseOrderItems();
                    $purchase_item->purchase_order_id = $purchaseOrder->id;
                    $purchase_item->notes = $item['notes'];
                    $purchase_item->item_id = $item['item_id'];
                    $purchase_item->item_name = $item['item_name'];
                    $purchase_item->item_group_id = $item['item_group_id'];
                    $purchase_item->item_group_name = $item['item_group_name'];
                    $purchase_item->qty = $item['qty'];
                    $purchase_item->unit_id = $item['unit_id'];
                    $purchase_item->unit_name = $item['unit_name'];
                    $purchase_item->price = $item['price'];
                    $purchase_item->subtotal = $item['subtotal'];
                    $purchase_item->save();
                    array_push($purchase_item_data, $purchase_item);
                }
            });

            if (is_null($exception)) {
                return response()->json(['purchaseOrder' => $purchaseOrder, 'purchase_item' => $purchase_item_data]);
            } else {
                throw new \Exception;
            }
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
            $order = AppPurchaseOrder::join('vendors', 'vendors.id', '=', 'purchase_orders.vendor_id', 'left')
                ->join('outlets', 'outlets.id', '=', 'purchase_orders.outlet_id', 'left')
                ->where('purchase_orders.id', $id)
                // ->where('purchase_orders.id', $id)->first();
                ->select('vendors.name AS vendor_name', 'outlets.outlet_name', 'purchase_orders.*')
                ->get();
            $items = PurchaseOrderItems::where('purchase_order_id', $id)->get();

            return response()->json(['order' => $order, 'items' => $items]);
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
            AppPurchaseOrder::where('id', $id)->update([
                // create order entry
                "vendor_id" => $request->vendor_id,
                "outlet_id" =>  $request->outlet_id,
                "notes" =>  $request->notes,
                "shipping_charge" =>  $request->shipping_charge,
                "total_amount" =>  $request->total_amount,
                "purchase_date" => $request->purchase_date
            ]);


            // create items entry
            foreach ($request->items as $item) {
                if ($item['flag'] == 'update') {
                    PurchaseOrderItems::where('id', $item['id'])->update([
                        'notes' => $item['notes'],
                        'item_id' => $item['item_id'],
                        'item_name' => $item['item_name'],
                        'item_group_id' => $item['item_group_id'],
                        'item_group_name' => $item['item_group_name'],
                        'qty' => $item['qty'],
                        'unit_id' => $item['unit_id'],
                        'unit_name' => $item['unit_name'],
                        'price' => $item['price'],
                        'subtotal' => $item['subtotal']
                    ]);
                }

                if ($item['flag'] == 'delete') {
                    PurchaseOrderItems::where('id', $item['id'])->delete();
                }

                if ($item['flag'] == 'add') {
                    $purchase_item = new PurchaseOrderItems();
                    $purchase_item->purchase_order_id = $id;
                    $purchase_item->notes = $item['notes'];
                    $purchase_item->item_id = $item['item_id'];
                    $purchase_item->item_name = $item['item_name'];
                    $purchase_item->item_group_id = $item['item_group_id'];
                    $purchase_item->item_group_name = $item['item_group_name'];
                    $purchase_item->qty = $item['qty'];
                    $purchase_item->unit_id = $item['unit_id'];
                    $purchase_item->unit_name = $item['unit_name'];
                    $purchase_item->price = $item['price'];
                    $purchase_item->subtotal = $item['subtotal'];
                    $purchase_item->save();
                }
            }
            $vendor = AppPurchaseOrder::where('id', $id)->first();
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
            AppPurchaseOrder::find($id)->delete();
            return response()->json([
                'status' => true,
            ]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => $e->getMessage() . ' ' . $e->getLine()]);
        }
    }
}
