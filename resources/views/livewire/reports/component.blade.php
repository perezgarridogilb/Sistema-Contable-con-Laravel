<div class="row sales layout-top-spacing">

    <div class="col-sm-12">
        <div class="widget">
            <div class="widget-heading">
                <h4 class="card-title text-center"><b>{{ $componentName }}</b></h4>
            </div>

            <div class="widget-content">
                <div class="row">
                    <div class="col-sm-12 col-md-3">
                        <div class="row">
                            <div class="col-sm-12">
                                <h6>Elige el usuario</h6>
                                <div class="form-group">
                                    <select wire:model="userId" class="form-control">
                                        <option value="0">Todos</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <h6>Elige el tipo de reporte</h6>
                                <div class="form-group">
                                    <select wire:model="reportType" class="form-control">
                                        <option value="0">Ventas por día</option>
                                        <option value="1">Ventas por fecha</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12 mt-2">
                                <h6>Fecha desde</h6>
                                <div class="form-group">
                                    <input type="text" wire:model="dateFrom" class="form-control flatpickr" placeholder="Click para elegir">
                                </div>
                            </div>
                            <div class="col-sm-12 mt-2">
                                <h6>Fecha hasta</h6>
                                <div class="form-group">
                                    <input type="text" wire:model="dateTo" class="form-control flatpickr" placeholder="Click para elegir">
                                </div>
                            </div>
                            <div class="col-sm-12">
{{--                                 <button wire:click="$refresh" class="btn btn-dark btn-block">
                                    Consultar
                                </button> --}}
                                {{-- construyendo la url con los parámetros --}}
                                <a class="btn btn-dark btn-block {{count($data) <1 ? 'disabled' : '' }}" 
                                href="{{ url('report/pdf' . '/' . $userId . '/' . $reportType . '/' . $dateFrom . '/' . $dateTo) }}" target="_blank">Generar PDF</a>

                                <a  class="btn btn-dark btn-block {{count($data) <1 ? 'disabled' : '' }}" 
                                href="{{ url('report/excel' . '/' . $userId . '/' . $reportType . '/' . $dateFrom . '/' . $dateTo) }}" target="_blank">Exportar a Excel</a>
                            </div>
                        </div>
                    </div>
                        <div class="col-sm-12 col-md-9">
                            {{-- Tabla --}}
                                        <div class="table-responsive">
                <table class="table-borderless table striped mt-1">
                    <thead class="text-center" style="font-size: 1rem; color: black!important;">
                        <tr>
                            <th class="table-th text-center">Folio</th>
                            <th class="table-th text-center">Total</th>
                            <th class="table-th text-center">Items</th>
                            <th class="table-th text-center">Estatus</th>
                            <th class="table-th text-center">Usuario</th>
                            <th class="table-th text-center">Fecha</th>
                            <th class="table-th text-center" width="50px">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($data) < 1)
                        <tr>
                            <td colspan="7"><h5>Sin resultados</h5></td>
                        </tr>    
                        @endif
                        @foreach ($data as $d)
                        <tr>
                            <td class="text-center" style="height: 95px!important;"><h6>{{ $d->id }}</h6></td>
                            <td class="text-center" style="height: 95px!important;"><h6>{{ number_format($d->total, 2) }}</h6></td>
                            <td class="text-center" style="height: 95px!important;"><h6>{{ $d->items }}</h6></td>
                            <td class="text-center" style="height: 95px!important;"><h6>{{ $d->status }}</h6></td>
                            <td class="text-center" style="height: 95px!important;"><h6>{{ $d->user }}</h6></td>
                            <td class="text-center" style="height: 95px!important;">
                                <h6>
                                {{ \Carbon\Carbon::parse($d->created_at)->format('d-m-Y') }}
                                </h6>
                            </td>
                            <td class="text-center" style="height: 95px!important;" width="50px">
                                <button wire:click.prevent="getDetails({{$d->id}})" class="btn btn-dark btn-sm">
                                    <i class="fas fa-list"></i>
                                </button>
                            </td>
                            
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
    @include('livewire.reports.sales-detail')
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
  flatpickr(document.getElementsByClassName('flatpickr'), {
    enableTime: false,
    dateFormat: 'Y-m-d',
    locale: {
      firstDayofWeek: 1,
      weekdays: {
        shorthand: ["Dom", "Lun", "Mar", "Mié", "Jue", "Vie", "Sáb"],
        longhand: [
          "Domingo",
          "Lunes",
          "Martes",
          "Miércoles",
          "Jueves",
          "Viernes",
          "Sábado",
        ],
      },
      months: {
        shorthand: [
          "Ene",
          "Feb",
          "Mar",
          "Abr",
          "May",
          "Jun",
          "Jul",
          "Ago",
          "Sep",
          "Oct",
          "Nov",
          "Dic",
        ],
        longhand: [
          "Enero",
          "Febrero",
          "Marzo",
          "Abril",
          "Mayo",
          "Junio",
          "Julio",
          "Agosto",
          "Septiembre",
          "Octubre",
          "Noviembre",
          "Diciembre",
        ],
      },

    }
  })
  /** Eventos */
  window.livewire.on('show-modal', Msg => {
            $('#modalDetails').modal('show')
        })
})
</script>
