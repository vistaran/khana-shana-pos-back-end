<?php

namespace App\Http\Controllers;

use App\PurchaseOrderItems;
use Carbon\Carbon;
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
  
}
