<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AdminController;

use App\Http\Controllers\EmployeeController;
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
    return view('welcome');
})->name('home');

Route::get('/admin',[AdminController::class, 'index'])->name('admin');
Route::get('/admin2',[AdminController::class, 'index2'])->name('admin2');


Route::resource('employee',EmployeeController::class );


Route::get('/test', [EmployeeController::class, 'getList'])->name('employee.list');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
