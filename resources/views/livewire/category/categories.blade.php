<div class="row sales layout-top-spacing">

    <div class="col-sm-12">
        <div class="widget widget-chart-one">
            <div class="widget-heading">
                <h4 class="card-title">
                    <b>{{$componentName}} | {{$pageTitle}}</b>
                </h4>
                <ul class="tabs tabs-pills">
                    <li>
                        <a href="javascript:void(0)" class="tabmenu" data-toggle="modal" data-target="#theModal" style="background-color: #343a40!important; padding: 12px 24px">Agregar</a>
                    </li>
                </ul>
            </div>
            Search

            <div class="widget-content">
                <div class="table-responsive">
                <table class="table-bordered table striped mt-1">
                    <thead class="" style="font-size: .875rem; color: black!important;">
                        <tr>
                            <th class="table-th">DESCRIPCIÓN</th>
                            <th class="table-th">IMAGEN</th>
                            <th class="table-th">ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categories as $category)
                        <tr>
                            <td><h6>{{ $category->name }}</h6></td>
                            <td class="text-center">
                                <span>
                                    <img src="{ asset('storage/categories/' . $category->image ) }" alt="imagen de ejemplo" height="70" width="80" class="rounded">
                                </span>
                            </td>
                            <td class="text-center">
                                <a href="javascript:void(0)" class="shadow-none btn green mtmobile" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="javascript:void(0)" 
                                onclick="Confirm('{{$category->id}}')" 
                                class="shadow-none btn green1" title="Delete">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                Pagination
            </div>
            </div>
        </div>
    </div>

    Include Form
</div>

<script>
    document.addEventListener('DOMContentLoaded', function (){
        
        window.livewire.on('category-added', msg => {
            $('#theModal').modal('hide');
            noty(msg)
        })
        window.livewire.on('category-updated', msg => {
            $('#theModal').modal('hide');
            noty(msg)
        })
        window.livewire.on('hide-modal', msg => {
            $('#theModal').modal('hide');
        })
        window.livewire.on('show-updated', msg => {
            $('#theModal').modal('show');
        })
        window.livewire.on('hidden.bs.modal', msg => {
            $('.er').css('display','none');
        })
    });

function Confirm(id) {
    swal({
        title: 'CONFIRMAR',
        text: '¿CONFIRMAS ELIMINAR EL REGISTRO',
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
