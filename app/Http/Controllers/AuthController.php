<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\User;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Validators\PayloadValidator;
use Illuminate\Support\Facades\Response;

class AuthController extends Controller
{


    public function __construct()
    {
        $this->middleware(
            'jwt.verify', ['except' => ['login','autenticated','refresh','logout']]
        );
    }

    
    public function login()
    {
        $credentials = request(['email', 'password']);

        if (!$token = auth()->attempt($credentials)) {            
                return response()->json([
                    'status' => true,
                    'token' => null,                    
                    'message' => 'Verifique su usuario o contraseña',
                    'expires_in' => 0,
                    'data' => []
                ], 401);
        }

        return $this->respondWithToken($token);
    }

    public function me()
    {
        return response()->json(auth()->user());
    }

     public function logout()
    {
        //dd('saliendo');
        try {
        //auth()->logout();
        JWTAuth::invalidate(JWTAuth::getToken());
        return response()->json([
            'status'=>false,
            'message' => 'Successfully logged out',
            'token'=> null,
            'expires_in'=>0],401);
        }
        catch (TokenExpiredException $e)
        {
            return response()->json([
                'status' => false,
                'token' => null,                    
                'message' => 'Token Expired',
                'expires_in' => 0
            ], 401);
        }
        catch (TokenBlackListedException $e)
        {
            return response()->json([
                'status' => false,
                'token' => null,                    
                'message' => 'Token invalid (BlackList)',
                'expires_in' => 0
            ], 401);
        }

    }

    public function refresh()
    {
        $token =  auth()->getToken();                    
        try{
            $token = auth()->refresh($token);
            return response()->json([
                'status' => true,
                'token' => $token,
                'data' => 'bearer',
                'message' => 'Token refresh',
                'expires_in' => auth()->factory()->getTTL() * 60
            ],200);
        } 
        catch (TokenExpiredException $e)
        {
            return response()->json([
                'status' => false,
                'token' => null,                    
                'message' => 'Token Expired',
                'expires_in' => 0
            ], 401);
        }
        catch (TokenBlackListedException $e)
        {
            return response()->json([
                'status' => false,
                'token' => null,                    
                'message' => 'Token invalid (BlackList)',
                'expires_in' => 0
            ], 401);
        }

    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'status' => true,
            'token' => $token,           
            'message' => 'Acceso autorizado',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }

    protected function autenticated(){
        try {                   
           JWTAuth::parseToken()->authenticate();
                return response()->json([
                    'status' => true,                                        
                    'message' => 'Acceso autorizado',                    
                ],200);                         
        } catch (JWTException $e) {            
            return response()->json([
                'status' => true,
                'token' =>null,
                'data' => [],
                'message' => 'Acceso No autorizado',
                'expires_in' => 0
            ],401);            
        }
    }

    public function register(Request $request)
    {
    	//Validate data
        $data = $request->only('nombres', 'email', 'password','dni');

        /*
        $validator = Validator::make($data, [
            'nombres' => 'required|string',
            'dni' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6|max:50'
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }
*/
        //Request is valid, create new user
        $user = User::create([
            'nombres' => $request->nombres,
            'dni' => $request->dni,
        	'email' => $request->email,
        	'password' => bcrypt($request->password)
        ]);
        

        //User created, return success response
        return response()->json([
            'success' => true,
            'message' => 'User created successfully',
            'data' => $user
        ], 200);
    }
}
