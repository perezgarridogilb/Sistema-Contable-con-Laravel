<div class="connect-sorting">
    <div class="connect-sorting-contenct">
        <div class="card simple-title-task ui-sortable-handle">
            <div class="card-body">
                @if ($total > 0)
                <div class="table-responsive tblscroll" style="max-height: 650px; overflow:hidden">
                    <table class="table table-bordered table-striped mt-1">
                        <thead class="text-center" style="font-size: 1rem; color: black!important;">
                            <tr>
                                <th width="10%"></th>
                                <th class="table-th text-left">Descripción</th>
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
                                    <button onclick="Confirm('{{$item->id}}', 'removeItem', '¿Confirmas eliminar el registro?')" 
                                        class="btn shadow-none green mtmobile lg-mr-2 mb-lg-1 mb-md-1 mb-sm-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" style="color: #0fadc8;" fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16">
                                           <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z"/>
                                         </svg>
                                    </button>
                                    <button wire:click.prevent="decreaseQty('{{$item->id}}')" 
                                        class="btn shadow-none green mtmobile lg-mr-2 mb-lg-1 mb-md-1 mb-sm-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" style="color: #0fadc8;" fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16">
                                           <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z"/>
                                         </svg>
                                    </button>
                                    <button wire:click.prevent="increaseQty('{{$item->id}}')" 
                                        class="btn shadow-none green mtmobile lg-mr-2 mb-lg-1 mb-md-1 mb-sm-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" style="color: #0fadc8;" fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16">
                                           <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z"/>
                                         </svg>
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <h5 class="text-center text-muted">Agrega Productos A La Venta</h5>
            @endif

            <div wire:loading.inline wire:target="saveSale">
                <h4 class="text-danger text-center">Guardando Venta...</h4>
            </div>
        </div>
    </div>
</div>
</div>