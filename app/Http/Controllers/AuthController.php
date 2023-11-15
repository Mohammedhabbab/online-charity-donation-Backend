<?php

namespace App\Http\Controllers;
use App\Models\Users;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;


class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','register']]);
    }
    function register(Request $req){
        $data = $req->all();
        // if($data["utype"]==1){
        $user = new Users();
        
        $user->full_name = $data['full_name'];
        $user->mobile_number=$data['mobile_number'];
        $user->email = $data['email'];
        $user->password = Hash::make($data['password']);
        $user->address =$data['address'];
        $user->id_card =$data['id_card'];
        $user->status = $data['status'];
        $user->save();
        
        // else{
        //     $user = new User2();
        //     $user->name = $data['name'];
        //     $user->email = $data['email'];
        //     $user->password = Hash::make($data['password']);
        //     $user->save();
        // }
           

        return response()->json("success",200);
    }

    // public function login()
    // {
    //     $credentials = request(['email', 'password']);

    //     if (!$token = JWTAuth::attempt($credentials)) {
    //         return response()->json(['error' => 'Unauthorized'], 401);
    //     }

    //     return $this->respondWithToken($token);
    // }
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        
        $user = Users::where('email', $credentials['email'])->first();

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        $token = JWTAuth::attempt($credentials);
        return $this->respondWithToken($token);
    }
    public function me()
    {
        return response()->json(auth()->user());
    }

    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }
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

    // function update_user(Request $req ){
    //     $user=User::find($req->id);
    //     $user->full_name=$req->full_name;
    //     $user->gender=$req->gender;
    //     $user->mobile_number=$req->mobile_number;
    //     $user->email=$req->email;
    //     $user->password=$req->password;
    //     $user->address=$req->address;
    //     $user->id_card=$req->id_card;
    //     $user->status=$req->status;
    //     $result=$user->save();
    //     if($result){
    //     return  ["result"=>"data has update"];
    //     }
    //     else{
    //         return["result"=>"update data has failed"];
    //     }
    // }
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

    public function refresh()
    {
        return $this->respondWithToken(JWTAuth::refresh(JWTAuth::getToken()));
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => JWTAuth::factory()->getTTL() * 60
        ]);
    }
}
