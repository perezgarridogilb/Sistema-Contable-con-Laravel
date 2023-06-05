<div class="row sales layout-top-spacing">

    <div class="col-sm-12">
        <div class="widget widget-chart-one">
            <div class="widget-heading">
                <h4 class="card-title">
                    <b>{{ $componentName }} {{ $pageTitle }}</b>
                </h4>
                <ul class="tabs tabs-pills">
                    <li>
                        <a href="javascript:void(0)" class="tabmenu bg-dark" data-toggle="modal" data-target="#theModal">Agregar</a>
                    </li>
                </ul>
            </div>
            @include('common.searchbox')

            <div class="widget-content">
                <div class="table-responsive">
                <table class="table-bordered table striped mt-1">
                    <thead class="text-white" style="background: #3b3f5c;">
                        <tr>
                            <th class="table-th text-white">ID</th>
                            <th class="table-th text-white">DESCRIPCIÓN</th>
                            <th class="table-th text-white">ACCIÓN</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($roles as $role)
                            
                        @endforeach
                        <tr>
                            <td><h6>{{$role->id}}</h6></td>
                            <td class="text-center">
                                <h6>{{$role->name}}</h6>
                            </td>
                            <td class="text-center">
                                <a href="javascript:void(0)" 
                                wire:click="Edit({{$role->id}})"
                                class="btn btn-dark mtmobile" title="Edit registro">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="javascript:void(0)" 
                                onclick="Confirm('{{$role->id}}')"
                                class="btn btn-dark" title="Eliminar registro">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="d-flex justify-content-center">
                    <nav class="text-center">
                        {{ $data->links() }}
                    </nav>
                </div>
            </div>
            </div>
        </div>
    </div>

    @include('livewire.roles.form')
</div>

<script>
    document.addEventListener('DOMContentLoaded', function (){
        window.livewire.on('role-added', Msg => {
            $('#theModal').modal('hide')
            noty(Msg)
        })
        window.livewire.on('role-updated', Msg => {
            $('#theModal').modal('hide')
            noty(Msg)
        })
        window.livewire.on('role-deleted', Msg => {
            noty(Msg)
        })
        window.livewire.on('role-exists', Msg => {
            noty(Msg)
        })
        window.livewire.on('hide-modal', Msg => {
            $('#theModal').modal('hide')
        })
        window.livewire.on('show-modal', Msg => {
            $('#theModal').modal('show')
        })
        window.livewire.on('hidden.bs.modal', Msg => {
            $('.er').modal('display','none')
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
                window.livewire.emit('deleteRow', id)
                swal.close()
            }
        })
} 
</script>
