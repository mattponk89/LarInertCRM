<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ArticleController;

use Inertia\Inertia;

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




Route::middleware(['auth:sanctum', 'verified'])->group(function () {

  Route::get('/', function () {
    return Inertia::render('Dashboard', [
      'canLogin' => Route::has('login'),
      'canRegister' => Route::has('register'),
      'laravelVersion' => Application::VERSION,
      'phpVersion' => PHP_VERSION,
    ]);
  });
  Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
  })->name('dashboard');

  Route::resource('/customers', CustomerController::class);
  Route::get('/import-export', [CustomerController::class, 'fileImportExport'])->name('import-export');
  Route::post('/file-import', [CustomerController::class, 'fileImport'])->name('file-import');
  Route::get('/file-export', [CustomerController::class, 'fileExport'])->name('file-export');
});
