<?php

namespace App\Http\Controllers;

use App\PurchaseOrderItems;
use Carbon\Carbon;
use App\Http\Controllers\DB;
use App\PurchaseOrder as AppPurchaseOrder;
use Illuminate\Http\Request;

class ExpenseReportsController extends Controller
{
    public function show()
    {
        $data = PurchaseOrderItems::select('subtotal', 'item_group_id', 'item_group_name')
            ->whereIn('purchase_order_id', function ($query) {
                $query->select('id')
                    ->from(with(new AppPurchaseOrder)->getTable())
                    ->whereBetween('purchase_date', [request('startdate'), request('enddate')]);
            })->groupBy('item_group_id')
            ->get();
        return response()->json([

            'data' => $data
        ]);
    }
    public function totalExpense()
    {
        // $amount = AppPurchaseOrder::whereYear('purchase_date',request('year') )
        // ->whereMonth('purchase_date', request('month'))
        // ->sum('total_amount');

        // $amount = PurchaseOrderItems::select('item_group_name',DB::raw('SUM(subtotal) as total'))
        // ->whereIn('purchase_order_id', function ($query) {
        //     $query->select('id')
        //         ->from(with(new AppPurchaseOrder)->getTable())
        //         ->whereBetween('purchase_date', [request('startdate'), request('enddate')]);
        // })->groupBy('item_group_id')
        // ->get();
        $amount = PurchaseOrderItems::
        select('purchase_order_items.item_group_name', AppPurchaseOrder::raw('SUM(purchase_orders.total_amount) as total'))
       ->join('purchase_orders','purchase_orders.id','=',
            'purchase_order_items.purchase_order_id','left')
            // ->whereBetween('purchase_orders.purchase_date', [request('startdate'), request('enddate')])
        ->whereYear('purchase_orders.purchase_date',request('year') )
        ->whereMonth('purchase_orders.purchase_date', request('month'))
        ->groupBy('purchase_order_items.item_group_name')
        ->get();
        return response()->json([

            'amount' => $amount
        ]);
    }
    public function showItem()
    {
        $data = PurchaseOrderItems::select('item_name', AppPurchaseOrder::raw('SUM(purchase_orders.total_amount) as total'))
            ->join(
                'purchase_orders',
                'purchase_orders.id',
                '=',
                'purchase_order_items.purchase_order_id',
                'left'
            )
            // ->whereBetween('purchase_orders.purchase_date', [request('startdate'), request('enddate')])
            ->whereYear('purchase_orders.purchase_date', request('year'))
            ->whereMonth('purchase_orders.purchase_date', request('month'))
            ->groupBy('purchase_order_items.item_name')
        ->orderBy('item_id','desc')
        ->paginate(10);
        return response()->json([

            'data' => $data
        ]);
    }
}
