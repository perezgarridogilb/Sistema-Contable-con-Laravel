<div class="connect-sorting">
    <div class="connect-sorting-contenct">
        <div class="card simple-title-task ui-sortable-handle">
            <div class="card-body">
                @if ($total > 0)
                <div class="table-responsive tblscroll" style="max-height: 650px; overflow:hidden">
                    <table class="table table-bordered table-striped mt-1">
                        <thead class="text-center" style="font-size: 1rem; color: black!important;">
                            <tr>
                                <th class="table-th text-center" width="30%">Descripción</th>
                                <th class="table-th text-center">Precio</th>
                                <th width="13%" class="table-th text-center">Cant</th>
                                <th class="table-th text-center">Importe</th>
                                <th class="table-th text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($cart as $item)                                
                            <tr>
                                <td class="text-center table-th">
                                    @if (count($item->attributes) > 0)                                    
                                    <span>
                                        <img src="{{ asset('storage/products/' . $item->attributes[0]) }}" alt="imagen de producto" height="90" width="90" class="rounded">
                                    </span>
                                    @endif
                                </td>
                                <td><h6>{{ $item->name }}</h6></td>
                                <td>${{number_format($item->price,2)}}</td>
                                <td>
                                    <input type="number" id="r{{$item->id}}"
                                    wire:change="updateQty({{$item->id}}, $('#r' + {{$item->id}}.val() )"
                                    style="font-size: 1rem!important" class="form-control text-center" value="{{$item->quantity}}">
                                </td>
                                <td>
                                    <h6>
                                        ${{number_format($item->price * $item->quatity, 2)}}
                                    </h6>
                                </td>
                                <td>
                                    <button onclick="Confirm('{{$item->id}}', 'removeItem', '¿CONFIRMAS ELIMNAR EL REGISTRO?')" 
                                        class="btn shadow-none green mtmobile lg-mr-2 mb-lg-1 mb-md-1 mb-sm-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
                                            <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854Z"/>
                                          </svg>
                                    </button>
                                    <button wire:click.prevent="decreaseQty({{$item->id}})" 
                                        class="btn shadow-none green mtmobile lg-mr-2 mb-lg-1 mb-md-1 mb-sm-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-dash" viewBox="0 0 16 16">
                                            <path d="M4 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 4 8z"/>
                                          </svg>
                                    </button>
                                    <button wire:click.prevent="increaseQty('{{$item->id}}')" 
                                        class="btn shadow-none green mtmobile lg-mr-2 mb-lg-1 mb-md-1 mb-sm-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-lg" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd" d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2Z"/>
                                          </svg>
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <h5 class="text-center text-muted">Agrega productos para realizar ventas</h5>
            @endif

            <div wire:loading.inline wire:target="saveSale">
                <h4 class="text-danger text-center">Guardando Venta...</h4>
            </div>
        </div>
    </div>
</div>
</div>