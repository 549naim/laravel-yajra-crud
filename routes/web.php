<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/',[HomeController::class,'index'])->name('index');
Route::get('/create',[HomeController::class,'create'])->name('create');
Route::post('/insert_product',[HomeController::class,'insert_product'])->name('insert_product');
Route::get('edit/{id}',[HomeController::class,'editProduct']);
Route::post('update/{id}',[HomeController::class,'updateProduct']);
Route::get('/product/delete',[HomeController::class,'deleteProduct']);
