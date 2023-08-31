<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', function () {
    return ['Laravel' => app()->version()];
});

Route::post('/test', function (Request $request) {
    return [
        'request' => 'ddaaang',
        'msg' => 'OK',
    ];
});

Route::get('/migrate', function () {
    Artisan::call('migrate:fresh --seed');
});


// Route::post('/login', function (Request $request) {
// 	return $request;
// });

require __DIR__ . '/auth.php';
