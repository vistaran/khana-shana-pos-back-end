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
    public function show()
    {
        try {
            $restauranttables = RestaurantTables::orderBy('id', 'desc')
                ->paginate(10);
            return response()->json([
                'Restaurant_Tables' => $restauranttables
            ]);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => $e->getMessage() . ' ' . $e->getLine()]);
        }
    }

    public function showDetail($id)
    {
        try {
            $restauranttables = RestaurantTables::where('id', $id)->first();

            return response()->json(['Restaurant_Table_Details' => $restauranttables]);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => $e->getMessage() . ' ' . $e->getLine()]);
        }
    }
 
    
    public function insert(Request $request)
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
            $table->save();
            return response()->json([
                'Message' => 'Successfully Inserted !',
            ]);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => $e->getMessage() . ' ' . $e->getLine()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function edit($id, Request $request)
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
                    'res_table_name' =>$request->table_name
                ]);
            return response()->json([
                'Message' => 'Successfully Updated !',
            ]);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => $e->getMessage() . ' ' . $e->getLine()]);
        }
    }

    public function delete($id)
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

    //Search
    public function search(Request $request)
    {
        $query = $request->input('query');
        $data = RestaurantTables::where('id', $query)
            ->orWhere('res_table_name', 'like', '%' . $query . '%')
            ->orWhere('res_table_number', $query)
            ->paginate(10);

        return response()->json([
            'Restaurant_Tables' => $data,
        ]);
    }
}
