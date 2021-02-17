<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\Request;

class BannerController extends Controller
{

   public function show()
   {
      $banners = Banner::query();
      $rows = $banners->count();
      if ($rows > 0) {
         return response()->json([
            'status' => 'success',
            'message' => 'Banner has found.',
            'rows' => $rows,
            'data' => $banners->get()
         ], 200);
      } else {
         return response()->json([
            'status' => 'error',
            'message' => 'Banner not found.'
         ], 404);
      }
   }
}
