<?php

namespace App\Http\Middleware;

use Closure;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Crypt;

class JWT
{    
    public function handle($request, Closure $next, $guard = null)
    {
        if(!$request->header('Authorization')) {
            return response()->json(['message' => 'token_not_sended'], 400);
        }

        try {
            $token = preg_split('/ /',$request->header('Authorization'))[1];
            
            $apy = JWTAuth::getPayload($token)->toArray();
            
            try {
                $decrypted = Crypt::decrypt($apy["swordfish"]);   
                
                $request->attributes->set('decrypted', $decrypted);

                return $next($request);
                
            } catch (Illuminate\Contracts\Encryption\DecryptException $e) {
                throw $e;
            }   

        }catch(\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return response()->json(['message' => 'token_expired'], $e->getStatusCode());            
        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return response()->json(['message' => 'token_invalid'], $e->getStatusCode());
        }catch(\Tymon\JWTAuth\Exceptions\JWTException $e){
            return response()->json(['message' => 'token_invalid ws'], $e->getStatusCode());
        }
    }
}
