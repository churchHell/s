<div class='flex space-x-2'>
    
    <x-button
        wire:click="yes"
        icon="check"
        class="xs color-success"
    >
        {{ __('yes') }}
    </x-button>

    <x-button
        wire:click="no"
        icon="times"
        class="xs color-error"
    >
        {{ __('no') }}
    </x-button>

</div>
