<?php

use App\Http\Controllers\ApiController;
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
    return view('content.main');
})->name('index');

Route::get('/user', function () {
    return view('NiceAdmin.users-profile');
})->name('user');

Route::get('/{para}', function ($para) {
    $notLogin = True;
    if ($notLogin) {
        return redirect()->route('index');
    } else {
        return redirect()->to("/$para");
    }
});

Route::get('/NiceAdmin/{para}', function ($para) {
    return view('NiceAdmin.'.$para);
});

Route::post('/submitForm', [ApiController::class, 'submitForm']);
