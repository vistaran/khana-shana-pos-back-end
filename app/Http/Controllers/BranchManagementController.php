<?php

namespace App\Http\Controllers;

use App\Branch;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Validator;

class BranchManagementController extends Controller
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
            $branches = Branch::select('branches.*')

                // default
                ->when(($query == null), function ($q) {
                    return $q;
                })

                // search by item_name
                ->when(($query !== null), function ($q) use ($query) {
                    return $q->where('branch_name', 'like', '%' . $query . '%');
                });

            // default
            if (($limit == null)) {
                return $branches->orderBy('id', 'desc')->paginate(10);
            }

            // for dynamic pagination
            if (($limit !== null && $limit <= 500)) {
                return $branches->orderBy('id', 'desc')->paginate($limit);
            }

            if (($limit !== null && $limit > 500)) {
                return $branches->orderBy('id', 'desc')->paginate(500);
            };
            return response()->json(['Restaurant_Tables' => $branches]);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => $e->getMessage() . ' ' . $e->getLine()]);
        }
    }
    //

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $branchdetails = Branch::where('id', $id)->first();

            return response()->json(['Branch_Details' => $branchdetails]);
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
                'branch_name' => 'required',
                'address_line_1' => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json($validator->errors());
            }
            $table = new Branch();
            $table->branch_name = $request->branch_name;
            $table->address_line_1 =  $request->address_line_1;
            $table->address_line_2 = $request->address_line_2;
            $table->address_line_3 = $request->address_line_3;
            $table->city = $request->city;
            $table->state = $request->state;
            $table->country = $request->country;
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
                'branch_name' => 'required',
                'address_line_1' => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json($validator->errors());
            }
            $table = Branch::where('id', $id)
                ->update([
                    'branch_name' => $request->branch_name,
                    'address_line_1' =>  $request->address_line_1,
                    'address_line_2' => $request->address_line_2,
                    'address_line_3' => $request->address_line_3,
                    'city' => $request->city,
                    'state' => $request->state,
                    'country' => $request->country,
                    'is_branch_active' => $request->is_branch_active
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
            Branch::find($id)
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
