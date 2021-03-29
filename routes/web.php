<?php

use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\PositionController;
use Illuminate\Support\Facades\Auth;
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
    return redirect()->route('employees.index');
});

Route::get('/home', function () {
    return redirect()->route('employees.index');
})->name('home');

Auth::routes();

// Route::group(['middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]], function() {

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('auth');

Route::get('/positions/datatable', [PositionController::class, 'datatable'])->name('positions.datatable');

Route::get('/employees/datatable', [EmployeeController::class, 'datatable'])->name('employees.datatable');

Route::resource('positions', PositionController::class)->middleware('auth');;

Route::resource('employees', EmployeeController::class)->middleware('auth');;

// Route::get('/change-position', [App\Http\Controllers\PositionController::class, 'change_position'])->name('change-position');

Route::get('/get-higher-ups', [App\Http\Controllers\PositionController::class, 'get_higherups'])->name('get-higherups');

// });

