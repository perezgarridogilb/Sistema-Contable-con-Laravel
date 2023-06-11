<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;

class Asignar extends Component
{
    use WithPagination;
    public $role, $componentName, $permisosSelected = [], $old_permissions = [];
    
    public function paginationView()
    {
            return 'vendor.livewire.bootstrap';
    }
    
    public function render()
    {
        return view('livewire.asignar.component');
    }
}
