<?php

namespace App\Http\Livewire;

use App\Models\Denomination;
use Livewire\Component;

class CoinsController extends Component
{

    public $componentName = 'Denominaciones', $pageTitle = 'Listado', $selected_id, $image, $searchTerm;

    /** Primer método que se ejecuta en el siclo de vida de los componentes de livewire */
    public function mount() {
        $this->componentName = 'Denominaciones';
        $this->pageTitle = 'Listado';
        $this->selected_id = 0;
    }

    public function render()
    {
        return view('livewire.denominations.component', 
        ['data' => Denomination::paginate(5)

        ])->extends('layouts.theme.app')->section('content');
    }
}
