<?php


/**
 * para control de rutas con json 
 */

use Illuminate\Support\Facades\Request;

if (!function_exists('active')) {
     function active($url){
            return Request::is($url) ? 'active' : '';
     }
 }

//funcion para activar todas las rutas 

if (!function_exists('ActiveAll')) {
       function ActiveAll($rutas){
              foreach ($rutas as $key => $ruta) {
                     if ($ruta->url == Request::is($ruta->url)) {
                            
                            return 'active';
                     }
              }
       }
}


//funcion para expandir las rutas 
 if (!function_exists('expanded')) {
        function expanded($rutas){
              foreach ($rutas as $key => $ruta) {
                     if ($ruta->url == Request::is($ruta->url)) {
                            return 'true';
                     }else{
                            $data = 'false';
                     }
              }
        }
 }


 //para la expansion y colocacion del submenu 

 //todavia queda enobservacion esta funcion 

 if (!function_exists('submenu')) {
        function submenu($rutas){
               foreach ($rutas as $key => $ruta) {
                      if ($ruta->url == Request::is($ruta->url)) {
                             return 'recent-submenu ' ;
                             //return 'recent-submenu mini-recent-submenu show' ; para mantener activado el submenu bug con el  Aegis
                      }
               }
        }
 }





