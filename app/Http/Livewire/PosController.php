<?php

namespace App\Http\Livewire;

use App\Models\Denomination;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleDetails;
use Darryldecode\Cart\Cart as CartCart;
use Darryldecode\Cart\Facades\CartFacade as Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Livewire\Component;

class PosController extends Component
{
    public $total, $itemsQuantity, $efectivo, $change;

    public function mount()
    {
        $this->efectivo = 0;
        $this->change = 0;
        $this->total = Cart::getTotal();
        $this->itemsQuantity = Cart::getTotalQuantity();
    }

    public function render()
    {
        /** Necesario que lleve $this, revisar clase 46 de ser necesario */
        /* $this->denominations = Denomination::all(); */
        return view('livewire.pos.component', [
            'denominations' => Denomination::orderBy('value', 'desc')->get(),
            'cart' => Cart::getContent()->sortBy('name')
        ])
            ->extends('layouts.theme.app')
            ->section('content');
    }

    public function ACash($value)
    {
        $this->efectivo += ($value == 0 ? $this->total : $value);
        $this->change = ($this->efectivo - $this->total);
    }

    protected $listeners = [
        'scan-code' => 'ScanCode',
        'removeItem' => 'removeItem',
        'clearCart' => 'clearCart',
        'saveSale' => 'saveSale'
    ];

    public function ScanCode($barcode, $cant = 1)
    {
        $product = Product::where('barcode', $barcode)->first();

        if ($product == null || empty($empty)) {
            $this->emit('scan-notfound', 'El producto no está registrado');
        } else {
            if ($this->inCart($product->id)) {
                $this->increaseQty($product->id);
                return;
            }
            if ($product->stock < 1) {
                $this->emit('no-stock', 'Stock no suficiente');
                return;
            }
            Cart::add($product->id, $product->name, $product->price, $cant, $product->image);
            $this->total = Cart::getTotal();
            $this->emit('scan-ok', 'Producto agregado');
        }
    }
    /** Validar si ya existe en el carrito */
    public function inCart($productId)
    {
        $exist = Cart::get($productId);
        if ($exist) {
            return true;
        } else {
            return false;
        }
        
    }

    public function increaseQty($productId, $cant)
    {
        $title = '';
        $product = Product::find($productId);
        $exist = Cart::get($productId);
        if ($exist) {
            $title = 'Cantidad actualizada';
        } else {
            $title = 'Producto agregado';
        }

        if ($exist) {
            if ($product->stock < ($cant + $exist->quantity())) {
                $this->emit('no-stock', 'Stock insuficiente');
                return;
            }
        }

        Cart::add($product->id, $product->name, $product->price, $cant, $product->image);

        $this->total = Cart::getTotal();            
        $this->itemsQuantity = Cart::getTotalQuatity();         
        $this->emit('scan-ok', $title); 
            
    }

    /** Reemplazar la información del producto dentro del carrito, 
     * quita la información y la vuelve a poner */
    public function updateQty($productId, $cant = 1)
    {
        $title = '';
        $product = Product::find($productId);
        $exist = Cart::get($productId);
        if ($exist) {
            $title = 'Cantidad actualizada';
        } else {
            $title = 'Producto agregado';
        }

        if($exist) {
            if($product->stock < $cant)
            {
                $this->emit('no-stock', 'Stock insuficiente');
                return;
            }
        }

        $this->removeItem($productId);

        if ($cant > 0) {
            Cart::add($product->id, $product->name, $product->price, $cant, $product->image);

            $this->total = Cart::getTotal();            
            $this->itemsQuantity = Cart::getTotalQuatity();         
            $this->emit('scan-ok', $title); 
        } else {
            $this->emit('no-stock', 'Stock insuficiente');
        }
        
    }

    public function removeItem($productId)
    {
        Cart::remove($productId);
        
        $this->total = Cart::getTotal();
        $this->itemsQuantity = Cart::getTotalQuatity();
        $this->emit('scan-ok', 'Producto eliminado'); 
    }

    public function decreaseQty($productId)
    {
        $item = Cart::get($productId);
        Cart::remove($productId);

        $newQty = ($item->quantity) - 1;

        /** Si todavía quedan productos en el carrito */
        if ($newQty > 0) {
            Cart::add($item->id, $item->name, $item->price, $newQty, $item->attributes[0]);
        }

        $this->total = Cart::getTotal();
        $this->itemsQuantity = Cart::getTotalQuatity();
        $this->emit('scan-ok', 'Cantidad actualizada'); 
    }

    public function clearCart(Type $var = null)
    {
        Cart::clear();
        $this->efectivo = 0;
        $this->change = 0;
        $this->total = Cart::getTotal();
        $this->itemsQuantity = Cart::getTotalQuatity();

        $this->emit('scan-ok', 'Carrito vacío');
    }

    public function saveSale()
    {
        if ($this->total <= 0) {
            $this->emit('sale-error', 'Agrega productos a la venta');
            return;
        }
        if($this->efectivo <= 0)
        {
            $this->emit('sale-error', 'Ingresa el efectivo');
            return;
        }
        if($this->efectivo > $this->efectivo)
        {
            $this->emit('sale-error', 'El efectivo debe ser mayor o igual al total');
            return;
        }
        DB::beginTransaction();

        try {
            $sale = Sale::create([
                'total' => $this->total,
                'items' => $this->itemsQuantity,
                'cash' => $this->efectivo,
                'change' => $this->change,
                'user_id' => Auth()->user()->id
            ]);

            if ($sale) {
                $items = Cart::getContent();
                foreach($items as $item) {
                    SaleDetail::create([
                        'price' => $item->price,
                        'quantity' => $item->quantity,
                        'product_id' => $item->id,
                        'sale_id' => $sale->id
                    ]);

                    // update stock
                    $product = Product::find($item->id);
                    $product->stock = $product->stock - $item->quantity;
                    $product->save();
                }
            }

            DB::commit();

            Cart::clear();
            $this->efectivo = 0;
            $this->change = 0;
            $this->total = Cart::getTotalQuantity();
            $this->emit('sale-ok', 'Venta registrada con éxito');
            $this->emit('print-ticket', $sale->id);

        } catch (\Exception $e) {
            DB::rollBack();
            $this->emit('sale-error', $e->getMessage());
        }
    }

    public function printTicket($sale)
    {
        /** Aplicación en C# lo detecta */
        return Redirect::to("print://$sale->id");
    }
}
