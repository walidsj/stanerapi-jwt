<?php

namespace App\Http\Controllers;

use App\User;

use Firebase\JWT\JWT;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

   private function jwt(User $user)
   {

      $payload = [
         'iss' => "lumen-jwt",
         'sub' => $user->id,
         'iat' => time(),
         'exp' => time() + 60 * 60 // token kadaluwarsa setelah 3600 detik
      ];

      return JWT::encode($payload, env('JWT_SECRET'));
   }

   public function authenticate(Request $request)
   {
      $this->validate($request, [
         'email' => 'required|email',
         'password' => 'required'
      ]);

      $username = $request->input('email');
      $password = $request->input('password');

      $selectedUser = User::where('email', '=', $username)->first();

      if ($selectedUser && Hash::check($password, $selectedUser->password)) {

         $username = $selectedUser->username;

         $token = $this->jwt($selectedUser);

         return response()->json([
            'status' => 'success',
            'message' => 'Login success.',
            'data' => $selectedUser,
            'token' => $token,
         ], 200);
      } else {

         return response([
            'status' => 'error',
            'message' => 'Login failed.'
         ], 422);
      }
   }
}
