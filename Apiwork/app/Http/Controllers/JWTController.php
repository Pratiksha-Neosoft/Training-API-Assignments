<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
class JWTController extends Controller
{
    public function register(Request $req){
        $validate=Validator::make($req->all(),[
            'name'=>'required|string',
            'email'=>'required|string|email|unique:users',
            'password'=>'required|string|min:8'
        ]);
        if($validate->fails()){
            return response()->json($validate->errors());
        }
        else{
            $user=User::create([
                'name'=>$req->name,
                'email'=>$req->email,
                'password'=>Hash::make($req->password)
            ]);
            return response()->json([
                'message'=>'user created',
                'user'=>$user
            ],201);
        }
    }
    public function login(Request $req){
        $validate=Validator::make($req->all(),[
            'email'=>'required|string|email',
            'password'=>'required|string|min:8'
        ]);
        if($validate->fails()){
            return response()->json($validate->errors());
        }
        else{
            if(!$token=auth()->attempt($validate->validated())){
                return response()->json(['error'=>'unauthorised'],401);
            }
            else
            return $this->responseWithToken($token);
        }
    }
    public function logout(){
        auth::logout();
        return response()->json(['message'=>'logout successfully!']);
    }
    public function responseWithToken($token){
        return response()->json([
            'access_token'=>$token,
            'token_type'=>"bearer",
            'expires_in'=>auth()->factory()->getTTL()*60
        ]);
    }
    public function profile(){
        return response()->json(auth()->user());
    }
    public function refresh(){
        return $this->responseWithToken(auth()->refresh());
    }
}