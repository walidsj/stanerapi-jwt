<?php

namespace App\Http\Controllers;

use App\Mahasiswa;
use App\Matkul;
use Illuminate\Http\Request;

class MahasiswaController extends Controller
{

   public function show(Request $request)
   {
      $this->validate($request, [
         'id' => 'numeric',
         'idProdi' => 'numeric',
         'idJurusan' => 'numeric',
         'idSemester' => 'numeric',
         'numberAbsen' => 'numeric'
      ]);

      $mahasiswa = Mahasiswa::query();
      $mahasiswa->leftJoin('semesters', 'mahasiswas.idSemester', '=', 'semesters.id')
         ->leftJoin('prodis', 'semesters.idProdi', '=', 'prodis.id')
         ->leftJoin('jurusans', 'prodis.idJurusan', '=', 'jurusans.id')
         ->select('mahasiswas.*', 'semesters.name as nameSemester', 'jurusans.id as idJurusan', 'jurusans.name as nameJurusan', 'prodis.id as idProdi', 'prodis.name as nameProdi');

      if ($request->input('id')) {
         $mahasiswa->where('id', $request->input('id'));
      }
      if ($request->input('idJurusan')) {
         $mahasiswa->where('jurusans.id', $request->input('idJurusan'));
      }
      if ($request->input('idProdi')) {
         $mahasiswa->where('prodis.id', $request->input('idProdi'));
      }
      if ($request->input('idSemester')) {
         $mahasiswa->where('idSemester', $request->input('idSemester'));
      }
      if ($request->input('name')) {
         $mahasiswa->where('mahasiswas.name', 'like', '%' . $request->input('name') . '%');
      }
      if ($request->input('npm')) {
         $mahasiswa->where('npm', 'like', '%' . $request->input('npm') . '%');
      }
      if ($request->input('gender')) {
         $mahasiswa->where('gender', $request->input('gender'));
      }
      if ($request->input('yearGeneration')) {
         $mahasiswa->where('yearGeneration', 'like', '%' . $request->input('yearGeneration') . '%');
      }
      if ($request->input('yearGraduation')) {
         $mahasiswa->where('yearGraduation', 'like', '%' . $request->input('yearGraduation') . '%');
      }
      if ($request->input('class')) {
         $mahasiswa->where('class', 'like', '%' . $request->input('class') . '%');
      }
      if ($request->input('numberAbsen')) {
         $mahasiswa->where('numberAbsen', $request->input('numberAbsen'));
      }
      if ($request->input('nameJurusan')) {
         $mahasiswa->where('jurusans.name', 'like', '%' . $request->input('nameJurusan') . '%');
      }
      if ($request->input('nameProdi')) {
         $mahasiswa->where('prodis.name', 'like', '%' . $request->input('nameProdi') . '%');
      }
      if ($request->input('nameSemester')) {
         $mahasiswa->where('semesters.name', 'like', '%' . $request->input('nameSemester') . '%');
      }

      $numRows = $mahasiswa->count();
      if ($numRows > 0) {
         return response()->json([
            'status' => 'success',
            'message' => 'Mahasiswa has found.',
            'row' => $numRows,
            'data' => $mahasiswa->get()
         ]);
      } else {
         return response()->json([
            'status' => 'error',
            'message' => 'Mahasiswa not found.'
         ], 404);
      }
   }

   public function create(Request $request)
   {
      $this->validate($request, [
         'name' => 'required',
         'class' => 'required',
         'idSemester' => 'required|numeric',
         'gender' => 'required|in:Male,Female',
         'npm' => 'required|numeric|digits:10',
         'yearGeneration' => 'required|numeric|digits:4',
         'yearGraduation' => 'required|numeric|digits:4',
         'numberAbsen' => 'required|numeric'
      ]);

      $mahasiswa = Mahasiswa::create($request->all());

      return response()->json([
         'status' => 'success',
         'message' => 'Mahasiswa successfully created.',
         'data' => $mahasiswa
      ], 201);
   }

   public function update(Request $request)
   {
      $this->validate($request, [
         'id' => 'required|numeric',
         'idSemester' => 'numeric',
         'gender' => 'in:Male,Female',
         'npm' => 'numeric|digits:10',
         'yearGeneration' => 'numeric|digits:4',
         'yearGraduation' => 'numeric|digits:4',
         'numberAbsen' => 'numeric'
      ]);

      $mahasiswa = Mahasiswa::findOrFail($request->input('id'));
      $mahasiswa->update($request->all());

      return response()->json([
         'status' => 'success',
         'message' => 'Mahasiswa has been updated.',
         'data' => $mahasiswa
      ]);
   }

   public function delete(Request $request)
   {
      $this->validate($request, [
         'id' => 'required|numeric'
      ]);

      $mahasiswa = Mahasiswa::findOrFail($request->input('id'));
      $mahasiswa->delete();

      return response()->json([
         'status' => 'success',
         'message' => 'Mahasiswa has been deleted.',
         'data' => $mahasiswa
      ]);
   }

   public function showWithMatkul(Request $request)
   {
      $this->validate($request, [
         'npm' => 'required|numeric',
      ]);

      $mahasiswa = Mahasiswa::where('npm', $request->input('npm'))
         ->leftJoin('semesters', 'mahasiswas.idSemester', '=', 'semesters.id')
         ->leftJoin('prodis', 'semesters.idProdi', '=', 'prodis.id')
         ->leftJoin('jurusans', 'prodis.idJurusan', '=', 'jurusans.id')
         ->select('mahasiswas.*', 'semesters.number as numberSemester', 'semesters.name as nameSemester', 'jurusans.id as idJurusan', 'jurusans.name as nameJurusan', 'prodis.id as idProdi', 'prodis.code as codeProdi', 'prodis.name as nameProdi')
         ->first();

      if ($mahasiswa) {
         $mahasiswa->increment('hits');
         $matkuls = Matkul::where('idSemester', $mahasiswa->idSemester)->get();

         return response()->json([
            'status' => 'success',
            'message' => 'Mahasiswa has found.',
            'data' => [
               'mahasiswa' => $mahasiswa,
               'matkuls' => $matkuls
            ]
         ]);
      } else {
         return response()->json([
            'status' => 'error',
            'message' => 'Mahasiswa not found.'
         ], 404);
      }
   }
}
