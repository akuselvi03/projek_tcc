<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $registrationData = $request->all();
        $validate = Validator::make($registrationData, [
            'name' => 'required|max:60',
            'email' => 'required|email:rfc,dns|unique:users',
            'password' => 'required',
        ]);
        if($validate->fails())
        {
            return response ([
                'message' => $validate->errors()
            ], 400);
        }

        $registrationData['password'] = bcrypt($request->password);
        $user = User::create($registrationData);
        return response ([
            'message' => 'Register Sukses',
            'user' => $user
        ],200);
    }

    public function login(Request $request)
    {
        $loginData = $request->all();
        $validate = Validator::make($loginData, [
            'email' => 'required|email:rfc,dns',
            'password' => 'required'
        ]);

        if($validate->fails())
            return response(['message' => $validate->errors()], 400);
        
        if(!Auth::attempt($loginData))
            return response(['message' => 'Invalid Credentials'], 401);

        $user = Auth::user();
        $token = $user->createToken('Authentication Token')->accessToken;

        return response([
            'message' => 'Authenticated',
            'user' => $user,
            'token_type' => 'Bearer',
            'access_token' => $token
        ]);
    }

        //function untuk profil user
    public function getUser($id)
    {
        $user = User::find($id);
        if(!is_null($user)) {
            return response([
                'message' => 'Retrieve User Success',
                'data' => $user
            ], 200);
        }

        return response([
            'message' => 'User Not Found',
            'data' => null
        ], 404);
    }

    public function index()
    {
        // untuk show data resto
        $user = user::all();

        if(count($user) > 0)
        {
            return response([
                'message' => 'Retrieve All restoran Success',
                'data' => $user
            ], 200);
        }

        return response([
            'message' => 'Empty',
            'data' => null
        ], 400);
    }

    public function update(Request $request, $id)
    {
        //untuk mengubah 1 data umkm
        $user = user::find($id);
        if(is_null($user))
        {
            return response([
                'message' => 'Restoran Not Found',
                'data' => null
            ], 404);
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData, [
            'name' => 'required|max:60',
            'email' => 'required',
            'password' => 'required',
        ]);

        if($validate->fails())
        {
            return response([
                'message' => $validate->errors()
            ], 400);
        }

        $user->name = $updateData['name'];
        $user->email = $updateData['email'];
        $updateData['password'] = bcrypt($request->password);
        $user->password = $updateData['password'];

        if($user->save())
        {
            return response([
                'message' => 'Update Restoran Success',
                'data' => $user
            ], 200);
        }

        return response([
            'message' => 'Update Restoran Failed',
            'data' => null
        ], 400);
    }

    public function destroy($id)
    {
        // untuk menghapus data
        $user = user::find($id);

        if(is_null($user)) {
            return response([
                'message' => 'Restoran Not Found',
                'data' => null
            ], 404);
        }

        if($user->delete())
        {
            return response ([
                'message' => 'Delete Restoran Success',
                'data' => $user
            ], 200);
        }

        return response ([
            'message' => 'Delete Restoran Failed',
            'data' => null,
        ], 400);
    }
}
