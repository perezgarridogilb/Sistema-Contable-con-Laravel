<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Category;
use App\Models\Denomination;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class CoinsController extends Component
{
    use WithFileUploads, WithPagination;

    //PROPIEDADES
    public $type, $value, $searchTerm, $image, $selected_id, $pageTitle, $componentName, $users;
    private $pagination = 5;

    public function mount()
    {
        $this->pageTitle = 'Listado';
        $this->componentName = 'denominaciones';
        $this->type = 'Elegir';

    }

    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }


    public function render()
    {
        if(strlen($this->searchTerm) > 0){
        $data = Denomination::where('type', 'like', '%' . $this->searchTerm . '%')->paginate($this->pagination);
         } else {
        $data = Denomination::orderBy('id', 'desc')->paginate($this->pagination);
        }
        
        return view('livewire.denominations.component', ['data' => $data])
            ->extends('layouts.theme.app')
            ->section('content');
    }

    public function searchProducts()
    {
    $this->resetPage(); // Reinicia la página de la paginación al realizar una nueva búsqueda
    $this->render(); // Vuelve a renderizar el componente para aplicar la búsqueda
    }

    public function Edit($id){
        $record = Denomination::find($id, ['id','type', 'value', 'image']);
        $this->type = $record->type;
        $this->value = $record->value;
        $this->selected_id = $record->id;
        $this->image = null;

        $this->emit('show-modal', 'show modal!');
    }

    public function Store() {
        $rules = [
            'type' => 'required|not_in:Elegir',
            'value' => 'required|unique:denominations|gte:0.10'
        ];

        $messages = [
            'type.required' => 'El tipo es requerido.',
            'type.not_in' => 'Elige un valor para el tipo distinto a Elegir.',
            'value.required' => 'El valor es requerido.',
            'value.unique' => 'Ya existe el valor.',
            'value.gte' => 'El valor debe ser mayor a diez centavos.'
        ];

        $this->validate($rules, $messages);

        $denomination = Denomination::create([
            'name' => $this->type,
            'value' => $this->value
        ]);

        if($this->image) {
            $customFileName = uniqid() . '_.' . $this->image->extension();
            $this->image->storeAs('public/denominations', $customFileName);
            $denomination->image = $customFileName;
            $denomination->save();
        }

        $this->resetUI();
        $this->emit('item-added', 'Denominación Registrada');
        // $this->emit('imageUploaded');


    }

    public function Update() {
        $rules = [
            'type' => "required|not_in:Elegir",
            'value' => "required|unique:denominations,value,{$this->selected_id}|gte:0.10",
        ];

        $messages = [
            'type.required' => 'Nombre de categoría requerido.',
            'type.not_in' => 'Elige un tipo válido.',
            'name.required' => 'El valor es requerido.',
            'value.unique' => 'Ya existe el valor.',
            'value.gte' => 'El valor debe ser mayor a diez centavos.'
        ];

        $this->validate($rules, $messages);

        $denomination = Denomination::find($this->selected_id);
        $denomination->update([
            'type' => $this->type,
            'value' => $this->value,
        ]);

        if($this->image)
        {
            $customFileName = uniqid() . '-.' . $this->image->extension();
            $this->image->storeAs('public/denominations', $customFileName);
            /** Guardamos la imagen temporal */
            $imageName = $denomination->image;

            $denomination->image = $customFileName;
            $denomination->save();

            /** Si tenía imagen anterior */
            if($imageName != null) {
                /** Si existe fisicamente la eliminamos */
                if(file_exists('storage/denominations' . $imageName)){
                    unlink('storage/denominations' . $imageName);
                }
            }
            
        }
        
                    $this->resetUI();
                    $this->emit('item-updated', 'Denominación actualizada');
        
    }

    public function resetUI() {
        $this->type = '';
        $this->value = '';
        $this->image = null;
        $this->searchTerm = '';
        $this->selected_id = 0;
    }

    protected $listeners = [
        'deleteRow' => 'Destroy'
    ];

    public function Destroy(Denomination $denomination) {
        /* $denomination = Category::find($id); */
        $imageName = $denomination->image; //imagen temporal
        $denomination->delete();

        try {
            if ($imageName != null) {
                /** Si existe la imagen se elimina */
                unlink('storage/denominations/' . $imageName);
            }
        } catch (\Exception $e) {
            $this->emit('item-deleted-error', 'Ocurrió un error al eliminar la imagen');
        }

        $this->resetUI();
        $this->emit('item-deleted', 'Denominación eliminada');
    }
}
