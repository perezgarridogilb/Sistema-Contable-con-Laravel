<div wire:ignore.self class="modal fade" id="modalDetails" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h5 class="modal-title text-white">
                    <b>Detalle de venta # {{ $saleId }}</b>
                </h5>
                <h6 class="text-center text-warning" wire:loading>Por favor espere</h6>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table-borderless table striped mt-1">
                        <thead class="text-center" style="font-size: 1rem; color: black!important;">
                            <tr>
                                <th class="table-th text-center">Folio</th>
                                <th class="table-th text-center">DD</th>
                                <th class="table-th text-center">Producto</th>
                                <th class="table-th text-center">Precio</th>
                                <th class="table-th text-center">Cant</th>
                                <th class="table-th text-center">Importe</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($details as $d)
                            <tr>
                                
                                
                                <td class="text-center">
                                    <h6>{{ $d->id }}</h6>
                                            
                                </td>
                                <td><h6>{{ number_format ($d->id, 2) }}</h6></td>
                                <td class='text-center'><h6>{{$d->product}}</h6></td>
                                <td class='text-center'><h6>{{number_format($d->price,2)}}</h6></td>
                                <td class='text-center'><h6>{{number_format($d->quantity,0)}}</h6></td>
                                <td class='text-center'><h6>{{number_format($d->price * $d->quantity,2)}}</h6></td>               
                               

                              
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3"><h5 class="text-center font-weight-bold"></h5></td>
                                <td><h5 class="text-center">{{ $countDetails }}</h5></td>
                                {{-- Suma de los importes --}}
                                <td><h5 class="text-center">{{ number_format ($sumDetails, 2) }}</h5></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-dark close-btn text-info" data-dismiss="modal">CERRAR</button>
            
            </div>
            </div>
            </div>
            </div>
  