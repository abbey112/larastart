<?php

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

Route::get('/Pizzas', 'PizzaController@index');
Route::get('/Pizzas/create', 'PizzaController@create');
Route::POST('/Pizzas', 'PizzaController@store');
Route::get('/Pizzas/{id}', 'PizzaController@show');
Route::delete('/Pizzas/{id}', 'PizzaController@destroy');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
