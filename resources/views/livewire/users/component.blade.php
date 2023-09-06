<div class="row sales layout-top-spacing">

    <div class="col-sm-12">
        <div class="widget widget-chart-one">
            <div class="widget-heading">
                <div class="col-sm-8">
                    <h4 class="card-title">
                        <b>{{$pageTitle}} de {{$componentName}}</b>
                    </h4>
                    @can('Product_Search')  
                    @include('common.searchbox')
                    @endcan
                </div>
                <div class="col-sm-4 text-center d-flex align-items-center justify-content-center">
                <ul class="tabs tabs-pills">
                    @can('Product_Create')   
                    <li>
                        <a href="javascript:void(0)" class="tabmenu" data-toggle="modal" data-target="#theModal" style="background-color: #343a40!important; padding: 12px 24px">Registrar</a>
                    </li>
                    @endcan
                </ul>
                </div>

            </div>

            <div class="widget-content">

                <div class="table-responsive">
                    <table class="table-borderless table striped mt-1">
                        <thead class="text-center" style="font-size: 1rem; color: black!important;">
                            <tr>
                                <th class="table-th">USUARIO</th>
                                <th class="table-th text-center">TELÉFONO</th>
                                <th class="table-th text-center">EMAIL</th>
                                <th class="table-th text-center">ESTATUS</th>
                                <th class="table-th text-center">PERFIL</th>
                                <th class="table-th text-center">IMÁGEN</th>
                                <th class="table-th text-center">ACTIONS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $r)
                            <tr>
                                <td><h6>{{$r->name}}</h6></td>
                                
                                <td class="text-center"><h6>{{$r->phone}}</h6></td>
                                <td class="text-center"><h6>{{$r->email}}</h6></td>
                                <td class="text-center">
                                    <span class="badge {{ $r->status == 'Active' ? 'badge-success' : 'badge-danger' }} text-uppercase">{{$r->status}}</span>
                                </td>
                                <td class="text-center text-uppercase">
                                    <h6>{{$r->profile}}</h6>
                                    {{-- <small><b>Roles:</b>{{implode(',',$r->getRoleNames()->toArray())}}</small> --}}
                                </td>

                                <td class="text-center">
                                 @if($r->image != null) 
                                 <img class="card-img-top img-fluid"                                             
                                 src="{{ asset('storage/users/'.$r->image) }}" 
                                 > 
                                 @endif                                  
                             </td>

                             <td class="text-center">
                                <a href="javascript:void(0)" 
                                wire:click="edit({{$r->id}})"
                                class="btn btn-dark mtmobile" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            @if(Auth()->user()->id != $r->id)
                            <a href="javascript:void(0)" 
                            onclick="Confirm('{{$r->id}}')" 
                            class="btn btn-dark" title="Delete">
                            <i class="fas fa-trash"></i>
                        </a>
                        @endif


                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="d-flex align-items-center justify-content-center">
            <nav class="text-center">
                {{ $data->links() }}
            </nav>
        </div>
    </div>

</div>


</div>


</div>

@include('livewire.users.form')
</div>


<script>
    document.addEventListener('DOMContentLoaded', function(){
        window.livewire.on('user-added', Msg => {
            $('#theModal').modal('hide')
            resetInputFile()
            noty(Msg)
        })
        window.livewire.on('user-updated', Msg => {
            $('#theModal').modal('hide')
            resetInputFile()
            noty(Msg)
        })
        window.livewire.on('user-deleted', Msg => {           
            noty(Msg)
        })
        window.livewire.on('hide-modal', Msg => {           
            $('#theModal').modal('hide')
        })
        window.livewire.on('show-modal', Msg => {           
            $('#theModal').modal('show')
        })
        window.livewire.on('user-withsales', Msg => {           
            noty(Msg)
        })

    })

    function resetInputFile()
    {        
        $('input[type=file]').val('');
    }
    

    function Confirm(id)
    {   

        swal({
            title: 'CONFIRMAR',
            text: '¿CONFIRMAS ELIMINAR EL REGISTRO?',
            type: 'warning',
            showCancelButton: true,
            cancelButtonText: 'Cerrar',
            cancelButtonColor: '#fff',
            confirmButtonColor: '#3B3F5C',
            confirmButtonText: 'Aceptar'
        }).then(function(result) {
            if(result.value){
                window.livewire.emit('deleteRow', id)
                swal.close()
            }

        })
    }
    

</script>