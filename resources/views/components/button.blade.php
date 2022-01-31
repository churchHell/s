<button 

    wire:loading.attr="disabled"
    wire:loading.class="loading"
    wire:target="{{ $attributes->firstProp(['target', 'click']) }}"

    {{ $attributes->merge([
        'class' => 'flex items-center justify-center rounded shadow'
    ]) }}

    title="{{ $attributes->prop('title') ?? $attributes->lang('click') ?? $slot }}"

>

    <i class="preloader fas fa-spinner "></i>
    
    <span class="flex items-center justify-center space-x-2 whitespace-nowrap">

        <i class="fas fa-{{ $attributes->icon('click') }}"></i>

        @if (!empty($slot->toHtml()))
            <span>
                {{ $slot }}
            </span>
        @endif

    </span>

</button>
