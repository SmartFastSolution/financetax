<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\PermissionRegistrar;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      
          //resetea el cache de roles y permisos antes de exportar
          app()[PermissionRegistrar::class]->forgetCachedPermissions();
          $role1 = Role::create(['name'  => 'super-admin']);
          $role2 = Role::create(['name'  => 'admin']);
          $role3 = Role::create(['name'  => 'contador' ]);
          $role4 = Role::create(['name'  => 'financiero' ]);
          $role5 = Role::create(['name'  => 'marketing' ]);
          $role6 = Role::create(['name'  => 'abogado' ]);
          $role7 = Role::create(['name'  => 'invitado' ]);
          $role8 = Role::create(['name'  => 'cliente' ]);
  
          Permission::create(['name' => 'usuarios']);
          Permission::create(['name' => 'post']);
          Permission::create(['name' => 'departamentos']);
          Permission::create(['name' => 'actividades']);
          Permission::create(['name' => 'roles']);
      
      
      
          DB::table('users')->insert([

           
            'name'         => 'José Magallanes',
            'email'           => 'admin@admin.com',
            'password'        => Hash::make('12345678'),
            'estado'          => 'activo',
            'created_at'      => now(),
            'updated_at'      => now()
        ]);
        $user = User::find(1);
        $user->assignRole($role1);
    }
}
