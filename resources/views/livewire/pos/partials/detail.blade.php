<div class="connect-sorting">
    <div class="connect-sorting-contenct">
        <div class="card simple-title-task ui-sortable-handle">
            <div class="card-body">
                <div class="table-responsive tblscroll" style="max-height: 650px; overflow:hidden">
                    <table class="table table-bordered table-striped mt-1">
                        <thead class="text-black">
                            <tr>
                                <th width="10%"></th>
                                <th class="table-th text-left text-white">DESCRIPCIÓN</th>
                                <th class="table-th text-center text-white">PRECIO</th>
                                <th width="13%" class="table-th text-center text-white">CANT</th>
                                <th class="table-th text-center text-white">IMPORTE</th>
                                <th class="table-th text-center text-white">ACTIONS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($card as $item)                                
                            <tr>
                                <td class="text-center table-th">
                                    @if (count($item->attributes) > 0)                                    
                                    <span>
                                        <img src="{{ asset('storage/products/' . $item->attributes[0]) }}" alt="imagen de producto" height="90" width="90" class="rounded">
                                    </span>
                                    @endif
                                </td>
                                <td><h6>{{ $item->name }}</h6></td>
                                <td>${{number_format($item->price,2)}}</td>
                                <td>
                                    <input type="number" id="r{{$item->id}}"
                                    wire:change="updateQty({{$item->id}}, $('#r' + {{$item->id}}.val() )"
                                    style="font-size: 1rem!important" class="form-control text-center" value="{{$item->quantity}}">
                                </td>
                                <td>
                                    <h6>
                                        ${{number_format($item->price * $item->quatity, 2)}}
                                    </h6>
                                </td>
                                <td></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>