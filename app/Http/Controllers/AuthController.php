<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Users;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterRequest;
use Firebase\JWT\JWT;

class AuthController extends Controller
{
    //
    public function register(Request $request){
        // $validatedData = $request->validated();

        $users=new Users();
        $users->email=$request->email;
        $users->username=$request->username;
        $users->password=Hash::make($request->password);
        $users->save();

        return response()->json([
            'message' => 'User registered successfully',
            'data'=>[]
        ], 201);
    }

    public function login(Request $request){

        $password=$request->password;
        $username=$request->username;

        $existUser=Users::where('username',$username)->first();
        if($existUser && Hash::check($password, $existUser->password)){
            $payload = [
                // 'iss' => "http://example.com", // Issuer
                // 'aud' => "http://example.org", // Audience
                'iat' => time(),               // Issued at
                'nbf' => time(),               // Not before
                'exp' => time() + 3600,        // Expiration
                'data' => [
                    'userId' => $existUser->id,
                ]
            ];
            $jwt = JWT::encode($payload, env('JWT_SECRET'), 'HS256');
            $message="Berhasil login";
            $data=[
                'token'=>$jwt
            ];
            $code=201;
        }else{
            $message="Otentikasi gagal";
            $data=null;
            $code=401;
        }

        return response()->json([
            'message' => $message,
            'data'=>$data
        ], $code);

        // $payload = [
        //     // 'iss' => "http://example.com", // Issuer
        //     // 'aud' => "http://example.org", // Audience
        //     'iat' => time(),               // Issued at
        //     'nbf' => time(),               // Not before
        //     'exp' => time() + 3600,        // Expiration
        //     'data' => [
        //         'userId' => 1,
        //         'email' => 'user@example.com'
        //     ]
        // ];
    
        // $jwt = JWT::encode($payload, env('JWT_SECRET'), 'HS256');

        // try {
        //     $decoded = JWT::decode($token, 'your-secret-key', ['HS256']);
        //     return $decoded;
        // } catch (\Exception $e) {
        //     return false;
        // }
    }
}
