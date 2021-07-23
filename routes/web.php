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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
// Route::get('/', 'HomeController@index')->name('index');  // para que acceda solo a home sin entrar a welcome




//Routas del landing Page de TAX Solution Finance
Route::get('/nosotros-solution', 'Vista\VistaController@Nosotros')->name('landing.nosotros.tax');
Route::get('/nuestro-equipo', 'Vista\VistaController@Nuestro_equipo')->name('landing.nuestro.equipo.tax');
Route::get('/servicios', 'Vista\VistaController@Servicios')->name('landing.servicios.tax');
Route::get('/contactenos', 'Vista\VistaController@Contactenos')->name('landing.contactenos.tax');