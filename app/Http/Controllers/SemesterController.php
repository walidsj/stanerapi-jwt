<?php

namespace App\Http\Controllers;

use App\Semester;
use Illuminate\Http\Request;

class SemesterController extends Controller
{

   public function show(Request $request)
   {
      $this->validate($request, [
         'id' => 'numeric',
         'idProdi' => 'numeric',
         'idJurusan' => 'numeric',
         'number' => 'numeric'
      ]);

      $semester = Semester::query();
      $semester->leftJoin('prodis', 'semesters.idProdi', '=', 'prodis.id')
         ->leftJoin('jurusans', 'prodis.idJurusan', '=', 'jurusans.id')
         ->select('semesters.*', 'jurusans.id as idJurusan', 'jurusans.name as nameJurusan', 'prodis.name as nameProdi');

      if ($request->input('id')) {
         $semester->where('id', $request->input('id'));
      }
      if ($request->input('idJurusan')) {
         $semester->where('jurusans.id', $request->input('idJurusan'));
      }
      if ($request->input('idProdi')) {
         $semester->where('idProdi', $request->input('idProdi'));
      }
      if ($request->input('name')) {
         $semester->where('semesters.name', 'like', '%' . $request->input('name') . '%');
      }
      if ($request->input('number')) {
         $semester->where('number', $request->input('number'));
      }
      if ($request->input('nameJurusan')) {
         $semester->where('jurusans.name', 'like', '%' . $request->input('nameJurusan') . '%');
      }
      if ($request->input('nameProdi')) {
         $semester->where('prodis.name', 'like', '%' . $request->input('nameProdi') . '%');
      }

      $numRows = $semester->count();
      if ($numRows > 0) {
         return response()->json([
            'status' => 'success',
            'message' => 'Semester has found.',
            'row' => $numRows,
            'data' => $semester->get()
         ]);
      } else {
         return response()->json([
            'status' => 'error',
            'message' => 'Semester not found.'
         ], 404);
      }
   }

   public function create(Request $request)
   {
      $this->validate($request, [
         'name' => 'required',
         'idProdi' => 'required|numeric',
         'number' => 'required|numeric'
      ]);

      $semester = Semester::create($request->all());

      return response()->json([
         'status' => 'success',
         'message' => 'Semester successfully created.',
         'data' => $semester
      ], 201);
   }

   public function update(Request $request)
   {
      $this->validate($request, [
         'id' => 'required|numeric',
         'idProdi' => 'numeric',
         'name' => 'required',
         'number' => 'numeric',
      ]);

      $semester = Semester::findOrFail($request->input('id'));
      $semester->update($request->all());

      return response()->json([
         'status' => 'success',
         'message' => 'Semester has been updated.',
         'data' => $semester
      ]);
   }

   public function delete(Request $request)
   {
      $this->validate($request, [
         'id' => 'required|numeric'
      ]);

      $semester = Semester::findOrFail($request->input('id'));
      $semester->delete();

      return response()->json([
         'status' => 'success',
         'message' => 'Semester has been deleted.',
         'data' => $semester
      ]);
   }
}
