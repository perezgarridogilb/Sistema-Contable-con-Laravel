<?php

namespace App\Http\Livewire;

use App\Models\User;
use Spatie\Permission\Contracts\Role;

use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Livewire\Component;

class UsersController extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $name, $phone, $email, $status, $image, $password, $selected_id, $profile;
    public $pageTitle, $componentName, $search;
    private $pagination = 3;

    function paginationView() {
        return 'vendor.livewire.bootstrap';
    }


function mount() {
    $this->pageTitle = 'Listado';
    $this->componentName = 'Usuarios';
    $this->status = 'Elegir';
}
  

    public function render()
    {
        if (strlen($this->search)>0) {
            $data = User::where('name', 'like', '%' . $this->search . '%')
            ->select('*')->orderBy('name', 'asc')->paginate($this->pagination);
        } else {
            $data = User::select('*')->orderBy('name', 'asc')->paginate($this->pagination);
        }
        return view('livewire.users.component', [
            'data' => $data,
            'roles' => Role::orderBy('name', 'asc')->get(),
        ])
        ->extends('layouts.theme.app')
        ->section('content');
    }

    function resetUI() {
        $this->name = '';
        $this->email = '';
        $this->password = '';
        $this->phone = '';
        $this->image = '';
        $this->search = '';
        $this->status = 'Elegir';

        $this->selected_id = 0;
    }

    function edit(User $user) {
        $this->selected_id = $user->id;
        $this->name = $user->name;
        $this->phone = $user->phone;
        $this->profile = $user->profile;
        $this->status = $user->status;
        $this->email = $user->email;
        $this->password = '';
        
        $this->emit('show-modal', 'open!');
    }
}
