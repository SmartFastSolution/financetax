<?php

use Illuminate\Support\Facades\Route;

Route::prefix('servicios')->group(function(){

     Route::group(['middleware'=>['role_or_permission:super-admin|tipo_plan']], function(){
            //RUTAS DE LOS TIPOS DE PLANES Y PLANES
            Route::get('/tipo-planes', 'Servicios\ServicioController@TipoPlanes')->name('servicios.tipo.planes');
            Route::get('/planes', 'Servicios\PlanController@Planes')->name('servicios.planes'); //indice de los planes
            Route::get('/crear-plan', 'Servicios\PlanController@Plan')->name('servicios.planes.create');// crud de creacion de un plan 
            Route::post('/store-plan', 'Servicios\PlanController@Store')->name('servicios.planes.store'); //crud de almacenamiento de un plan 

     });

     Route::group(['middleware'=>['role_or_permission:super-admin|servicio']], function(){
          //RUTAS DE LOS TIPOS DE PLANES Y PLANES
          Route::get('/tipo-servicios', 'Servicios\ServicioController@TipoServicio')->name('servicios.tiposervicio'); //ruta de tipo servicios 
          Route::get('/servicios', 'Servicios\ServicioController@Servicio')->name('servicios.servicio'); //ruta de servicios 
          Route::get('/nuevo-servicio', 'Servicios\ServicioController@CreateServicio')->name('servicios.servicio.create');// crear servicio
          Route::post('/store-servicio', 'Servicios\ServicioController@Store')->name('servicios.servicio.store');// guardar servicio
          Route::get('/sub-servicios', 'Servicios\SubserviceController@Index')->name('servicios.subservicio.index'); //indice de un subservicio
          Route::get('/subservicios', 'Servicios\SubserviceController@Sub_service')->name('servicios.subservicio.create'); //creacion de un subservicio
          Route::post('/store-subservicios', 'Servicios\SubserviceController@store')->name('servicios.subservicio.store'); //store de un subservicio

   });




});