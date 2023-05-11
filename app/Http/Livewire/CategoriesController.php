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
        $this->componentName = 'categorias';

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

    public function Edit($id){
        $record = Category::find($id, ['id','name','image']);
        $this->name = $record->name;
        $this->selected_id = $record->id;
        $this->image = null;

        $this->emit('show-modal', 'show modal!');
    }

    public function Store() {
        $rules = [
            'name' => 'required|unique:categories|min:3'
        ];

        $messages = [
            'name.required' => 'Nombre de la categoría es requerido',
            'name.unique' => 'Ya existe el nombre de la categoría',
            'name.min' => 'El nombre de la categoría debe tener al menos 3 caracteres'
        ];

        $this->validate($rules, $messages);

        $category = Category::create([
            'name' => $this->name
        ]);

        if($this->image) {
            $customFileName = uniqid() . '_.' . $this->image->extension();
            $filePath = $this->image->storeAs('public/categorias', $customFileName);
            $category->image = $customFileName;
            $category->save();
        }

        $this->resetUI();
        $this->emit('category-added', 'Categoría Registrada');
        // $this->emit('imageUploaded');


    }

    public function Update() {
        $rules = [
            'name' => "required|min:3|unique:categories,name,{$this->selected_id}",
        ];

        $messages = [
            'name.required' => 'Nombre de categoría requerido',
            'name.min' => 'El nombre de la categoría debe tener al menos 3 carácteres',
            'name.unique' => 'El nombre de la categoría ya existe'
        ];

        $this->validate($rules, $messages);

        $category = Category::find($this->selected_id);
        $category->update([
            'name' => $this->name
        ]);

        if($this->image)
        {
            $customFileName = uniqid() . '-.' . $this->image->extension();
            $this->image->storeAs('public/categorias', $customFileName);
            $imageName = $category->image;

            $category->image = $customFileName;
            $category->save();

            if($imageName != null) {
                if(file_exists('storage/categorias' . $imageName)){
                    unlink('storage/categorias' . $imageName);
                }
            }
            
        }
        
                    $this->resetUI();
                    $this->emit('category-updated', 'Categoría actualizada');
        
    }

    public function resetUI() {
        $this->name = '';
        $this->image = null;
        $this->searchTerm = '';
        $this->selected_id = 0;
    }

    protected $listeners = [
        'deleteRow' => 'Destroy'
    ];

    public function Destroy(Category $category) {
        /* $category = Category::find($id); */
        $imageName = $category->image; //imagen temporal
        $category->delete();

        try {
            if ($imageName != null) {
                /** Si existe la imagen se elimina */
                unlink('storage/categorias/' . $imageName);
            }
        } catch (\Exception $e) {
            $this->emit('category-deleted-error', 'Ocurrió un error al eliminar la imagen');
        }

        $this->resetUI();
        $this->emit('category-deleted', 'Categoría eliminada');
    }
}
