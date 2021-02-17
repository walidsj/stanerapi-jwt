<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;

class Controller extends BaseController
{
    //
    protected function buildFailedValidationResponse(Request $request, array $errors)
    {
        return [
            "status" => 'error',
            "message" => 'Request failed.',
            "errors" => $errors
        ];
    }
}
