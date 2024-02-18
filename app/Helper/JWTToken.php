<?php
namespace App\Helper;

use Firebase\JWT\JWT;

class JWTToken {
   public static function CreateToken($userEmail):string{
        $key = env('JWT_KEY');
        $payload = [
            'issuer' => 'laravel-token',
            'iat' => time(),
            'expires' => time() + 60 * 60,
            'userEmail' => $userEmail
        ];
        return JWT::encode($payload,$key,'HS256');
    }
   public static function CreateTokenForSetPassword($userEmail):string{
        $key = env('JWT_KEY');
        $payload = [
            'issuer' => 'laravel-token',
            'iat' => time(),
            'expires' => time() + 60 * 20,
            'userEmail' => $userEmail
        ];
        return JWT::encode($payload,$key,'HS256');
    }
    function VerifyToken(){

        try{
            $key = env('JWT_KEY ');
            $decode = JWT::decode($token, new $key($key, 'HS256'));
            return $decode->userEmail;
        }
        catch (Exception $e) {
            return 'Unauthorized';
        }


    }

}
