<?php

namespace App\Http\Controllers;

use App\Orders as AppOrders;
use App\OrdersItems;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;

class Orders extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $query = request('query');
            $orders = AppOrders::join('customers', 'customers.id', '=', 'orders.customer_id', 'left')
                ->when(($query == null), function ($q) {
                    return $q;
                })
                ->when(($query !== null), function ($q) use ($query) {
                    return $q->where('orders.id', '=', $query)
                        ->orWhere('customers.first_name', 'like', '%' . $query . '%')
                        ->orWhere('customers.last_name', 'like', '%' . $query . '%')
                        ->orWhere('orders.payment_mode', 'like', '%' . $query . '%')
                        ->orWhere(function ($q) use ($query) {
                            $q->whereDate('orders.order_date', $query);
                        });
                })
                ->select('customers.first_name', 'customers.last_name', 'customers.phone_number', 'orders.*')
                ->orderBy('id', 'desc')->paginate(10);
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
            $order = new AppOrders();
            $exception = DB::transaction(function () use ($request, &$order, &$item_data) {
                $user = JWTAuth::parseToken()->toUser();

                // create order entry
                $order->user_id =  $user->id;
                $order->payment_mode =  $request->payment_mode;
                $order->customer_id =  $request->customer_id;
                $order->shipping_charge =  $request->shipping_charge;
                $order->total_amount =  $request->total_amount;
                $order->order_date =  $request->order_date;
                $order->table_number = $request->table_number;
                $order->save();

                // create items entry
                foreach ($request->products as $item) {
                    $order_item = new OrdersItems();
                    $order_item->order_id = $order->id;
                    $order_item->product_id = $item['product_id'];
                    $order_item->category_id = $item['category_id'];
                    $order_item->price = $item['price'];
                    $order_item->quantity = $item['quantity'];
                    $order_item->subtotal = $item['subtotal'];
                    $order_item->save();
                }
            });

            if (is_null($exception)) {
                return response()->json(['order' => $order]);
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
            $order = AppOrders::where('orders.id', $id)
                ->join('customers', 'customers.id', '=', 'orders.customer_id', 'left')
                ->select('customers.first_name', 'customers.last_name', 'customers.phone_number', 'orders.*')
                ->orderBy('orders.id', 'desc')->paginate(10)
                ->first();
            $items = OrdersItems::where('orders_items.order_id', $id)
                ->join('orders', 'orders.id', '=', 'orders_items.order_id', 'left')
                ->join('customers', 'customers.id', '=', 'orders.customer_id', 'left')
                ->join('product', 'product.id', '=', 'orders_items.product_id', 'left')
                ->join('category', 'category.id', '=', 'orders_items.category_id', 'left')
                ->select('product.product_name', 'category.name', 'customers.first_name', 'customers.last_name', 'customers.phone_number', 'orders_items.*')
                ->get();

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
            AppOrders::where('id', $id)->update([
                // create order entry
                "payment_mode" =>  $request->payment_mode,
                "customer_id" =>  $request->customer_id,
                "notes" =>  $request->notes,
                "shipping_charge" =>  $request->shipping_charge,
                "total_amount" =>  $request->total_amount,
                "order_date" => $request->order_date,
                "table_number" => $request->table_number
            ]);

            foreach ($request->products as $item) {
                if ($item['flag'] == 'add') {
                    $order_item = new OrdersItems();
                    $order_item->order_id = $item['order_id'];
                    $order_item->product_id = $item['product_id'];
                    $order_item->category_id = $item['category_id'];
                    $order_item->price = $item['price'];
                    $order_item->quantity = $item['quantity'];
                    $order_item->subtotal = $item['subtotal'];
                    $order_item->save();
                }
                if ($item['flag'] == 'delete') {
                    OrdersItems::where('order_id', $item['order_id'])
                        ->where('category_id', $item['category_id'])
                        ->where('product_id', $item['product_id'])
                        ->delete();
                }
            }

            $order = AppOrders::where('id', $id)->first();
            return response()->json($order);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => $e->getMessage() . ' ' . $e->getLine()]);
        }
    }

    // public function unOccupyTable(Request $request, $id)
    // {
    //     try {
    //         $updateorder = AppOrders::where('id', $id)->update(["table_number" => $request->table_number]);

    //         // dd($updateorder);

    //         $order = AppOrders::where('id', $id)->first();
    //         return response()->json($order);
    //     } catch (\Exception $e) {
    //         Log::error($e->getMessage());
    //         return response()->json(['error' => $e->getMessage() . ' ' . $e->getLine()], Response::HTTP_INTERNAL_SERVER_ERROR);
    //     }
    // }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            AppOrders::find($id)->delete();
            return response()->json([
                'status' => true,
            ]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => $e->getMessage() . ' ' . $e->getLine()]);
        }
    }
}
