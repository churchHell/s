<div
    class="flex flex-col md:flex-row justify-between items-start w-full space-x-0 md:space-x-4 space-y-2 md:space-y-0"
>

    @include('layouts.item', compact('item'))

    <div class="flex flex-col">

        <div class="flex items-stretch space-x-2 md:space-x-4">
            <x-single
                wire:submit.prevent="store"
                wire:model.delay.99999s="qty"
                icon='cubes'
                placeholder='qty'
                class='color-success s w-8'
            ></x-single>

            <x-button
                wire:click="remove" 
                class="s danger color-error"
                icon='trash'
            ></x-button>
        </div>

        <x-success></x-success>
        <x-error>item.sid</x-error>

    </div>

</div>