<?php

namespace App\Http\Controllers;

use App\Jurusan;
use Illuminate\Http\Request;

class JurusanController extends Controller
{

   public function show(Request $request)
   {
      $this->validate($request, [
         'id' => 'numeric',
         'contactPerson' => 'numeric'
      ]);

      $jurusan = Jurusan::query();

      if ($request->input('id')) {
         $jurusan->where('id', $request->input('id'));
      }
      if ($request->input('name')) {
         $jurusan->where('jurusans.name', 'like', '%' . $request->input('name') . '%');
      }
      if ($request->input('contactPerson')) {
         $jurusan->where('contactPerson', 'like', '%' . $request->input('contactPerson') . '%');
      }

      $numRows = $jurusan->count();

      if ($numRows > 0) {
         return response()->json([
            'status' => 'success',
            'message' => 'Jurusan has found.',
            'row' => $numRows,
            'data' => $jurusan->get()
         ]);
      } else {
         return response()->json([
            'status' => 'error',
            'message' => 'Jurusan not found.'
         ], 404);
      }
   }

   public function create(Request $request)
   {
      $this->validate($request, [
         'name' => 'required'
      ]);

      $jurusan = Jurusan::create($request->all());

      return response()->json([
         'status' => 'success',
         'message' => 'Jurusan successfully created.',
         'data' => $jurusan
      ], 201);
   }

   public function update(Request $request)
   {
      $this->validate($request, [
         'id' => 'required|numeric',
         'name' => 'required',
         'contactPerson' => 'required|numeric'
      ]);

      $jurusan = Jurusan::findOrFail($request->input('id'));
      $jurusan->update($request->all());

      return response()->json([
         'status' => 'success',
         'message' => 'Jurusan has been updated.',
         'data' => $jurusan
      ]);
   }

   public function delete(Request $request)
   {
      $this->validate($request, [
         'id' => 'required|numeric'
      ]);

      $jurusan = Jurusan::findOrFail($request->input('id'));
      $jurusan->delete();

      return response()->json([
         'status' => 'success',
         'message' => 'Jurusan has been deleted.',
         'data' => $jurusan
      ]);
   }
}
