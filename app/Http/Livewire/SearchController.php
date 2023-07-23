<?php

namespace App\Http\Livewire;

use App\Traits\CartTrait;
use Livewire\Component;
use Illuminate\Support\Str; // helper Str

class SearchController extends Component
{
    use CartTrait;

    public $search;
    public $currentPath;

    public function mount() {
        /** De esta manera obtenemos el path de donde estamos ubicados */
        $this->currentPath = url()->current();
    }

    protected $listeners = ['scan-code' => 'ScanCode'];

    public function ScanCode($barcode) {
        /** Determinar en qué componente estamos */
        $routeName = Str::afterLast($this->currentPath, '/');
        if ($routeName != 'pos') {
            $this->ScanearCode($barcode);
            /* redirect()->to('pos'); */
        }
    }
    
    public function render()
    {
        return view('livewire.search');
    }
}
