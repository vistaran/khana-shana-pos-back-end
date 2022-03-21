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
                'inventory_source'
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
            $credential = $request->only(['name', 'address', 'country', 'state', 'city', 'postcode', 'status', 'inventory_source']);
            Outlet::where('id', $id)
                ->update([
                    'Outlet_name' => $request->name,
                    'Outlet_Address' => $request->address,
                    'Country' => $request->country,
                    'State' => $request->state,
                    'City' => $request->city,
                    'Postcode' => $request->postcode,
                    'Status' => $request->status,
                    'inventory_source' => $request->inventory_source,
                ]);
            return response()->json([
                'update message' => 'Successfully Updated !',
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
                'delete message' => 'Successfully Deleted !',
            ]);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => $e->getMessage() . ' ' . $e->getLine()]);
        }
    }
    public function insert(Request $request)
    {
        try {
            $credentials = $request->only(['name', 'address', 'country', 'state', 'city', 'postcode', 'status', 'inventory_source']);
            $outlet = new Outlet();
            $outlet->Outlet_name = $request->name;
            $outlet->Outlet_Address = $request->address;
            $outlet->Country = $request->country;
            $outlet->State = $request->state;
            $outlet->City = $request->city;
            $outlet->Postcode = $request->postcode;
            $outlet->Status = $request->status;
            $outlet->inventory_source = $request->inventory_source;
            $outlet->save();
            return response()->json([
                'insert data' => 'Successfully Inserted !',
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
            'outlets' => $data,
        ]);
    }
    public function show_data($id)
    {
        $outlet = Outlet::where('id', $id)->first();

        return response()->json([
            'show_data' => $outlet,
        ]);
    }
}
