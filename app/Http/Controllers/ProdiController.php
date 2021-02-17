<?php

namespace App\Http\Controllers;

use App\Prodi;
use Illuminate\Http\Request;

class ProdiController extends Controller
{

   public function show(Request $request)
   {
      $this->validate($request, [
         'id' => 'numeric',
         'idJurusan' => 'numeric'
      ]);

      $jurusan = Prodi::query();
      $jurusan->leftJoin('jurusans', 'prodis.idJurusan', '=', 'jurusans.id')
         ->select('prodis.*', 'jurusans.name as nameJurusan');

      if ($request->input('id')) {
         $jurusan->where('id', $request->input('id'));
      }
      if ($request->input('idJurusan')) {
         $jurusan->where('idJurusan', $request->input('idJurusan'));
      }
      if ($request->input('name')) {
         $jurusan->where('prodis.name', 'like', '%' . $request->input('name') . '%');
      }
      if ($request->input('code')) {
         $jurusan->where('code', 'like', '%' . $request->input('code') . '%');
      }
      if ($request->input('nameJurusan')) {
         $jurusan->where('jurusans.name', 'like', '%' . $request->input('nameJurusan') . '%');
      }

      $numRows = $jurusan->count();
      if ($numRows > 0) {
         return response()->json([
            'status' => 'success',
            'message' => 'Prodi has found.',
            'row' => $numRows,
            'data' => $jurusan->get()
         ]);
      } else {
         return response()->json([
            'status' => 'error',
            'message' => 'Prodi not found.'
         ], 404);
      }
   }

   public function create(Request $request)
   {
      $this->validate($request, [
         'name' => 'required',
         'code' => 'required',
         'idJurusan' => 'required|numeric'
      ]);

      $jurusan = Prodi::create($request->all());

      return response()->json([
         'status' => 'success',
         'message' => 'Prodi successfully created.',
         'data' => $jurusan
      ], 201);
   }

   public function update(Request $request)
   {
      $this->validate($request, [
         'id' => 'required|numeric',
         'idJurusan' => 'numeric',
         'code' => 'required',
         'name' => 'required'
      ]);

      $jurusan = Prodi::findOrFail($request->input('id'));
      $jurusan->update($request->only(['name', 'idJurusan']));

      return response()->json([
         'status' => 'success',
         'message' => 'Prodi has been updated.',
         'data' => $jurusan
      ]);
   }

   public function delete(Request $request)
   {
      $this->validate($request, [
         'id' => 'required|numeric'
      ]);

      $jurusan = Prodi::findOrFail($request->input('id'));
      $jurusan->delete();

      return response()->json([
         'status' => 'success',
         'message' => 'Prodi has been deleted.',
         'data' => $jurusan
      ]);
   }
}
