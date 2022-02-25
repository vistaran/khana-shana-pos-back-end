<?php

namespace App\Http\Controllers;

use App\Outlet;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class OutletController extends Controller
{
    public function show()
    {
        try {
            $outlet = Outlet::select(
                'id',
                'Outlet_name',
                'inventory_source',
                'created_at',
                'Status',
            )->orderBy('id')
                ->paginate(10);
            return response()->json([
                'outlets' => $outlet,

            ]);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => $e->getMessage() . ' ' . $e->getLine()]);
        }
    }
    public function edit($id, Request $request)
    {

        try {
            $credential = $request->only(['name', 'address', 'country', 'state', 'city', 'postcode', 'status']);
            $outlet = Outlet::where('id', $id)
                ->update([
                    'Outlet_name' => $request->name,
                    'Outlet_Address' => $request->address,
                    'Country' => $request->country,
                    'State' => $request->state,
                    'City' => $request->city,
                    'Postcode' => $request->postcode,
                    'Status' => $request->status,
                ]);
            return response()->json([
                'Update Message' => 'Successfully Updated !',
            ]);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => $e->getMessage() . ' ' . $e->getLine()]);
        }
    }
    public function delete($id)
    {
        try {
            Outlet::find($id)
                ->delete();
            return response()->json([
                'Delete Message' => 'Successfully Deleted !',
            ]);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => $e->getMessage() . ' ' . $e->getLine()]);
        }
    }
    public function insert(Request $request)
    {
        try {
            $credentials = $request->only(['name', 'address', 'country', 'state', 'city', 'postcode', 'status']);
            $out = new Outlet();
            $out->Outlet_name = $request->name;
            $out->Outlet_Address = $request->address;
            $out->Country = $request->country;
            $out->State = $request->state;
            $out->City = $request->city;
            $out->Postcode = $request->postcode;
            $out->Status = $request->status;
            $out->inventory_source = $request->inventory_source;
            $out->save();
            return response()->json([
                'Insert Data' => 'Successfully Inserted !',
            ]);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => $e->getMessage() . ' ' . $e->getLine()]);
        }
    }
    public function search(Request $request)
    {
        $query = $request->input('query');
        $data = Outlet::where('id', $query)
            ->orWhere('Outlet_name', 'like', '%' . $query . '%')
            ->orWhere('Country', 'like', '%' . $query . '%')
            ->orWhere('State', 'like', '%' . $query . '%')
            ->orWhere('City', 'like', $query . '%')
            ->orWhere('Postcode', $query)
            ->paginate(10);

        return response()->json([
            'Outlets' => $data,
        ]);
    }
}
