<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VisitorController;
use Illuminate\Support\Facades\Auth;

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


Route::get('/', [VisitorController ::class, 'index'])->name('VPage');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/Category', [App\Http\Controllers\CategoryController::class, 'show'])->name('cat.show');


Route::post('/Category/store', [App\Http\Controllers\CategoryController::class, 'store'])->name('cat.store');

Route::get('/Category{id}', [App\Http\Controllers\CategoryController::class, 'delete'])->name('cat.delete');

Route::post('/Category/update', [App\Http\Controllers\CategoryController::class, 'update'])->name('cat.update');

Route::get('/meal/show', [App\Http\Controllers\MealController::class, 'index'])->name('meal.index');

Route::get('/meal/create', [App\Http\Controllers\MealController::class, 'create'])->name('meal.create');

Route::post('/meal/store', [App\Http\Controllers\MealController::class, 'store'])->name('meal.store');

Route::get('/meal/edit/{id}', [App\Http\Controllers\MealController::class, 'edit'])->name('meal.edit');

Route::post('/meal/update/{id}', [App\Http\Controllers\MealController::class, 'update'])->name('meal.update');


Route::get('/meal/show/{id}',[App\Http\Controllers\MealController::class, 'show_details'])->name('meal_deatails');

Route::post('/order/store', [App\Http\Controllers\HomeController::class, 'orderstore'])->name('order.store');

Route::get('/order/show', [App\Http\Controllers\HomeController::class, 'show_order']);

Route::post('/order/{id}/status', [App\Http\Controllers\HomeController::class, 'changeStatus'])->name('order.status');


