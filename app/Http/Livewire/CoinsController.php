<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Category;
use App\Models\Denomination;
use Illuminate\Support\Facades\Storage;
use League\Flysystem\AwsS3v3\AwsS3Adapter;
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
        $this->pageTitle = 'Lista';
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
                
            // Crea el adaptador AwsS3Adapter para guardar el archivo en AWS S3
                $s3Adapter = new AwsS3Adapter(Storage::disk('s3')->getDriver()->getAdapter()->getClient(), env('AWS_BUCKET'));


                $filePath = Storage::disk('s3')->putFileAs('denominations', $this->image, $customFileName, 'public');
            
            // Almacenar solo el nombre del archivo (sin la URL completa) en la base de datos
            $denomination->image = $filePath;
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
            $customFileName = uniqid() . '_.' . $this->image->extension();
            $s3Adapter = new AwsS3Adapter(Storage::disk('s3')->getDriver()->getAdapter()->getClient(), env('AWS_BUCKET'));
            $filePath = Storage::disk('s3')->putFileAs('denominations', $this->image, $customFileName, 'public');
            /** Imagen temporal */
            $imageTemp = $denomination->image;
            $denomination->image = $filePath;
            $denomination->save();

            /** Si tenía imagen anterior */
            if($imageTemp != null) {
                /** Si existe fisicamente la eliminamos */
                if(Storage::disk('s3')->exists($imageTemp)){
                    Storage::disk('s3')->delete($imageTemp );
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
        $imageTemp = $denomination->image; //imagen temporal
        $denomination->delete();

        try {
            if ($$imageTemp != null) {
                /** Si existe la imagen se elimina */
                Storage::disk('s3')->delete($denomination->image);
            }
        } catch (\Exception $e) {
            $this->emit('item-deleted-error', 'Ocurrió un error al eliminar la imagen');
        }

        $this->resetUI();
        $this->emit('item-deleted', 'Denominación eliminada');
    }
}
