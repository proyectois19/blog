<?php

namespace App\Http\Livewire\Admin;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class UsersIndex extends Component
{
    use WithPagination;

    public $search;
    
    //el metodo updating seguido del nombre de la propiedad se activa y resetea la pagina
    public function updatingSearch(){
        $this->resetPage();
    }

    protected $paginationTheme ="bootstrap";


    public function render()
    {
        $users = User::where('name','LIKE','%'.$this->search.'%')
                        ->orWhere('email','LIKE','%'.$this->search.'%')
                        ->paginate();
        return view('livewire.admin.users-index', compact('users'));
    }
}
