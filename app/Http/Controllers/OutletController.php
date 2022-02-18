<?php

namespace App\Http\Controllers;

use App\Outlet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Exceptions\JWTException;

class OutletController extends Controller
{
    public function show(Request $request)
    {
        $outlet = Outlet::select(
            'id',
            'Outlet_name',
            'Outlet_name',
            'Country',
            'State',
            'City',
            'Postcode',
            'Status'
        )->paginate(10);
        return response()->json([
            'outlets' => $outlet,

        ]);
    }
    public function edit($id, Request $request)
    {
        $credential = $request->only(['name', 'address', 'country', 'state', 'city', 'postcode', 'status']);
        $outlet = Outlet::where('id', $id)
            ->update([
                'Outlet_name' => $request->name,
                'Outlet_Address' => $request->address,
                'Country' => $request->country,
                'State' => $request->state,
                'City' => $request->city,
                'Postcode' => $request->postcode,
                'Status' => $request->status
            ]);
        return response()->json([
            'Update Message' => 'Successfully Updated !',
        ]);
    }
    public function delete($id)
    {
        Outlet::find($id)
            ->delete();
        return response()->json([
            'Delete Message' => 'Successfully Deleted !',
        ]);
    }
    public function insert(Request $request)
    {
        $credentials = $request->only(['name', 'address', 'country', 'state', 'city', 'postcode', 'status']);

        try {
            if (!$out = auth('api')->attempt($credentials)) {
                return response()->json([
                    'error' => 'Invalid Credentials'
                ], 401);
            }
        } catch (JWTException $e) {
            return response()->json([
                'error' => 'Could not get Outlets Datas'
            ], 500);
        }
        $out = new Outlet();
        $out->Outlet_name = $request->name;
        $out->Outlet_Address =  $request->address;
        $out->Country = $request->country;
        $out->State = $request->state;
        $out->City = $request->city;
        $out->Postcode = $request->postcode;
        $out->Status = $request->status;
        $out->save();
        return response()->json([
            'Insert Data' => 'Successfully Inserted !',
        ]);
    }
}
