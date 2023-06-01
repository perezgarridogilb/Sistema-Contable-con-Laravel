<?php

namespace App\Http\Livewire;

use Livewire\Component;

class SearchController extends Component
{
    public $search;
    
    public function render()
    {
        return view('livewire.search');
    }
}
