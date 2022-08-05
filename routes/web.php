<?php

use App\Http\Controllers\FileController;
use App\Http\Controllers\GraphController;
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
    return view('welcome');
});

Route::get('/upload-file', [FileController::class, 'uploadCsvForm']);
Route::post('/upload-file', [FileController::class,'uploadCSV'])->name('fileUpload');
Route::get('/graph-view', [GraphController::class, 'viewGraph'])->name('viewGraph');
Route::get('/generate-graph', [GraphController::class, 'generateGraph'])->name('generateGraph');
Route::get('/generate-graph-linear-regression', [GraphController::class, 'generateLinearRegression'])->name('generateLinearRegression');