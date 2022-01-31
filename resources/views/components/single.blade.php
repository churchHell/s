<form {{ $attributes->wire('submit') }}>

    <x-input
        {{ $attributes->whereDoesntStartWith(['wire:submit'])->merge(['class' => '']) }}
    >

        <x-slot name='after'>
            <x-button 
                type="submit" 
                icon="{{ $attributes['btnicon'] ?? 'plus' }}"
                wire:target="{{ $attributes->firstProp(['target', 'submit']) }}"
            ></x-button>
        </x-slot>

    </x-input> 
    
    <x-success></x-success>

</form>