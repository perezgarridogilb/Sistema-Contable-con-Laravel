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
use App\Traits\CartTrait;

class PosController extends Component
{
    use CartTrait;

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
		'scan-code'  =>  'ScanCode',
		'removeItem' => 'removeItem',
		'clearCart'  => 'clearCart',
		'saveSale'   => 'saveSale',
		'refresh' => '$refresh',
		'scan-code-byid' => 'ScanCodeById'
	];

    public function ScanCode($barcode, $cant = 1)
    {
        $this->ScanearCode($barcode, $cant);
    }

    public function increaseQty(Product $product, $cant = 1)
    {
    $this->IncreaseQuatity($product, $cant);        
    }

    /** Reemplazar la información del producto dentro del carrito, 
     * quita la información y la vuelve a poner */
    public function updateQty(Product $product, $cant = 1)
    {
        if ($cant <= 0) {
            $this->removeItem($product->id);
        } else {
            $this->updateQuantity($product, $cant);
        }
    }

    public function decreaseQty($productId)
{
    $this->decreaseQuantity($productId);
}

    public function clearCart()
    {
        $this->trashCart();
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
                    SaleDetails::create([
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
            $this->total = Cart::getTotal();
            $this->itemsQuantity = Cart::getTotalQuantity();

            $this->emit('sale-ok', 'Venta registrada con éxito');
            $this->emit('print-ticket', $sale->id);
        } catch (Exception $e) {
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
