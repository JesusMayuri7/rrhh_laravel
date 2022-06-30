<?php

namespace App\Http\Middleware;

use Closure;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class JwtMiddleware extends BaseMiddleware
{

    public function handle($request, Closure $next)
    {
        try {
           // $headers = apache_request_headers();
   

          //  dd($headers);
           // if($headers['authorization'])
           // $request->headers->set('authorization', $headers['authorization']);
            $user = JWTAuth::parseToken()->authenticate();
        } 
        catch (JWTException $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){
                return response()->json([
                    'status' => false,
                    'token'=> null,  
                    'data' => [],                     
                    'message' => 'Token is Invalid',
                ],401);
            }
            else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){               
                    return response()->json([
                        'status'=> false,
                        'token'=> null,  
                        'data' => [],                      
                        'message' => 'token_expired',
                        
                    ], 401);
                }
              
            
            else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenBlacklistedException){
                    return response()->json([
                        'status'=> false,
                        'token'=> null,     
                        'data' => [],                   
                        'message' => 'token blaclisted',
                    ], 401);
                }            
            else{
                return response()->json([
                    'message' => "Authorization Token not found $e",
                    'data' => [],
                    'status' => false,                    
                ],401);
            }     
        }
        catch(Exceptiom $e) {
            return response()->json([
            'status' => false,
            'status' => 'A Token valid is required',
            'data' => [],
        ],401);
        }

        return $next($request);
    }

}
