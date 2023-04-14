<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AdminController;

use App\Http\Controllers\EmployeeController;

use App\Http\Controllers\AutocompleteController;

use App\Http\Controllers\PositionController;
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
Route::resource('position',PositionController::class );


Route::get('/test', [EmployeeController::class, 'getList'])->name('employee.list');

Route::get('/position_list', [PositionController::class, 'getList'])->name('position.list');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/allPositions', [App\Http\Controllers\PositionController::class, 'getAllPositions'])->name('allPositions');

Route::controller(AutocompleteController::class)->group(function(){
    Route::get('autocompleteEmployees', 'autocompleteEmployees')->name('autocomplete.employees');
});


Route::resource('employeeapi',\App\Http\Controllers\Api\EmployeeController::class);
Route::resource('positionapi',\App\Http\Controllers\Api\PositionController::class);
