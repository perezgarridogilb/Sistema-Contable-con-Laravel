<?php

namespace App\Http\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Livewire\WithPagination;

class RolesController extends Component
{
    use WithPagination;

    public $roleName, $searchTerm, $selected_id, $pageTitle, $componentName;
    private $pagination = 5;

    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }

    public function mount()
    {
        $this->pageTitle = 'Listado';
        $this->componentName = 'Roles';
    }

    public function render()
    {
        if(strlen($this->searchTerm) > 0)
            $roles = Role::where('name', 'like', '%' . $this->searchTerm . '%')->paginate($this->pagination);
        else
            $roles = Role::orderBy('name', 'asc')->paginate($this->pagination);

        return view('livewire.roles.component', [
            'roles' => $roles
        ])
        ->extends('layouts.theme.app')
        ->section('content');
    }

    public function CreateRole()
    {
        $roles = ['roleName' => 'required|min:2|unique:roles,name'];

        $messages = [
            'roleName.required' => 'El nombre del roles es requerido.',
            'roleName.unique' => 'El role ya existe.',
            'roleName.min' => 'El nombre del role debe tener al menos dos caracteres.'

        ];

        $this->validate($roles, $messages);
        Role::create(['name' => $this->roleName]);
        $this->emit('role-added', 'Se registró el role con éxito.');
        $this->resetUI();
    }

    public function Edit(Role $role)
    {
        /* $role = Role::find($id); */
        $this->selected_id = $role->id;
        $this->roleName = $role->name;
        
        $this->emit('show-modal', 'Show modal');
    }

    public function UpdateRole()
    {
        $roles = ['roleName' => 'required|min:2|unique:roles,name, {$this->selected_id}'];

        $messages = [
            'roleName.required' => 'El nombre del roles es requerido.',
            'roleName.unique' => 'El role ya existe.',
            'roleName.min' => 'El nombre del role debe tener al menos dos caracteres.'

        ];

        $this->validate($roles, $messages);
        
        $role = Role::find($this->selected_id);
        $role->name = $this->roleName;
        $role->save();

        $this->emit('role-updated', 'Se actualizó el role con éxito.');
        $this->resetUI();
    }

    protected $listeners = ['destroy' => 'Destroy'];

    public function Destroy($id)
    {
        $permissionsCount = Role::find($id)->permissions->count();
        if ($permissionsCount > 0) {
            $this->emit('role-error', 'No se puede eliminar el role, ya que tiene permisos asociados.');
            return;
        }
        Role::find($id)->delete();
        $this->emit('role-deleted', 'Se eliminó el role con éxito.');
    }

    public function resetUI()
    {
        $this->roleName = '';

        $this->searchTerm = '';
        $this->selected_id = 0;
    }
}
