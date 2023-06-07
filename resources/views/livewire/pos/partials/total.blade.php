<div class="row">
    <div class="col-sm-12">
        <div>
            <div class="connect-sorting">
                <h5 class="text-center">Usuario:  User</h5>
                <h5 class="text-center mb-3">Resumen de venta</h5>
                <div class="connect-sorting-content">
                    <div class="card simple-title-task ui-sortable-handle">
                        <div class="card-body">
                            <div class="task-header">
                                <div>
                                    <h2>Total: ${{number_format($total,2)}}</h2>
                                    <input type="hidden" id="hiddenTotal" value="{{$total}}">
                                </div>
                                <div>
                                    <h6 class="mt-3">Artículos: {{$itemsQuantity}}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>