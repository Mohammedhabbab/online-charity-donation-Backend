<?php

namespace App\Http\Controllers;
use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    function delete_user($id){

        $user = Users::find($id);
        $result=$user->delete();
        if($result){
        return ["result"=>"record has been deleted".$id];
    }
    else{
        return ["result"=>"delete has failed"];
    }
  
    }

    public function update_user(Request $request, $id)

    {
        dd(123);
    $record = Users::find($id);

    $data = $request->all();

    foreach ($data as $key => $value) {
        if ($key !== 'password') {
            $record->$key = $value;
            
        }
        return ["result"=>"change password has failed"];
    }

    $record->save();

    return response()->json(['message' => 'Record updated successfully', 'data' => $record], 200);
}
    public function changePassword(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'current_password' => 'required',
            'new_password' => 'required|min:6',
        ]);

        $user = Users::find($request->input('user_id'));

        // Verify the current password
        if (!Hash::check($request->input('current_password'), $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Incorrect current password',
            ], 400);
        }

        // Change the password
        $user->password = Hash::make($request->input('new_password'));
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Password changed successfully',
        ]);
    }
}
