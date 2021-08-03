<?php

use Illuminate\Support\Facades\Route;

Route::prefix('servicios')->group(function(){

     Route::group(['middleware'=>['role_or_permission:super-admin|tipo_plan']], function(){
            //RUTAS DE LOS TIPOS DE PLANES Y PLANES
            Route::get('/tipo-planes', 'Servicios\ServicioController@TipoPlanes')->name('servicios.tipo.planes');
            Route::get('/planes', 'Servicios\ServicioController@Planes')->name('servicios.planes');

     });

     Route::group(['middleware'=>['role_or_permission:super-admin|servicio']], function(){
          //RUTAS DE LOS TIPOS DE PLANES Y PLANES
          Route::get('/servicios', 'Servicios\ServicioController@Servicio')->name('servicios.servicio'); //ruta de servicios 
          Route::get('/sub-servicios', 'Servicios\SubserviceController@Index')->name('servicios.subservicio.index'); //indice de un subservicio
          Route::get('/sub-servicios/create', 'Servicios\SubserviceController@Sub_service')->name('servicios.subservicio.create'); //creacion de un subservicio
          Route::post('/store-subservicios', 'Servicios\SubserviceController@store')->name('servicios.subservicio.store'); //store de un subservicio

   });




});