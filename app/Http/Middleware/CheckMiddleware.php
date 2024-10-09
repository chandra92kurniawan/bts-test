<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class CheckMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $authorizationHeader = $request->header('Authorization');

        if ($authorizationHeader) {
            $parts = explode(' ', $authorizationHeader);

            if (count($parts) === 2 && $parts[0] === 'Bearer') {
                $token = $parts[1];
                try {
                    
                    $key=env('JWT_SECRET');
                    $decoded = JWT::decode($token, new Key($key, 'HS256'));
                    $GLOBALS['user_id']=$decoded->data->userId;
                    // $request->attributes->set('decoded_token', $decoded);
                    return $next($request);
                } catch (\Exception $e) {
                    // Tangani error, misalnya dengan mengembalikan response unauthorized
                    return response()->json(['message' => 'Unauthorized', 'error' => $e->getMessage()], 401);
                }
                
                $decoded = JWT::decode($token, $key, 'HS256');
                dd($decoded);
                return $next($request);
            }
        }
        return response()->json(['message' => 'Access denied'], 403);
    }
}
