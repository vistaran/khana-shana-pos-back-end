<?php

namespace App\Http\Controllers;

use App\Outlet;
use App\User;
use App\Users;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function show()
    {
        try {
            $user = Users::join('user_outlet', 'user.id', '=', 'user_outlet.user_id')
                ->join('outlets', 'user_outlet.outlet_id', '=', 'outlets.id')
                ->select(
                    'user_outlet.user_id',
                    'user.first_name',
                    'user.lastname',
                    'user.username',
                    'user.email',
                    'user.password',
                    'user.confirm_password',
                    'user.user_avatar',
                    'user.status',

                    'user_outlet.outlet_id',
                    'outlets.Outlet_name',
                    'outlets.Outlet_name',
                    'outlets.Country',
                    'outlets.State',
                    'outlets.City',
                    'outlets.Status',
                    'outlets.Postcode',
                )->orderBy('user_outlet.user_id')
                ->paginate(10);
            return response()->json([
                'user' => $user,

            ]);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => $e->getMessage() . ' ' . $e->getLine()]);
        }
    }
    public function add(Request $request)
    {
        try {
            $credential = $request->only(['first_name', 'lastname', 'username', 'email', 'password', 'confirm_password', 'user_avatar', 'status']);
            $user = new Users();

            $user->first_name = $request->first_name;
            $user->lastname =  $request->lastname;
            $user->username = $request->username;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->confirm_password = bcrypt($request->confirm_password);
            $user->user_avatar = $request->user_avatar;
            $user->status = $request->status;
            $user->save();
            return response()->json([
                'Insert Data' => 'Successfully Inserted !',
            ]);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => $e->getMessage() . ' ' . $e->getLine()]);
        }
    }
    public function delete($id)
    {
        try {
            Users::find($id)
                ->delete();
            return response()->json([
                'Delete Message' => 'Successfully Deleted !',
            ]);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => $e->getMessage() . ' ' . $e->getLine()]);
        }
    }
    public function edit($id, Request $request)
    {
        try {
            $credential = $request->only(['first_name', 'lastname', 'username', 'email', 'password', 'confirm_password', 'user_avatar', 'status']);
            $user = Users::where('id', $id)
                ->update([
                    'first_name' => $request->first_name,
                    'lastname' => $request->lastname,
                    'username' => $request->username,
                    'email' => $request->email,
                    'password' => bcrypt($request->password),
                    'confirm_password' => bcrypt($request->confirm_password),
                    'user_avatar' => $request->user_avatar,
                    'status' => $request->status,

                ]);
            return response()->json([
                'Update Message' => 'Successfully Updated !',
            ]);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => $e->getMessage() . ' ' . $e->getLine()]);
        }
    }
    public function Search(Request $request)
    {
        $query = $request->input('outlet');
        $data = User::where('first_name', $query)
            ->orWhere('lastname', 'like', '%' . $query . '%')
            ->orWhere('username', 'like', '%' . $query . '%')
            ->orWhere('email', 'like', '%' . $query . '%')
            ->orWhere('password', 'like', '%' . $query . '%')
            ->orWhere('confirm_password', 'like', '%' . $query . '%')
            ->orWhere('user_avatar', 'like', '%' . $query . '%')
            ->orWhere('status', 'like', '%' . $query . '%')
            ->paginate(10);

        return Response()->json(['user' => $data]);
    }
}
