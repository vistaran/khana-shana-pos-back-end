<?php

namespace App\Http\Controllers;

use App\RestaurantTables;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Validator;


class TablesManagementController extends Controller
{
    // Show all details
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
            $restauranttables = RestaurantTables::select('restaurant_tables.*')

                // default
                ->when(($query == null), function ($q) {
                    return $q;
                })

                // search by item_name
                ->when(($query !== null), function ($q) use ($query) {
                    return $q->where('res_table_number', $query)
                        ->orWhere('res_table_name', 'like', '%' . $query . '%');
                });

            // default
            if (($limit == null)) {
                return $restauranttables->orderBy('id', 'desc')->paginate(10);
            }

            // for dynamic pagination
            if (($limit !== null && $limit <= 500)) {
                return $restauranttables->orderBy('id', 'desc')->paginate($limit);
            }

            if (($limit !== null && $limit > 500)) {
                return $restauranttables->orderBy('id', 'desc')->paginate(500);
            };
            return response()->json(['Restaurant_Tables' => $restauranttables]);
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
            $restauranttables = RestaurantTables::where('id', $id)->first();

            return response()->json(['Restaurant_Table_Details' => $restauranttables]);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => $e->getMessage() . ' ' . $e->getLine()]);
        }
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
            $validator = Validator::make($request->all(), [
                'table_number' => 'required',
                'table_name' => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json($validator->errors());
            }
            $table = new RestaurantTables();
            $table->res_table_number = $request->table_number;
            $table->res_table_name =  $request->table_name;
            $table->is_table_active = $request->table_active;
            $table->is_table_occupied =  $request->table_occupied;
            $table->save();
            return response()->json([
                'Message' => 'Successfully Inserted !',
            ]);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => $e->getMessage() . ' ' . $e->getLine()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request)
    {

        try {
            $validator = Validator::make($request->all(), [
                'table_number' => 'required',
                'table_name' => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json($validator->errors());
            }
            $table = RestaurantTables::where('id', $id)
                ->update([
                    'res_table_number' => $request->table_number,
                    'res_table_name' => $request->table_name,
                    'is_table_active' => $request->table_active,
                    'is_table_occupied' =>  $request->table_occupied
                ]);
            return response()->json([
                'Message' => 'Successfully Updated !',
            ]);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => $e->getMessage() . ' ' . $e->getLine()]);
        }
    }

    public function markAsUnoccupied($id, Request $request)
    {
        try {
            // $validator = Validator::make($request->all(), [
            //     'table_number' => 'required',
            //     'table_name' => 'required',
            // ]);
            // if ($validator->fails()) {
            //     return response()->json($validator->errors());
            // }
            $table = RestaurantTables::where('res_table_number', $id)
                ->update([
                    'res_table_name' => $request->table_name,
                    'is_table_occupied' =>  $request->table_occupied
                ]);
            return response()->json([
                'Message' => 'Successfully Updated !',
            ]);
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
            RestaurantTables::find($id)
                ->delete();
            return response()->json([
                'Message' => 'Successfully Deleted !',
            ]);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => $e->getMessage() . ' ' . $e->getLine()]);
        }
    }
}
