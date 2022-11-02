<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PriceController;

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

Route::get('/', [PriceController::class, 'index'])->name('home');

//Export past calculations as CSV route
Route::get('price/export_as_csv', [PriceController::class, 'exportAsCSV'])->name('price.csv');
//Delete all table records
Route::delete('price/clear', [PriceController::class, 'clear'])->name('price.clear');
//Only include routes that are used
Route::resource('price', PriceController::class)->only(['index', 'store']);
