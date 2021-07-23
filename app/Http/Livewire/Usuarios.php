<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\User;
use Spatie\Permission\Models\Role;


class Usuarios extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $role;

    public function render()
    {
        $users = User::paginate(1);
        return view('livewire.usuarios', compact('users'));
    }


    public function edit($id){
         dd('here');
    }
    
    
}
