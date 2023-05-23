<?php

namespace App\Http\Livewire;

use App\Models\Category;
use App\Models\Product;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class ProductsController extends Component
{
    use WithPagination;
    use WithFileUploads;
    public $name, $barcode, $cost, $price, $stock, $alerts, $categoryid, $searchTerm, $image, $selected_id, $pageTitle, $componentName;
    private $pagination = 5;

    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }

    public function mount()
    {
        $this->pageTitle = 'Listado';
        $this->componentName = 'productos';
        $this->categoryid = 'Elegir';
    }

    public function render()
    {
        if (strlen($this->searchTerm) > 0){
            $products = Product::join('categories as c', 'c.id', 'products.category_id')
                        ->select('products.*', 'c.name as category')
                        ->where('products.name','like', '%' .$this->searchTerm . '%')
                        ->orWhere('products.barcode','like', '%' .$this->searchTerm . '%')
                        ->orWhere('c.name','like', '%' .$this->searchTerm . '%')
                        ->orderBy('products.name', 'asc')
                        ->paginate($this->pagination);
        } else {
            $products = Product::join('categories as c', 'c.id', 'products.category_id')
                ->select('products.*', 'c.name as category')
                ->orderBy('products.name', 'asc')
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
            'cost' => 'required',
            'price' => 'required',
            'stock' => 'required',
            'alerts' => 'required',
            'categoryid' => 'required|not_in:Elegir'
        ];

        $messages = [
            'name.required' => 'Nombre del producto requerido.',
            'name.unique' => 'Ya existe el nombre del producto.',
            'name.min' => 'El nombre del producto debe tener al menos 3 caracteres.',
            'cost.required' => 'El costo es requerido.',
            'price.required' => 'El precio es requerido.',
            'stock.required' => 'El stock es requerido.',
            'alerts.required' => 'Ingresa el valor mínimo en existencias.',
            'categoryid.not_in' => 'Elige un nombre de categoría diferente de Elegir.',
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
            'category_id'  => $this->categoryid
        ]);

        if($this->image)
        {
            $customFileName = uniqid() . '_.' . $this->image->extension();
            $this->image->storeAs('public/products', $customFileName);
            $product->image = $customFileName;
            $product->save();
        }

        $this->resetUI();
        $this->emit('product-added', 'Producto Registrado');
    }

    public function resetUI() {

    }
}
