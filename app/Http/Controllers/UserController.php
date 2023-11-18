<?php

namespace App\Http\Controllers;
use App\Models\Users;
use Illuminate\Http\Request;

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

    public function update_user(Request $request)
    {
        $record = Users::find($request->id);

        // Get all data from the request
        $data = $request->all();

        // Update each field dynamically
        foreach ($data as $key => $value) {
            $record->$key = $value;
        }

        $record->save();

        return response()->json(['message' => 'Record updated successfully', 'data' => $record], 200);
    }
}
