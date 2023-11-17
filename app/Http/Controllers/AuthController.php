<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // membuat fitur register
    public function register(Request $request)
    {
        // menangkap inputan
        $input = [
            'name' => $request->name,
            'email'=> $request->email,
            'password'=> Hash::make($request->password),
        ];

        // menginsert data ke table Userr
        $user = User::create($input);

        // membuat message berhasil
        $data = [
            'message' => 'User is created successfully',
        ];

        // mengirim response berhasil JSON
        return response()->json($data, 200);
    }

    // membuat fitur login
    public function login(Request $request)
    {
        // menangkap inputan user
        $input = [
            'email'=> $request->email,
            'password'=> $request->password,
        ];

        // mengambil data user (DB)
        $user = User::where('email', $request->email)->first();

        // membandingkan input user dgn data user (DB)
        $isLoginSuccessfully = (
            $input['email'] == $user->email
            &&
            Hash::check($input['password'], $user->password)
        );

        if ( $isLoginSuccessfully ) {
            // membuat token
            $token = $user->createToken('auth_token');

            $data = [
                'message' => 'Login successfully',
                'token' => $token->plainTextToken,
            ];

            // mengembalikan respon JSON (berhasil)
            return response()->json($data,200);
        } else {
            $data = [
                'message' => 'Username or Password is wrong',
            ];

            // mengembalikan respon JSON (gagal)
            return response()->json($data,401);
        }
    }
}
