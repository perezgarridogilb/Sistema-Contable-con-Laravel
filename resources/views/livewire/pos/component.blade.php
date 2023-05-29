<div>
    <style>

    </style>

    <div class="row">
        <div class="col-sm-12 col-md-8 pr-0">
            {{-- Detalles --}}
            @include('livewire.pos.partials.detail')
        </div>

        <div class="col-sm-12 col-md-4 pl-3">
            {{-- Total --}}
            @include('livewire.pos.partials.total')

            {{-- Denominations --}}
            @include('livewire.pos.partials.coins')
        </div>
    </div>
</div>

<script></script>
