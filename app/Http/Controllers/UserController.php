<?php

namespace App\Http\Controllers;

use App\Outlet;
use App\UserOutlet;
    use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    //Show Product Datas
    public function show()
    {
        try {
            $user = User::join('user_outlet', 'user.id', '=', 'user_outlet.user_id', 'left')
                ->join('outlets', 'user_outlet.outlet_id', '=', 'outlets.id', 'left')
                ->select(
                    'user.id',
                    'user_outlet.user_id',
                    'user.user_avatar',
                    'user.username',
                    'user.email',
                    'user.status',
                    'user.created_at'
                )->orderBy('user.id', 'desc')
                ->paginate(10);
            return response()->json([
                'user' => $user,

            ]);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => $e->getMessage() . ' ' . $e->getLine()]);
        }
    }
    //Insert Product
    public function add(Request $request)
    {
        try {
            $credential = $request->only(['first_name', 'lastname', 'username', 'email', 'password', 'confirm_password', 'user_avatar', 'status']);
            $user = new User();
            $user_outlet = new UserOutlet();

            $user->first_name = $request->first_name;
            $user->lastname = $request->lastname;
            $user->username = $request->username;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->confirm_password = bcrypt($request->confirm_password);
            $user->phone_no = $request->phone_no;
            $user->user_avatar = $request->user_avatar;
            $user->status = $request->status;
            $user->save();

            // dd($outlet_id);

            $user_outlet->user_id = $user->id;
            $user_outlet->outlet_id = $request->outlet;
            $user_outlet->save();

            // $outlet_id = $user_outlet->where( 'user.outlet_name', $request->outlet_name )->first()->id;
            // $user_outlet-> outlet_id = $request->$outlet_id;

            return response()->json([
                'insert data' => 'Successfully Inserted !',
            ]);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => $e->getMessage() . ' ' . $e->getLine()]);
        }
    }
    //Edit Product
    public function edit($id, Request $request)
    {
        try {
            $credential = $request->only(['first_name', 'lastname', 'username', 'email', 'password', 'confirm_password', 'user_avatar', 'status']);
            Users::where('id', $id)
                ->update([
                    'first_name' => $request->first_name,
                    'lastname' => $request->lastname,
                    'username' => $request->username,
                    'email' => $request->email,
                    'password' => bcrypt($request->password),
                    'confirm_password' => bcrypt($request->confirm_password),
                    'outlet_name' => $request->outlet_name,
                    'outlet_status' => $request->outlet_status,
                    'phone_no' => $request->phone_no,
                    'user_avatar' => $request->user_avatar,
                    'status' => $request->status,

                ]);
            return response()->json([
                'update message' => 'Successfully Updated !',
            ]);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => $e->getMessage() . ' ' . $e->getLine()]);
        }
    }
    //Delete Product
    public function delete($id)
    {
        try {
            User::find($id)
                ->delete();
            return response()->json([
                'delete message' => 'Successfully Deleted !',
            ]);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => $e->getMessage() . ' ' . $e->getLine()]);
        }
    }
    //Search Product
    public function search(Request $request)
    {
        $query = $request->input('query');
        $data = User::join('user_outlet', 'user.id', '=', 'user_outlet.user_id')
            ->join('outlets', 'user_outlet.outlet_id', '=', 'outlets.id')
            ->where('user_outlet.user_id', $query)
            ->orWhere('user.username', 'like', '%' . $query . '%')
            ->orWhere('user.email', 'like', '%' . $query . '%')
            ->orWhere('outlets.Outlet_name', 'like', '%' . $query . '%')
            ->orWhere('user.email', 'like', '%' . $query . '%')
            ->select(
                'user_outlet.user_id',
                'user.user_avatar',
                'user.username',
                'user.email',
                'user.status',
                'outlets.Outlet_name',
                'user.created_at'
            )
            ->paginate(10);

        return response()->json([
            'users' => $data,
        ]);
    }
    //Show Product Datas using ID
    public function show_data($id)
    {
        $user = User::where('id', $id)->first();

        return response()->json([
            'show_data' => $user,
        ]);
    }
}