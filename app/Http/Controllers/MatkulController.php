<?php

namespace App\Http\Controllers;

use App\Matkul;
use Illuminate\Http\Request;

class MatkulController extends Controller
{

   public function show(Request $request)
   {
      $this->validate($request, [
         'id' => 'numeric',
         'idProdi' => 'numeric',
         'idJurusan' => 'numeric',
         'idSemester' => 'numeric',
         'sessionExam' => 'numeric',
         'sksNumber' => 'numeric'
      ]);

      $matkul = Matkul::query();
      $matkul->leftJoin('semesters', 'matkuls.idSemester', '=', 'semesters.id')
         ->leftJoin('prodis', 'semesters.idProdi', '=', 'prodis.id')
         ->leftJoin('jurusans', 'prodis.idJurusan', '=', 'jurusans.id')
         ->select('matkuls.*', 'semesters.name as nameSemester', 'jurusans.id as idJurusan', 'jurusans.name as nameJurusan', 'prodis.id as idProdi', 'prodis.name as nameProdi');

      if ($request->input('id')) {
         $matkul->where('id', $request->input('id'));
      }
      if ($request->input('idJurusan')) {
         $matkul->where('jurusans.id', $request->input('idJurusan'));
      }
      if ($request->input('idProdi')) {
         $matkul->where('prodis.id', $request->input('idProdi'));
      }
      if ($request->input('idSemester')) {
         $matkul->where('idSemester', $request->input('idSemester'));
      }
      if ($request->input('name')) {
         $matkul->where('matkuls.name', 'like', '%' . $request->input('name') . '%');
      }
      if ($request->input('code')) {
         $matkul->where('code', 'like', '%' . $request->input('code') . '%');
      }
      if ($request->input('sessionExam')) {
         $matkul->where('sessionExam', $request->input('sessionExam'));
      }
      if ($request->input('sksNumber')) {
         $matkul->where('sksNumber', $request->input('sksNumber'));
      }
      if ($request->input('nameJurusan')) {
         $matkul->where('jurusans.name', 'like', '%' . $request->input('nameJurusan') . '%');
      }
      if ($request->input('nameProdi')) {
         $matkul->where('prodis.name', 'like', '%' . $request->input('nameProdi') . '%');
      }
      if ($request->input('nameSemester')) {
         $matkul->where('semesters.name', 'like', '%' . $request->input('nameSemester') . '%');
      }

      $numRows = $matkul->count();
      if ($numRows > 0) {
         return response()->json([
            'status' => 'success',
            'message' => 'Matkul has found.',
            'row' => $numRows,
            'data' => $matkul->get()
         ]);
      } else {
         return response()->json([
            'status' => 'error',
            'message' => 'Matkul not found.'
         ], 404);
      }
   }

   public function create(Request $request)
   {
      $this->validate($request, [
         'name' => 'required',
         'code' => 'required',
         'idSemester' => 'required|numeric',
         'sessionExam' => 'required|numeric|digits:2',
         'sksNumber' => 'required|numeric'
      ]);

      $matkul = Matkul::create($request->all());

      return response()->json([
         'status' => 'success',
         'message' => 'Matkul successfully created.',
         'data' => $matkul
      ], 201);
   }

   public function update(Request $request)
   {
      $this->validate($request, [
         'id' => 'required|numeric',
         'idSemester' => 'numeric',
         'sessionExam' => 'numeric|digits:2',
         'sksNumber' => 'numeric'
      ]);

      $matkul = Matkul::findOrFail($request->input('id'));
      $matkul->update($request->all());

      return response()->json([
         'status' => 'success',
         'message' => 'Matkul has been updated.',
         'data' => $matkul
      ]);
   }

   public function delete(Request $request)
   {
      $this->validate($request, [
         'id' => 'required|numeric'
      ]);

      $matkul = Matkul::findOrFail($request->input('id'));
      $matkul->delete();

      return response()->json([
         'status' => 'success',
         'message' => 'Matkul has been deleted.',
         'data' => $matkul
      ]);
   }
}
