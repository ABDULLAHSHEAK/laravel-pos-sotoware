<?php

namespace App\Http\Controllers;

use App\Helper\JWTToken;
use App\Mail\OTPMail;
use Illuminate\Http\Request;
use App\Models\User;
use Exception;
use PhpParser\Node\Stmt\TryCatch;

class UserController extends Controller
{
    function UserReg(Request $req){

        try {
            User::create([
                'firstName' => $req->input('firstName'),
                'lastName' => $req->input('lastName'),
                'email' => $req->input('email'),
                'mobile' => $req->input('mobile'),
                'password' => $req->input('password'),
            ]);
            return response()->json([
                'status' => 'success',
                'massage' => 'User Registraion successfully'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'Failed',
                'massage' => 'User Registraion Failed'
                //'massage' => $e->getMessage(), //for check error message
            ]);
        }


    }

    function UserLogin(Request $req){
       $count = User::where('email', '=', $req->input('email'))
            ->where('password', '=', $req->input('password'))
            ->count();

            if($count == 1){
                $token = JWTToken::CreateToken($req->input('email'));
                return response()->json([
                    'status' => 'success',
                    'massage' => 'User Login Success',
                    'Token' => $token
                ],status: 200);
            }else{
            return response()->json([
                'status' => 'failed',
                'massage' => 'unauthorized',
            ]);
            }
    }

    function SendOTPCode(Request $req){
        $email = $req->input('email');
        $otp = rand(1000, 9999);
        $count = User::where('email','=', $email)->count();

        if($count == 0){
            // Send OTP
            Mail::to($email)->send(new OTPMail($otp));
            // OTP  code update on table
            User::where('email','=', $email)->update(['otp' => $otp]);

            return response()->json([
                'status' => 'success',
                'massage' => '4 Digits OTP Code Has Been Send Your Email Address',
                //'massage' => $e->getMessage(), //for check error message
            ]);
        }else{
            return response()->json([
                'status' => 'Failed',
                'massage' => 'Unauthorized',
                //'massage' => $e->getMessage(), //for check error message
            ]);
        }
    }

    function VerifyOTP(Request $req){
        $email = $req->input('email');
        $otp = $req->input('otp');
        $count = User::where('email', '=', $email)
            ->where('otp', '=', $otp)->count();

            if($count == 1){
            // Database otp update
            User::where('email', '=', $email)->update(['otp' => 0]);
            // password token issue
            $token = JWTToken::CreateTokenForSetPassword($req->input('email'));
            return response()->json([
                'status' => 'success',
                'massage' => 'OTP Verification Success',
                'Token' => $token
            ], status: 200);
            }else{
            return response()->json([
                'status' => 'Failed',
                'massage' => 'OTP Verify  Failed'
                //'massage' => $e->getMessage(), //for check error message
            ]);
            }
    }
}
