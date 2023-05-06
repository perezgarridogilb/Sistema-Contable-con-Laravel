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
    public $name, $search, $image, $selected_id, $pageTitle, $componentName;
    private $pagination = 5;

    public function render()
    {
        $data = Category::all();

        return view('livewire.category.categories', ['categories' => $data])
            ->extends('layouts.theme.app')
            ->section('content');
    }
}
