<?php

namespace App\Http\Controllers;

use App\Users;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function add(Request $request)
    {
        $credential = $request->only(['first_name', 'lastname', 'username', 'email', 'password', 'confirm_password', 'user_avatar', 'outlet_name', 'status']);
        $user = new Users();

        $user->first_name = $request->first_name;
        $user->lastname =  $request->lastname;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->confirm_password = bcrypt($request->confirm_password);
        $user->user_avatar = $request->user_avatar;
        $user->outlet_name = $request->outlet_name;
        $user->status = $request->status;
        $user->save();
        return response()->json([
            'Insert Data' => 'Successfully Inserted !',
        ]);
    }
    public function delete($id)
    {
        Users::find($id)
            ->delete();
        return response()->json([
            'Delete Message' => 'Successfully Deleted !',
        ]);
    }
    public function edit($id, Request $request)
    {
        $credential = $request->only(['first_name', 'lastname', 'username', 'email', 'password', 'confirm_password', 'user_avatar', 'outlet_name', 'status']);
        $user = Users::where('id', $id)
            ->update([
                'first_name' => $request->first_name,
                'lastname' => $request->lastname,
                'username' => $request->username,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'confirm_password' => bcrypt($request->confirm_password),
                'user_avatar' => $request->user_avatar,
                'outlet_name' => $request->outlet_name,
                'status' => $request->status,

            ]);
        return response()->json([
            'Update Message' => 'Successfully Updated !',
        ]);
    }
}
