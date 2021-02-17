<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

   public function create(Request $request)
   {
      $this->validate($request, [
         'name' => 'required',
         'password' => 'required',
         'role' => 'required|in:admin,user',
         'hostClient' => 'required',
         'email' => 'required|email|unique:users'
      ]);

      $inputUser = [
         'api_token' => Str::random(60),
         'email' => $request->input('email'),
         'name' => $request->input('name'),
         'role' => $request->input('role') ? $request->input('role') : 'user',
         'hostClient' => $request->input('hostClient'),
         'password' => Hash::make($request->input('password'))
      ];

      $user = User::create($inputUser);

      return response()->json([
         'status' => 'success',
         'message' => 'User successfully registered.',
         'data' => $user
      ], 201);
   }

   public function update(Request $request)
   {
      $this->validate($request, [
         'name' => 'required',
         'password' => 'required',
         'role' => 'required|in:admin,user',
         'email' => 'required|email'
      ]);

      $user = User::where('email', $request->input('email'))->first();
      if ($user) {
         if (Hash::check($request->input('password'), $user->password)) {
            $user->update($request->except(['password', 'api_token']));
            return response()->json([
               'status' => 'success',
               'message' => 'User has been updated.',
               'data' => $user
            ]);
         } else {
            return response()->json([
               'status' => 'error',
               'message' => 'Password is not correct.'
            ], 401);
         }
      } else {
         return response()->json([
            'status' => 'error',
            'message' => 'User has not been registered.'
         ], 404);
      }
   }

   public function delete(Request $request)
   {
      $this->validate($request, [
         'password' => 'required',
         'email' => 'required|email'
      ]);

      $user = User::where('email', $request->input('email'))->first();
      if ($user) {
         if (Hash::check($request->input('password'), $user->password)) {
            $user->delete();
            return response()->json([
               'status' => 'success',
               'message' => 'User has been successfully deleted.',
            ]);
         } else {
            return response()->json([
               'status' => 'error',
               'message' => 'Password is not correct.'
            ], 401);
         }
      } else {
         return response()->json([
            'status' => 'error',
            'message' => 'User has not been registered.'
         ], 404);
      }
   }

   public function check(Request $request)
   {
      $this->validate($request, [
         'password' => 'required',
         'email' => 'required|email'
      ]);

      $user = User::where('email', $request->input('email'))->first();
      if ($user) {
         if (Hash::check($request->input('password'), $user->password)) {
            return response()->json([
               'status' => 'success',
               'message' => 'Login success. You can get your api_token now.',
               'data' => $user
            ]);
         } else {
            return response()->json([
               'status' => 'error',
               'message' => 'Password is not correct.'
            ], 401);
         }
      } else {
         return response()->json([
            'status' => 'error',
            'message' => 'User has not been registered.'
         ], 404);
      }
   }

   public function updateToken(Request $request)
   {
      $this->validate($request, [
         'password' => 'required',
         'email' => 'required|email'
      ]);

      $user = User::where('email', $request->input('email'))->first();
      if ($user) {
         if (Hash::check($request->input('password'), $user->password)) {
            $user->update([
               'api_token' => Str::random(60)
            ]);
            return response()->json([
               'status' => 'success',
               'message' => 'Reset token success. You get new api_token now.',
               'api_token' => $user->api_token
            ]);
         } else {
            return response()->json([
               'status' => 'error',
               'message' => 'Password is not correct.'
            ], 401);
         }
      } else {
         return response()->json([
            'status' => 'error',
            'message' => 'User has not been registered.'
         ], 404);
      }
   }
}
