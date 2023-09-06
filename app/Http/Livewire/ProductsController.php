<?php

namespace App\Http\Livewire;

use App\Models\Category;
use App\Models\Product;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

use Illuminate\Support\Facades\Storage;
use League\Flysystem\AwsS3v3\AwsS3Adapter;

class ProductsController extends Component
{
    use WithPagination;
    use WithFileUploads;
    public $name, $barcode, $cost, $price, $stock, $alerts, $categoryid, $searchTerm, $image, $selected_id, $pageTitle, $componentName;
    public $bandera = false, $banderaStock = false;
    private $pagination = 5;

    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }

    public function mount()
    {
        $this->pageTitle = 'Lista';
        $this->componentName = 'productos';
        $this->categoryid = 'Elegir';
    }

    public function searchProducts()
    {
    $this->resetPage(); // Reinicia la página de la paginación al realizar una nueva búsqueda
    $this->render(); // Vuelve a renderizar el componente para aplicar la búsqueda
    }

    public function recargarRender($value)
    {
        $this->bandera = $value;
        $this->resetPage(); // Reinicia la página de la paginación al realizar una nueva búsqueda
        $this->render(); // Vuelve a renderizar el componente para aplicar la búsqueda
    }

    public function recargarRender1($value1)
    {
        $this->banderaStock = $value1;
        $this->resetPage(); // Reinicia la página de la paginación al realizar una nueva búsqueda
        $this->render(); // Vuelve a renderizar el componente para aplicar la búsqueda
    }

    public function render()
    {
        if (strlen($this->searchTerm) > 0){
            $products = Product::join('categories as c', 'c.id', 'products.category_id')
                        ->select('products.*', 'c.name as category')
                        ->where('products.name','like', '%' .$this->searchTerm . '%')
                        ->orWhere('products.barcode','like', '%' .$this->searchTerm . '%')
                        ->orWhere('c.name','like', '%' .$this->searchTerm . '%')
                        ->orderBy('products.stock', $this->banderaStock ? 'desc' : 'asc')
                        ->orderBy('products.name', $this->bandera ? 'desc' : 'asc')
                        ->paginate($this->pagination);
        } else {
            $products = Product::join('categories as c', 'c.id', 'products.category_id')
                ->select('products.*', 'c.name as category')
                ->orderBy('products.stock', $this->banderaStock ? 'desc' : 'asc')
                ->orderBy('products.name', $this->bandera ? 'desc' : 'asc')
                ->paginate($this->pagination);
        }

        return view('livewire.products.component', [
            'data' => $products,
            'categories' => Category::orderBy('name', 'asc')->get()
        ])
        ->extends('layouts.theme.app')
        ->section('content');
    }

    public function Store() {
        $rules = [
            'name' => 'required|unique:products|min:3',
            'cost' => 'required|gt:1',
            'price' => 'required|gt:1',
            'stock' => 'required|gt:0',
            'alerts' => 'required',
            'barcode' => 'required|gt:1',
            'categoryid' => 'required|not_in:Elegir',
            'image' => 'max:1024', // Max 1024 KB = 1 MB
        ];

        $messages = [
            'name.required' => 'Nombre del producto requerido.',
            'name.unique' => 'Ya existe el nombre del producto.',
            'name.min' => 'El nombre del producto debe tener al menos 3 caracteres.',
            'cost.required' => 'El costo es requerido.',
            'cost.gt' => 'El costo no puede ser menor a uno.',
            'price.required' => 'El precio es requerido.',
            'price.gt' => 'El precio no puede ser menor a uno.',
            'stock.required' => 'El stock es requerido.',
            'stock.gt' => 'El stock no puede ser menor a cero.',
            'alerts.required' => 'Ingresa el valor mínimo en existencias.',
            'barcode.required' => 'Ingresa el valor de código de barras.',
            'barcode.gt' => 'El código de barras no puede ser menor a uno.',
            'categoryid.not_in' => 'Elige un nombre de categoría diferente de Elegir.',
            'image.max' => 'Inserte una imagen menor a 1024 KB.',
        ];

        /** Ejecutar validaciones */
        $this->validate($rules, $messages);

        $product = Product::create([
            /** Columnas tabla => Propiedades y su valor */
            'name' => $this->name,
            'cost' => $this->cost,
            'price' => $this->price,
            'barcode' => $this->barcode,
            'stock' => $this->stock,
            'alerts'  => $this->alerts,
            'category_id'  => $this->categoryid,
        ]);


        if($this->image) {
            $customFileName = uniqid() . '_.' . $this->image->extension();
                
            // Crea el adaptador AwsS3Adapter para guardar el archivo en AWS S3
                $s3Adapter = new AwsS3Adapter(Storage::disk('s3')->getDriver()->getAdapter()->getClient(), env('AWS_BUCKET'));


                $filePath = Storage::disk('s3')->putFileAs('productos', $this->image, $customFileName, 'public');
            
            // Almacenar solo el nombre del archivo (sin la URL completa) en la base de datos
            $product->image = $filePath;
            $product->save();
        }

        $this->resetUI();
        $this->emit('product-added', 'Producto Registrado');
    }
    
    public function Update() {
        $rules = [
            'name' => "required|min:3|unique:products,name,{$this->selected_id}",
            'cost' => 'required|gte:1',
            'price' => 'required|gte:1',
            'stock' => 'required|gte:0',
            'alerts' => 'required',
            'barcode' => 'required|gte:1',
            'categoryid' => 'required|not_in:Elegir',
            'image' => 'max:1024', // Max 1024 KB = 1 MB
        ];

        $messages = [
            'name.required' => 'Nombre del producto requerido.',
            'name.unique' => 'Ya existe el nombre del producto.',
            'name.min' => 'El nombre del producto debe tener al menos 3 caracteres.',
            'cost.required' => 'El costo es requerido.',
            'cost.gte' => 'El costo no puede ser menor a uno.',
            'price.required' => 'El precio es requerido.',
            'price.gte' => 'El precio no puede ser menor a uno.',
            'stock.required' => 'El stock es requerido.',
            'stock.gte' => 'El stock no puede ser menor a cero.',
            'alerts.required' => 'Ingresa el valor mínimo en existencias.',
            'barcode.required' => 'Ingresa el valor de código de barras.',
            'barcode.gte' => 'El código de barras no puede ser menor a uno.',
            'categoryid.not_in' => 'Elige un nombre de categoría diferente de Elegir.',
            'image.max' => 'Inserte una imagen menor a 1024 KB.',
        ];

        /** Ejecutar validaciones */
        $this->validate($rules, $messages);
        $product = Product::find($this->selected_id);

        $product->update([
            /** Columnas tabla => Propiedades y su valor */
            'name' => $this->name,
            'cost' => $this->cost,
            'price' => $this->price,
            'barcode' => $this->barcode,
            'stock' => $this->stock,
            'alerts'  => $this->alerts,
            'category_id'  => $this->categoryid
        ]);

        if($this->image)
        {
            $customFileName = uniqid() . '_.' . $this->image->extension();
            new AwsS3Adapter(Storage::disk('s3')->getDriver()->getAdapter()->getClient(), env('AWS_BUCKET'));
            $filePath = Storage::disk('s3')->putFileAs('productos', $this->image, $customFileName, 'public');
            $imageName = $product->image;
            $product->image = $filePath;
            $product->save();

            if($imageName != null) {
                if(Storage::disk('s3')->exists($imageName)){
                    Storage::disk('s3')->delete($imageName);
                }
            }
        }

        $this->resetUI();
        $this->emit('product-updated', 'Producto Actualizado');
    }

    public function Edit(Product $product){
        $this->selected_id = $product->id;
        $this->name = $product->name;
        $this->barcode = $product->barcode;
        $this->cost = $product->cost;
        $this->price = $product->price;
        $this->stock = $product->stock;
        $this->alerts = $product->alerts;
        $this->categoryid = $product->category_id;
        $this->image = null;

        $this->emit('modal-show', 'Show modal');

    }

    public function resetUI() {
        $this->name = '';
        $this->barcode = '';
        $this->cost = '';
        $this->price = '';
        $this->stock = '';
        $this->alerts = '';
        $this->searchTerm = '';
        $this->categoryid = 'Elegir';
        $this->image = 'null';
        $this->selected_id = 0;
    }

    protected $listeners = ['deleteRow' => 'Destroy'];

    public function Destroy(Product $product) {
        $imageTemp = $product->image;
        $product->delete();

        if ($imageTemp != null) {
            if ($$imageTemp != null) {
                /** Si existe la imagen se elimina */
                Storage::disk('s3')->delete($denomination->image);
            }
        }

        $this->resetUI();
        $this->emit('product-deleted', 'Producto eliminado');
    }
}
