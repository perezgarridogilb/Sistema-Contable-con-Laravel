<div class="roe sales layout-top-spcing">
    <div class="col-sm-12">
        <div class="widget widget-chart-one">
            <div class="widget-heading">
                <h4 class="card-title text-center"><b>Corte de caja</b></h4>
            </div>

            <div class="widget-content">
                <div class="row">
                    <div class="col-sm-12 col-ms-3">
                        <div class="form-group">
                            <label>Usuario</label>
                            <select wire:model="userid">
                                <option value="0" disabled>Elegir</option>
                                @foreach ($users as $u)
                                   <option value="{{ $u->id }}">{{ $u->name }}</option> 
                                @endforeach
                            </select>
                            @error('userid') <span class="text-danger">{{ message }}</span> @enderror
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-3">
                        <div class="form-group">
                            <label>Fecha inicial</label>
                            <input type="date" wire:model.lazy="fromDate" class="form-control">
                            @error('fromDate') <span class="text-danger">{{ message }}</span> @enderror
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-3">
                        <div class="form-group">
                            <label>Fecha final</label>
                            <input type="date" wire:model.lazy="toDate" class="form-control">
                            @error('toDate') <span class="text-danger">{{ message }}</span> @enderror
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-3 align-self-center d-flex justify-content-around">
                        @if ($userid > 0 && $fromDate != null && $toDate != null)
                        <button wire:click.prevent="Consultar" type="button" class="btn btn-dark">Consultar</button>
                            
                        @endif
@if ($total > 0)
<button wire:click prevent="Print()" type="button" class="btn btn-dark">Imprimir</button>
    
@endif
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>