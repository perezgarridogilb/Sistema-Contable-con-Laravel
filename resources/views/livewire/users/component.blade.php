<div class="row sales layout-top-spacing">

    <div class="col-sm-12">
        <div class="widget widget-chart-one">
            <div class="widget-heading">
                <h4 class="card-title">
                    <b>{{ $componentName }} | {{$pageTitle}}</b>
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
                            <th class="table-th text-white">USUARIO</th>
                            <th class="table-th text-white text-center">TELÉFONO</th>
                            <th class="table-th text-white text-center">EMAIL</th>
                            <th class="table-th text-white text-center">ESTATUS</th>
                            <th class="table-th text-white text-center">PERFIL</th>
                            <th class="table-th text-white text-center">IMAGEN</th>
                            <th class="table-th text-white text-center">ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $r)
                        <tr>
                            <td><h6>{{ $r->name }}</h6></td>
                            <td class="text-center"><h6>{{$r->phone}}</h6></td>
                            <td class="text-center"><h6>{{$r->email}}</h6></td>
                            <td class="text-center {{ $r->status == 'Active' ? 'badge-success' : 'badge-danger' }}">
                                <span>{{ $r->status }}</span>
                            </td>
                            <td class="text-center text-uppercase"><h6>{{$r->profile}}</h6></td>
                            <td class="text-center">
                                <span>
                                    @if ($r->image != null)
                                    <img src="{{ asset('storage/users/' . $r->image ) }}" alt="imagen" class="card-img-top img-fluid">
                                    @endif
                                </span>
                            </td>
                            <td class="text-center">
                                <a href="javascript:void(0)"
                                wire:click="edit({{ $r->id }})"
                                class="btn btn-dark mtmobile" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="javascript:void(0)" 
                                onclick="('{{ $r->id }}')"
                                class="btn btn-dark" title="Delete">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                            
                        @endforeach
                    </tbody>
                </table>
                {{ $data->links() }}
            </div>
            </div>
        </div>
    </div>

    @include('livewire.users.form')
</div>

<script>
    document.addEventListener('DOMContentLoaded', function (){
        window.livewire.on('user-added', Msg => {
            $(#theModal).modal('hide')
            /** Mensaje desde backend */
            noty(Msg)
        })
        window.livewire.on('user-updated', Msg => {
            $(#theModal).modal('hide')
            /** Mensaje desde backend */
            noty(Msg)
        })
        window.livewire.on('user-deleted', Msg => {
            /** Mensaje desde backend */
            noty(Msg)
        })
        window.livewire.on('hide-modal', Msg => {
            $('#theModal').modal('hide')
        })
        window.livewire.on('show-modal', Msg => {
            $('#theModal').modal('show')
        })
        /** En caso de ventas no relacionada */
        window.livewire.on('users-withsales', Msg => {
            noty(Msg)
        })

        function Confirm(id, products) {
    if(products > 0)
    {
        swal('No se puede eliminar la categoría porque tiene productos relacionados')
        return 0;
    }

    /** Eliminar */
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
        
    });
</script>
