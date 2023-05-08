<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class CategoriesController extends Component
{
    use WithFileUploads, WithPagination;

    //PROPIEDADES
    public $name, $searchTerm, $image, $selected_id, $pageTitle, $componentName, $users;
    private $pagination = 5;

    public function mount()
    {
        $this->pageTitle = 'Listado';
        $this->componentName = 'Categorias';

    }

    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }


    public function render()
    {
        if(strlen($this->searchTerm) > 0){
        $data = Category::where('name', 'like', '%' . $this->searchTerm . '%')->paginate($this->pagination);
         } else {
        $data = Category::orderBy('id', 'desc')->paginate($this->pagination);
        }
        
        return view('livewire.category.categories', ['categories' => $data])
            ->extends('layouts.theme.app')
            ->section('content');
    }
}
