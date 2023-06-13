<div class="row sales layout-top-spacing">

    <div class="col-sm-12">
        <div class="widget widget-chart-one">
            <div class="widget-heading">
                <div class="col-sm-8">
                    <h4 class="card-title">
                        <b>{{$pageTitle}} de {{$componentName}}</b>
                    </h4>
                    @include('common.searchbox')
                </div>
                <div class="col-sm-4 text-center d-flex align-items-center">
                <ul class="tabs tabs-pills">
                    <li>
                        <a href="javascript:void(0)" class="tabmenu" data-toggle="modal" data-target="#theModal" style="background-color: #343a40!important; padding: 12px 24px">Registrar</a>
                    </li>
                </ul>
                </div>

            </div>

            <div class="widget-content">
                <div class="table-responsive">
                    <table class="table-borderless table striped mt-1">
                        <thead class="text-center" style="font-size: 1rem; color: black!important;">
                        <tr>
                            <th class="table-th">Id</th>
                            <th class="table-th text-center">Descripción</th>
                            <th class="table-th text-center">Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($permisos as $permiso)
                        <tr>
                            <td><h6>{{$permiso->id}}</h6></td>
                            <td class="text-center">
                                <h6>{{$permiso->name}}</h6>
                            </td>
                            <td class="text-center">
                                <a href="javascript:void(0)" 
                                wire:click="Edit({{$permiso->id}})"
                                class="btn shadow-none green mtmobile lg-mr-2 mb-lg-1 mb-md-1 mb-sm-1" title="Edit">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                   <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                   <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                                 </svg>
                                </a>
                                <a href="javascript:void(0)" 
                                onclick="Confirm('{{$permiso->id}}')"
                                class="btn shadow-none green1 lg-ml-2 mt-lg-1 mt-md-1 mt-sm-1" title="Delete">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" style="color: #0fadc8;" fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16">
                                   <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z"/>
                                 </svg>
                                </a>
                            </td>
                        </tr>
                            
                        @endforeach
                    </tbody>
                </table>
                <div class="d-flex justify-content-center">
                    <nav class="text-center">
                        {{ $permisos->links() }}
                    </nav>
                </div>
            </div>
            </div>
        </div>
    </div>

    @include('livewire.permisos.form')
</div>

<script>
    document.addEventListener('DOMContentLoaded', function (){
        window.livewire.on('permiso-added', Msg => {
            $('#theModal').modal('hide')
            noty(Msg)
        })
        window.livewire.on('permiso-updated', Msg => {
            $('#theModal').modal('hide')
            noty(Msg)
        })
        window.livewire.on('permiso-deleted', Msg => {
            noty(Msg)
        })
        window.livewire.on('permiso-exists', Msg => {
            noty(Msg)
        })
        window.livewire.on('hide-modal', Msg => {
            $('#theModal').modal('hide')
        })
        window.livewire.on('show-modal', Msg => {
            $('#theModal').modal('show')
        })
    });

    function Confirm(id, products) {
    if(products > 0)
    {
        swal('No se puede eliminar la categoría porque tiene productos relacionados')
        return 0;
    }

    swal({
        title: 'Confirmar',
        text: '¿Desea corfirmar eliminar el registro?',
        type: 'warning',
        showCancelButton: true,
        cancelButtonText: 'Cerrar',
        cancelButtonColor: '#fff',
        confirmButtonText: 'Aceptar',
        confirmButtonColor: '#3B3F5C'
        }).then(function(result) {
            if (result.value) {
                window.livewire.emit('destroy', id)
                swal.close()
            }
        })
} 
</script>
