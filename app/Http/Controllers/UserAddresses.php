<?php

namespace App\Http\Controllers;

use App\UserAddress;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserAddresses extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $customerAddress = UserAddress::select('user_addresses.*')->get();
            return response()->json(['customerAddress' => $customerAddress]);
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
            UserAddress::insert([
                'user_id' => $request->customer_id,
                'address_type_id' => $request->address_type_id,
                'address_type' => $request->address_type,
                'address_line_1' => $request->address_line_1,
                'address_line_2' => $request->address_line_2,
                'address_line_3' => $request->address_line_3,
                'city' => $request->city,
                'state' => $request->state,
                'contry' => $request->contry,
                'postalcode' => $request->postalcode,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude
            ]);
            return response()->json(['message' => "successfully added to the database"]);
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
            $customerAddress = UserAddress::where('user_id', $id)->get();
            return response()->json(['customerAddress' => $customerAddress]);
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
        try {
            $customerAddress = UserAddress::where('id', $id)->get();
            return response()->json($customerAddress);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => $e->getMessage() . ' ' . $e->getLine()]);
        }
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

            UserAddress::where('id', $id)
                ->update([
                    'user_id' => $request->user_id,
                    'address_type_id' => $request->address_type_id,
                    'address_type' => $request->address_type,
                    'address_line_1' => $request->address_line_1,
                    'address_line_2' => $request->address_line_2,
                    'address_line_3' => $request->address_line_3,
                    'city' => $request->city,
                    'state' => $request->state,
                    'contry' => $request->contry,
                    'postalcode' => $request->postalcode,
                    'latitude' => $request->latitude,
                    'longitude' => $request->longitude
                ]);
            $customerAddress = UserAddress::where('id', $id)->first();

            return response(['customerAddress' => $customerAddress]);
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
            UserAddress::where('id', $id)
                ->delete();
            return response()->json([
                'Delete Message' => 'Successfully Deleted !',
            ]);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => $e->getMessage() . ' ' . $e->getLine()]);
        }
    }
}
