<?php

use App\Http\Controllers\ApiController;
use App\Http\Controllers\FilesController;
use App\Http\Controllers\ItemsController;
use App\Http\Controllers\SessionController;
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

Route::get('/', [ItemsController::class, 'index'])->name('index');


Route::get('/dashboard', [ItemsController::class, 'index'])->name('dashboard');


Route::get('/user', function () {
    $user = auth()->user();
    return view('content.users-profile', ['user' => $user]);
})->name('user');

// Route::get('/{para}', function ($para) {
//     $notLogin = True;
//     if ($notLogin) {
//         return redirect()->route('index');
//     } else {
//         return redirect()->to("/$para");
//     }
// });

Route::get('/NiceAdmin/{para}', function ($para) {
    return view('NiceAdmin.'.$para);
});

Route::get('/items', [ItemsController::class, 'show'])->name('items');
Route::get('/tambah-item',[ItemsController::class,'tambah'])->name('tambah-item');
Route::post('/items/create', [ItemsController::class, 'store'])->name('create');
Route::post('/items/delete', [ItemsController::class, 'delete'])->name('delete');
Route::post('/items/edit', [ItemsController::class, 'editView'])->name('edit');
Route::post('/items/update', [ItemsController::class, 'update'])->name('update');
// Route::get('/items?page={page}', [ItemsController::class, 'show'])->name('items');



Route::get('/session',[SessionController::class,'index'])->name('login');
Route::post('/session/login',[SessionController::class,'login']);
Route::get('/session/logout',[SessionController::class,'logout'])->name('logout');
Route::get('/register',[SessionController::class,'register'])->name('register');
Route::post('/session/create',[SessionController::class,'create']);
Route::post('/change-password',[SessionController::class,'changePassword']);

Route::post('/submitForm', [ApiController::class, 'submitForm']);

Route::post('/upload-files', [FilesController::class,'store']);
Route::post('/update-profile-picture', [FilesController::class, 'updatePhoto'])->name('update-photo');
Route::get('/delete-profile-picture', [FilesController::class, 'deletePhoto'])->name('delete-photo');

Route::group(['middleware' => 'restrict.access'], function () {

    // Route::get('/assets/img/users', function () {
    //     return view('NiceAdmins.pages-error-404');
    // });
});

Route::middleware(['protect.assets'])->group(function () {

    Route::get('/assets/img/{any}', function () {
        return 'Accessing protected file.';
    })->where('any', '.*');
});

