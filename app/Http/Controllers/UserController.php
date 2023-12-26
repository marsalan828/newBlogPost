<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    //CRUD
    public function showAdmin(Request $request){
        $user = User::find($request->is_admin=='admin');
        if($user->fails()){
            return response()->json(['message'=>'Admin is not found']);
        }else{
            return response()->json($user);
        }
    }

    public function showUsers(Request $request){
        $user = User::find($request->is_admin=='user');
        if($user->fails()){
            return response()->json(['message'=>'Users not found']);
        }else{
            return response()->json($user);
        }
    }

    public function RegisterUser(Request $request){
        $validator = Validator::make($request->all(),[
            'name' => 'required | max:255',
            'email'=> 'required | email | unique:users',
            'password'=>'required | min:8',
            'is_admin'=>'required',
        ]);
        if($validator->fails()){
            return response()->json(['error'=>$validator->errors()]);
        }else{
            $user = new User;
            $user->name=$request->name;
            $user->email=$request->email;
            $user->password=$request->password;
            $user->is_admin=$request->is_admin;
            $user->save();
            if($user->is_admin=='admin'){
                return response()->json(['message'=>'Admin has been registered successfully']);
            }else{
                return response()->json(['message'=>'User has been registered successfully']);
            }
        }
    }

    public function UpdateUser(Request $request){
        if(!auth()->check()){
            return response()->json(['message'=>'user is not logged in']);
        }
        $validator = Validator::make($request->all(),[
            'name' => 'required | max:255',
            'email'=> 'required | email | unique:users',
            'password'=>'required | min:8',
            'is_admin'=>'required',
        ]);
        if($validator->fails()){
            return response()->json(['error'=>$validator->errors()]);
        }else{
            $user = User::find($request->email);
            $user->name=$request->name;
            $user->email=$request->email;
            $user->password=$request->password;
            $user->is_admin=$request->is_admin;
            $user->update();
            if($user->is_admin=='admin'){
                return response()->json(['message'=>'Admin has been updated successfully']);
            }else{
                return response()->json(['message'=>'User has been updated successfully']);
            }
        }
    }
    public function destroyUser(Request $request){
        
        $user = User::find($request->email);
        $user->delete();
        if($user->is_admin=='admin'){
            return response()->json(['message'=>'Admin has been deleted successfully']);
        }else{
            return response()->json(['message'=>'User has been deleted successfully']);
        }
    }


    //LOGIN

    public function login(Request $request){
        $validator=Validator::make($request->all(),[
            'email'=> 'required|email',
            'password'=> 'required',
        ]);
        if($validator->fails()){
            return response()->json(['message'=>'invalid credentials','error'=>$validator->errors()]);
        }else{
            $user = User::find($request->email);
            if(!$user){
                return response()->json(['message'=>'No user found'],404);
            }else{
                $user = Auth::user();
                $accessToken = user()->createToken('TokenLogin')->plainTextToken;
                if($user->is_admin=='admin'){
                    return response()->json(['message'=>'Admin login successful']);
                }else{
                    return response()->json(['message'=>'User login successful']);
                }
            }
        }
    }
}
