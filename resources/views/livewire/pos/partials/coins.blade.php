<div class="row mt-3">
    <div class="col-sm-12">

        <div class="connect-sorting">
            <h5 class="text-center mb-3">Denominaciones</h5>
          <div class="container">
              <div class="row" style="">
                @foreach ($denominations as $index => $d)
                <div class="col-sm-4 {{ $index === count($denominations) - 1 ? ' col-sm-12' : '' }} mt-2" style="padding: 10px auto 10px auto;!important;">
                    <button wire:click.prevent="ACash({{$d->value}})" class="btn btn-dark btn-block den" style="padding: 0.4375rem 0;">
                        {{ $d->value > 0 ? '$' . number_format($d->value,2, '.', '') : 'Exacto' }}
                    </button>
                  </div>
                  @endforeach
                </div>
            </div>
            <div class="connect-sorting-content mt-4">
                <div class="card simple-title-task ui-sortable-handles">
                    <div class="card-body">
                    <div class="input-group input-group-md mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text input-gp hideonsm" style="background: #3B3F5C; color: white;">
                                Efectivo
                            </span>
                        </div>
                        <input type="number" id="cash" wire:model="efectivo" wire:keydown.enter="saveSale" class="form-control text-center" value="{{$efectivo}}">
                        <div class="input-group-append">
                            <span wire:click="$set('efectivo', 0)" class="input-group-text" style="background: #3B3F5C; color: white">
                                <i class="bi bi-backspace-fill bi-lg" style="width: 2em"></i>

                            </span>
                        </div>
                    </div>

                    <h4 class="text-muted">Cambio: ${{number_format($change, 2)}}</h4>
                    <div class="row d-flex text-center justify-content-around mt-5">
                        @if ($total > 0)                            
                        <div class="col-6 col-sm-6 col-md-6 col-lg-5 m-sm-0 m-md-3 m-lg-1">
                            <button onclick="Confirm('','clearCart', '¿Seguro de eliminar el carrito?')" class="btn btn-dark">
                                Cancelar
                            </button>
                        </div>
                        @endif
                        <div class="col-6 col-sm-6 col-md-6 col-lg-5 pl-2 pr-4 m-sm-0 m-md-3 m-lg-1">
                            @if ($efectivo >= $total && $total > 0)
                            <button wire:click.prevent="saveSale" class="btn btn-dark ">Guardar</button>
                                
                            @endif
                        </div>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>