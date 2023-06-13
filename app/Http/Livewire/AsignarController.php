<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;

class AsignarController extends Component
{
    use WithPagination;
    public $role, $componentName, $permisosSelected = [], $old_permissions = [];
    private $pagination = 10;

    public function paginationView()
    {
            return 'vendor.livewire.bootstrap';
    }

    public function mount()
    {
        $this->role = 'Elegir';
        $this->componentName = 'Asignar Permisos';
    }

    public function render()
    {
        // concatenar columna llamada checked, asignando una tercera columna que por defecto tiene el valor cero y e llama checked
        $permisos = Permission::select('name', 'id', DB::raw("0 as checked") )
            ->orderBy('name', 'asc')
            ->paginate($this->pagination);

        if ($this->role != 'Elegir') {
            $list = Permission::join('role_has_permissions as rp', 'rp.permission_id', 'permissions.id')
                ->where('role_id', $this->role)->pluck('permissions.id')->toArray();
            $this->old_permissions = $list;
        }

        if ($this->role != 'Elegir') {
            foreach ($permisos as $permiso) {
                $role = Role::find($this->role);
                /** Si tiene asignado ese permiso */
                $tienePermiso = $role->hasPermissionTo($permiso->name);
                if ($tienePermiso) {
                    /** Con ese uno podemos darnos cuenta que el permiso está activo */
                    $permiso->checked = 1;
                }
            }
        }

        return view('livewire.asignar.component', [
            'roles' => Role::orderBy('name', 'asc')->get(),
            'permisos' => $permisos
        ])->extends('layouts.theme.app')->section('content');
    }
        public $listeners = ['revokeall' => 'RemoveAll'];

        public function RemoveAll()
        {
            /** Validar si estamos seleccionando un rol en el listado */
            if ($this->role == 'Elegir') {
                $this->emit('sync-error', 'Selecciona un role válido');
                return;
            }

            $role = Role::find($this->role);
            /** Con esto revocamos los permisos */
            $role->syncPermissions([0]);
            $this->emit("removeall', 'Se revocaron todos los permisos al role $role->name");
        }

        public function SyncAll()
        {
            if ($this->role == 'Elegir') {
                $this->emit('sync-error', 'Selecciona un role válido');
                return;
            }

            $role = Role::find($this->role);
            $permisos = Permission::pluck('id')->toArray();
            $role->syncPermissions($permisos);
            $this->emit('syncall', "Se sincronizaron todos los permisos al role $role->name");
        }

        public function syncPermiso($state, $permisoName)
        {
            if ($this->role != 'Elegir') {
                $roleName = Role::find($this->role);

                if ($state) {
                    $roleName->givePermissionTo($permisoName);
                    $this->emit('permi', "Permiso asignado correctamente.");
                } else {
                    $roleName->revokePermissionTo($permisoName);
                    $this->emit('permi', "Permiso eliminado correctamente.");
                }
            } else {
                $this->emit('permi', 'Elige un role válido.');
            }
        }
  
}
