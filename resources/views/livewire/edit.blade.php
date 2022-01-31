<div class="space-y-2 livewire-edit">

    <form wire:submit.prevent='update' class="flex {{ $styles }}">

        @foreach($fields as $field => $value)
            <x-input wire:model.delay.99999s='fields.{{ $field }}' 
                class="{{ $size }} w-full"
                placeholder="{{ __($field) }}"    
            ></x-input>    
        @endforeach
        
        <x-button wire:target='update' class="color-success {{ $size }}" icon="check">{{ __('update') }}</x-button>

    </form>

    <x-success></x-success>

</div>
