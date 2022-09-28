<?php

namespace App\Http\Controllers;

use App\Customers;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CustomerController extends Controller
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
            $limit = request('limit');
            $customers = Customers::select('customers.*')

                // default
                ->when(($query == null), function ($q) {
                    return $q;
                })

                // search by item_name
                ->when(($query !== null), function ($q) use ($query) {
                    return $q->where('phone_number', $query)
                        ->orWhere('first_name', 'like', $query . '%')
                        ->orWhere('last_name', 'like', $query . '%');
                });

            // default
            if (($limit == null)) {
                return $customers->orderBy('id', 'desc')->paginate(10);
            }

            // for dynamic pagination
            if (($limit !== null && $limit <= 500)) {
                return $customers->orderBy('id', 'desc')->paginate($limit);
            }

            if (($limit !== null && $limit > 500)) {
                return $customers->orderBy('id', 'desc')->paginate(500);
            };
            return response()->json(['customers' => $customers]);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => $e->getMessage() . ' ' . $e->getLine()]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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

            $customer = new Customers();
            $customer->first_name = $request->first_name;
            $customer->last_name = $request->last_name;
            $customer->phone_number = $request->phone_number;
            $customer->save();

            return response()->json(['customers' => $customer->id]);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => $e->getMessage() . ' ' . $e->getLine()]);
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
            $customers = Customers::where('id', $id)->select('customers.*')->first();
            return response()->json($customers);
        } catch (Exception $e) {
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

            $customers = Customers::where('id', $id)
                ->update([
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'phone_number' => $request->phone_number,
                    'email' => $request->email,
                    'home_address' => $request->home_address,
                    'office_address' => $request->office_address,
                    'other_address' => $request->other_address
                ]);
            return response()->json(['customers' => $customers]);
        } catch (Exception $e) {
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
            Customers::where('id', $id)->delete();
            return response()->json([
                'Delete Message' => 'Successfully Deleted !',
            ]);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => $e->getMessage() . ' ' . $e->getLine()]);
        }
    }
}
