<?php

namespace App\Http\Controllers;

use App\UserRoles;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Validator;


class RolesPermissionController extends Controller
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
            $user_roles = UserRoles::select('user_roles.*')

                // default
                ->when(($query == null), function ($q) {
                    return $q;
                })

                // search by item_name
                ->when(($query !== null), function ($q) use ($query) {
                    return $q->where('role_name', 'like', '%' . $query . '%');
                });

            // default
            if (($limit == null)) {
                return $user_roles->orderBy('id', 'asc')->paginate(10);
            }

            // for dynamic pagination
            if (($limit !== null && $limit <= 500)) {
                return $user_roles->orderBy('id', 'asc')->paginate($limit);
            }

            if (($limit !== null && $limit > 500)) {
                return $user_roles->orderBy('id', 'asc')->paginate(500);
            };
            return response()->json(['User_Roles' => $user_roles]);
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
            $branchdetails = UserRoles::where('id', $id)->first();

            return response()->json(['UserRoles_Details' => $branchdetails]);
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
                'role_name' => 'required'
            ]);
            if ($validator->fails()) {
                return response()->json($validator->errors());
            }
            $table = new UserRoles();
            $table->role_name = $request->role_name;
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
                'role_name' => 'required'
            ]);
            if ($validator->fails()) {
                return response()->json($validator->errors());
            }
            $table = UserRoles::where('id', $id)
                ->update([
                    'role_name' => $request->role_name
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
            UserRoles::find($id)
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
