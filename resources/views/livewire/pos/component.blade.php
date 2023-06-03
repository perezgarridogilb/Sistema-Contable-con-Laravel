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

<script src="{{ asset('js/keypress.js')}}"></script>
<script src="{{ asset('js/onscan.js')}}"></script>

@include('livewire.pos.scripts.shortcuts')
@include('livewire.pos.scripts.events')
@include('livewire.pos.scripts.general')
@include('livewire.pos.scripts.scan')
