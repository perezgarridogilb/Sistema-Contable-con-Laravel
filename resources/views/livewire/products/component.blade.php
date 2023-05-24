<div class="row sales layout-top-spacing">

    <div class="col-sm-12">
        <div class="widget widget-chart-one">
            <div class="widget-heading">
                <h4 class="card-title">
                    <b>{{ $pageTitle }} de {{ $componentName }}</b>
                </h4>
                <ul class="tabs tabs-pills">
                    <li>
                        <a href="javascript:void(0)" class="tabmenu bg-dark" data-toggle="modal" data-target="#theModal" style="background-color: #343a40!important; padding: 12px 24px">Agregar</a>
                    </li>
                </ul>
            </div>
            @include('common.searchbox')

            <div class="widget-content">
                <div class="table-responsive">
                <table class="table-borderless table striped mt-1">
                    <thead class="text-center" style="font-size: 1rem; color: black!important;">
                        <tr>
                            <th class="table-th text-center">DESCRIPCIÓN</th>
                            <th class="table-th text-center">BARCODE</th>
                            <th class="table-th text-center">CATEGORÍA</th>
                            <th class="table-th text-center">PRECIO</th>
                            <th class="table-th text-center">STOCK</th>
                            <th class="table-th text-center">INV.MIN</th>
                            <th class="table-th text-center">IMAGEN</th>
                            <th class="table-th text-center">ACCIÓN</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $product)
                        <tr>
                            <td class="text-left"><h6>{{$product->name}}</h6></td>
                            <td class="text-center"><h6>{{$product->barcode}}</h6></td>
                            <td class="text-center"><h6>{{$product->category}}</h6></td>
                            <td class="text-center"><h6>{{$product->price}}</h6></td>
                            <td class="text-center"><h6>{{$product->stock}}</h6></td>
                            <td class="text-center"><h6>{{$product->alerts}}</h6></td>
                            <td class="text-center">
                                <span>
                                    {{-- de image a imagen, ya que es accessor --}}
                                    <img src="{{ asset('storage/products/' .  $product->imagen)}}" alt="imagen de ejemplo" height="70" width="80" class="rounded">
                                </span>
                            </td>
                            <td class="text-center">
                                <a href="javascript:void(0)"
                                wire:click="Edit({{$product->id}})"
                                 class="btn shadow-none green mtmobile mr-2" title="Edit">
                                 <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                    <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                    <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                                  </svg>
                                </a>
                                <a href="javascript:void(0)"
                                onclick="Confirm('{{$product->id}}')"
                                 class="btn shadow-none green1 ml-2" title="Delete">
                                 <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" style="color: #0fadc8;" fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16">
                                    <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z"/>
                                  </svg>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{$data->links()}}
            </div>
            </div>
        </div>
    </div>

    @include('livewire.products.form')
</div>

<script>
    document.addEventListener('DOMContentLoaded', function (){
        window.livewire.on('product-added', msg => {
            $('#theModal').modal('hide');
        });
        window.livewire.on('product-updated', msg => {
            $('#theModal').modal('hide');
            noty(msg)
        })

        window.livewire.on('product-deleted', msg => {
            noty(msg)
        })
        /** Edit */
        window.livewire.on('modal-show', msg => {
            $('#theModal').modal('show');
            // noty(msg)
        })
        window.livewire.on('modal-hide', msg => {
            $('#theModal').modal('hide');
        })
        window.livewire.on('hidden.bs.modal', msg => {
            $('.er').css('display', 'none')
        })

    });
</script>
