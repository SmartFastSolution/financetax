<?php

use Illuminate\Support\Facades\Route;

Route::prefix('tienda')->group(function(){

    Route::group(['middleware'=>['role_or_permission:super-admin|tienda']], function(){

        Route::get('/tienda-solution', 'Tienda\ShopController@Index')->name('tienda.index');  //ruta index tienda donde se encuentra los servicios 
        Route::get('/servicios/{id}','Tienda\ShopController@access')->name('subservicios');   //ruta para acceder a los subservicios de cada servicio
        Route::get('/detalle-subservicios/{id}','Tienda\ShopController@access2')->name('subservicios.detalle'); 
        Route::post('/obtener-plan', 'Tienda\ShopController@getPlanes')->name('tienda.obtener.plan');  //ruta obtener el plan del tipo de plan 

    });




});
