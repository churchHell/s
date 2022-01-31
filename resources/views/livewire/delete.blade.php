<div class="">
    
    @if (!$confirm)
        <x-button wire:click.prevent="delete" class="color-error xs"></x-button>    
    @else
        <livewire:confirm />
    @endif
    
</div>
