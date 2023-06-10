<?php

namespace App\Http\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Livewire\WithPagination;

class PermisosController extends Component
{
    use WithPagination;

    public $permissionName, $searchTerm, $selected_id, $pageTitle, $componentName;
    private $pagination = 10;

    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }

    public function mount()
    {
        $this->pageTitle = 'Listado';
        $this->componentName = 'permisos';
    }

    public function searchProducts()
    {
    $this->resetPage(); // Reinicia la página de la paginación al realizar una nueva búsqueda
    $this->render(); // Vuelve a renderizar el componente para aplicar la búsqueda
    }

    public function render()
    {
        if(strlen($this->searchTerm) > 0)
            $permisos = Permission::where('name', 'like', '%' . $this->searchTerm . '%')->paginate($this->pagination);
        else
            $permisos = Permission::orderBy('name', 'asc')->paginate($this->pagination);

        return view('livewire.permisos.component', [
            'permisos' => $permisos
        ])
        ->extends('layouts.theme.app')
        ->section('content');
    }

    public function CreatePermission()
    {
        $rules = ['permissionName' => 'required|min:2|unique:permissions,name'];

        $messages = [
            'permissionName.required' => 'El nombre del permiso es requerido.',
            'permissionName.unique' => 'El permiso ya existe.',
            'permissionName.min' => 'El nombre del permiso debe tener al menos dos caracteres.'

        ];

        $this->validate($rules, $messages);
        Permission::create(['name' => $this->permissionName]);
        $this->emit('permiso-added', 'Se registró el permiso con éxito.');
        $this->resetUI();
    }

    public function Edit(Permission $permiso)
    {
        /* $role = Role::find($id); */
        $this->selected_id = $permiso->id;
        $this->permissionName = $permiso->name;
        
        $this->emit('show-modal', 'Show modal');
    }

    public function UpdatePermission()
    {
        $rules = ['permissionName' => 'required|min:2|unique:permissions,name, {$this->selected_id}'];

        $messages = [
            'permissionName.required' => 'El nombre del permiso es requerido.',
            'permissionName.unique' => 'El permiso ya existe.',
            'permissionName.min' => 'El nombre del permiso debe tener al menos dos caracteres.'

        ];

        $this->validate($rules, $messages);
        
        $permiso = Permission::find($this->selected_id);
        $permiso->name = $this->permissionName;
        $permiso->save();

        $this->emit('permiso-updated', 'Se actualizó el permiso con éxito.');
        $this->resetUI();
    }

    protected $listeners = ['destroy' => 'Destroy'];

    public function Destroy($id)
    {
        /** Cantidad de roles asociados a este permiso */
        $rolesCount = Permission::find($id)->getRoleNames()->count();
        if ($rolesCount > 0) {
            $this->emit('permiso-error', 'No se puede eliminar el permiso debido a que tiene permisos asociados.');
            return;
        }
        Permission::find($id)->delete();
        $this->emit('permiso-deleted', 'Se eliminó el permiso con éxito.');
    }

    public function resetUI()
    {
        $this->permissionName = '';

        $this->searchTerm = '';
        $this->selected_id = 0;
        /** Limpiando los errores que tengamos a través de livewire, revisar documentación */
        $this->resetValidation();
    }
}
