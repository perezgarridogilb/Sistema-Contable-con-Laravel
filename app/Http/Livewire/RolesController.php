<?php

namespace App\Http\Livewire;

use Livewire\Component;

class RolesController extends Component
{
    public function render()
    {
        return view('livewire.roles.component')
        ->extends('layouts.theme.app')
        ->section('content');
    }
}
