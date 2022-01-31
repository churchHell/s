<div class="modal absolute bg-default flex flex-col rounded shadow-md">
    <div class="bg-default-dark text-default-semilight s flex justify-between items-center space-x-2 rounded-t">
        <span class="">{{ $title ?? '' }}</span>
        <i wire:click.prevent="$emit('modalClose')" class="fas fa-times"></i>
    </div>
    <div class="s my-2 flex space-x-2">
        {{ $slot }}
    </div>
</div>