<?php

namespace App\Http\Controllers;
use App\Models\Users;
//use Illuminate\Support\Facades\Auth;
use App\Http\Controllers;
use Illuminate\Http\Request;
//use App\Models\User;
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
        $user->telephone_number=$data['telephone_number'];
        $user->email= $data['email'];
        $user->password= Hash::make($data['password']);
        $user->address=$data['address'];
        $user->gender=$data['gender'];
        $user->type_of_user=$data['type_of_user'];
        $user->status=$data['status'];
        $user->types_of_existing_donations=$data['types_of_existing_donations'];
        $user->save();

        return response()->json("success", 200);
    }

  

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        
        $user = Users::where('email', $credentials['email'])->first();

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        
        $token = JWTAuth::attempt($credentials);
        return $this->respondWithToken($token);
        //return view('welcome', $token);
    }
    public function direct()
    {
        //$user = response()->json(auth()->user());

        $type = response()->json(auth()->user()->type_of_user);
        //return response()->json("user1");
           if($type==response()->json("user")){
               return view('welcome');
               
           }
          else{
              return view('index');
          }

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
    

    

    public function refresh()
    {
        return $this->respondWithToken(JWTAuth::refresh(JWTAuth::getToken()));
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => JWTAuth::factory()->getTTL() * 600
        ]);
    }
}
