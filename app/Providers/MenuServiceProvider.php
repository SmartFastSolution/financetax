<?php

namespace App\Providers;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;


class MenuServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //obtener toda la data del menu.json en este caso VerticalMenu.json 

        $verticalMenuJson = file_get_contents(base_path('resources/json/verticalMenu.json'));
        $verticalMenuData = json_decode($verticalMenuJson);

       //compartimos todo el menuData a todas las vistas
       View::share('menuData',[$verticalMenuData]);

      

    }
}
