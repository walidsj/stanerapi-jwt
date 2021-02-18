<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () {
    return response()->json([
        'status' => 'success',
        'message' => env('APP_NAME') . ' is online.',
        'version' => '1.0.0',
    ]);
});

$router->group(['prefix' => 'api/v1'], function () use ($router) {
    $router->get('/banners', ['uses' => 'BannerController@show']);

    $router->post('/auth/login', ['uses' => 'AuthController@authenticate']);

    $router->group(['prefix' => 'data', 'middleware' => 'jwt.auth'], function () use ($router) {
        $router->get('/jurusan', ['uses' => 'JurusanController@show']);
    });
});

// $router->group(['prefix' => 'api/dev'], function () use ($router) {
//     $router->post('user', ['uses' => 'UserController@check']);
//     $router->put('user', ['uses' => 'UserController@update']);
//     $router->delete('user', ['uses' => 'UserController@delete']);
//     $router->post('user/register', ['uses' => 'UserController@create']);
//     $router->post('user/reset-token', ['uses' => 'UserController@updateToken']);
// });

// $router->group(['prefix' => 'api/data', 'middleware' => 'auth'], function () use ($router) {
//     $router->get('jurusan', ['uses' => 'JurusanController@show']);
//     $router->get('prodi', ['uses' => 'ProdiController@show']);
//     $router->get('semester', ['uses' => 'SemesterController@show']);
//     $router->get('mahasiswa', ['uses' => 'MahasiswaController@show']);
//     $router->get('matkul', ['uses' => 'MatkulController@show']);
//     $router->get('mahasiswa/search-matkul', ['uses' => 'MahasiswaController@showWithMatkul']);

//     $router->group(['middleware' => 'role:admin'], function () use ($router) {
//         $router->post('jurusan', ['uses' => 'JurusanController@create']);
//         $router->put('jurusan', ['uses' => 'JurusanController@update']);
//         $router->delete('jurusan', ['uses' => 'JurusanController@delete']);

//         $router->post('prodi', ['uses' => 'ProdiController@create']);
//         $router->put('prodi', ['uses' => 'ProdiController@update']);
//         $router->delete('prodi', ['uses' => 'ProdiController@delete']);

//         $router->post('semester', ['uses' => 'SemesterController@create']);
//         $router->put('semester', ['uses' => 'SemesterController@update']);
//         $router->delete('semester', ['uses' => 'SemesterController@delete']);

//         $router->post('mahasiswa', ['uses' => 'MahasiswaController@create']);
//         $router->put('mahasiswa', ['uses' => 'MahasiswaController@update']);
//         $router->delete('mahasiswa', ['uses' => 'MahasiswaController@delete']);

//         $router->post('matkul', ['uses' => 'MatkulController@create']);
//         $router->put('matkul', ['uses' => 'MatkulController@update']);
//         $router->delete('matkul', ['uses' => 'MatkulController@delete']);
//     });
// });