<?php

namespace App\Http\Controllers;
use App\Models\Users;
//use Illuminate\Support\Facades\Auth;
use App\Http\Controllers;
use Illuminate\Http\Request;
//use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','register']]);
    }


    function register(Request $req){
        $validator = Validator::make($req->all(), [
            'full_name' => 'required|regex:/^[\pL\s-]+$/u|string',
            'mobile_number' => 'required|numeric',
            'telephone_number' => 'nullable|numeric',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6',
            'address' => 'required|string',
            'gender' => 'required|in:male,female',
            'type_of_user' => 'required|regex:/^[\pL\s-]+$/u|string',
            'status' => 'required|integer|in:0,1', 
            'types_of_existing_donations' => 'nullable|string',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['message' => 'Validation failed', 'errors' => $validator->errors()], 400);
        }
    
        $data = $req->all();
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
        $credentials = $request->only('email', 'password','type_of_user');

        $user = Users::where('email', $credentials['email'])->first();

        if (!$user || !Hash::check($credentials['password'], $user->password)
        ) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Check if the user has the correct type_of_user
        if ($user->type_of_user !== $credentials['type_of_user']) {
            return response()->json(['error' => 'Invalid type of user'], 401);
        }

        $token = JWTAuth::attempt($credentials);
        return $this->respondWithToken($token);
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
