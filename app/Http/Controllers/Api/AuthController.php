<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Auth;
use Validator;
use App\Models\User;


class AuthController extends Controller
{
    public function register(Request $request)
    {
        try {
            $validator = Validator::make($request->all(),[
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8'
            ]);
    
            if($validator->fails()){
                return response()->json($validator->errors());       
            }
    
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);
    
            $token = $user->createToken('auth_token')->plainTextToken;
            
            return response()->json([
                'success' => true,
                'message' => 'Register successfully',
                'data' => $user,
                'access_token' => $token, 
                'token_type' => 'Bearer'
            ], 200);
        } catch (\Exception $e) {
            throw new HttpException(500, $e->getMessage());
        }
    }

    public function login(Request $request)
    {
        try{
            if (!Auth::attempt($request->only('email', 'password')))
            {
                return response()
                    ->json(['message' => 'Unauthorized'], 401);
            }

            $user = User::where('email', $request['email'])->firstOrFail();

            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'success' => true,
                'message' => 'Login successfully - Hi User (' . $user->name . ')',
                'data' => $user,
                'access_token' => $token, 
                'token_type' => 'Bearer', 
            ], 200);
        }catch (\Exception $e) {
            throw new HttpException(500, $e->getMessage());
        }
    }

    public function logout()
    {
        try {
            auth()->user()->tokens()->delete();
            return response()->json([
                'success' => true,
                'message' => 'user have successfully logged out and the token was successfully deleted'
            ], 200);
        }
        catch (\Exception $e) {
            throw new HttpException(500, $e->getMessage());
        }
    }

    public function getCurrentUser(Request $request)
    {
        try {
            $user = auth()->user();
            return response()->json([
                'success' => true,
                'message' => 'get current user (' . $user->name . ') successfully',
                'data' => $user,
            ], 200);
        } catch (\Exception $e) {
            throw new HttpException(500, $e->getMessage());
        }
    }

    public function updateUser(Request $request)
    {
        try {
            $request -> validate([
                'name' => 'required',
                'email' => 'required',
            ]);
    
            $user = auth()->user();
    
            $user->name = $request->name;
            $user->email = $request->email;
            $user->save();
    
            return response()->json([
                'success' => true,
                'message' => 'user (' . $user->name . ') updated successfully',
                'data' => $user
            ], 200);
        } catch (\Exception $e) {
            throw new HttpException(500, $e->getMessage());
        }
    }
}