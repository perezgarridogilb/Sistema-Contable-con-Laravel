<?php

namespace App\Http\Livewire;

use App\Models\Denomination;
use Livewire\Component;

class CoinsController extends Component
{

    public $componentName = 'Denominaciones', $pageTitle = 'Listado';

    public function render()
    {
        return view('livewire.denominations.component', 
        ['data' => Denomination::paginate(5)

        ])->extends('layouts.theme.app')->section('content');
    }
}
