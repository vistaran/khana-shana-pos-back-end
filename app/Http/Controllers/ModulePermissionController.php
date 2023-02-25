<?php

namespace App\Http\Controllers;

use App\AppModules;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Validator;
use DB;



class ModulePermissionController extends Controller
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

            $app_modules =   DB::table('app_modules')
                ->select('*')
                ->get();

            $app_module_permissions = DB::table('app_module_permissions')
                ->select('app_modules.id as module_id', 'app_modules.module_name', 'app_module_permissions.id as permission_id', 'app_module_permissions.permission_name')
                ->join('app_modules', 'app_modules.id', '=', 'app_module_permissions.module_id')
                ->get();


            return response()->json(['app_module_permissions
            ' => $app_module_permissions, 'app_modules
            ' => $app_modules]);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => $e->getMessage() . ' ' . $e->getLine()]);
        }
    }
    //
}
