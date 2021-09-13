<?php

use Illuminate\Support\Facades\Route;

//rutas del menu de reportes
Route::prefix('reportes')->group(function(){

    Route::group(['middleware'=>['role_or_permission:super-admin|reportes']], function(){
        //RUTAS DE REPORTES
        Route::get('/reporte-usuarios', 'Reportes\ReporteController@ReporteEdad')->name('reportes.usuario'); //reporte por edad usuarios
        Route::get('/reporte-usuarios-ciudad', 'Reportes\ReporteController@ReporteCiudad')->name('reportes.usuario.ciudad'); //reporte por edad usuarios
        Route::get('/reporte-generos', 'Reportes\ReporteController@ReporteGenero')->name('reportes.genero'); //reporte por genero usuarios
 });


});
