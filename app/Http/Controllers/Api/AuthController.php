<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Support\Facades\Validator;
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
                return response()->json([
                    "success" => false,
                    "message" => $validator->errors(),
                ], 400);       
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
                    ->json([
                        'success' => false,
                        'message' => 'Incorrect email or password'
                    ], 401);
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
            $user = Auth::user();
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
            $validator = Validator::make($request->all(),[
                'name' => 'required',
                'email' => 'required',
            ]);

            if($validator->fails()){
                return response()->json([
                    "success" => false,
                    "message" => $validator->errors(),
                ], 400);       
            }
    
            $user = Auth::user();
    
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