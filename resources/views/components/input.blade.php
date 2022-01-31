<div class="flex flex-col">

    <div class="flex">

        <i class="{{ $attributes->size() }} fa-fw bg-default text-white rounded-l fas fa-{{ $attributes->icon('model') }}"
        ></i>

        <input {{ $attributes->merge(['class' => "border border-default rounded-r"]) }}
            type="{{ $attributes->type() }}" 
            placeholder='{{$attributes->placeholder()}}'
        >
        
    </div>
    
    @if (false)
        <div 
            class = "input-wrapper flex justify-center items-center space-x-2 rounded shadow 
                {{ $attributes->withoutClasses(['w-']) }}"
            {{ $attributes->whereDoesntStartWith(['class', 'wire:model']) }}
        >

            <i class="fas fa-fw fa-{{ $attributes->icon('model') }}"></i>

            {{ $slot }}

            <input 
                {{ $attributes->wire('model') }}
                type="{{ $attributes->type() }}" 
                placeholder='{{$attributes->placeholder()}}' 
                class="border-none bg-transparent outline-none p-0 m-0 {{ $attributes->onlyClasses(['text', 'placeholder', 'w-']) }}"
            >

            {{ $after ?? '' }}

            
            
        </div>
    @endif
    

    <x-error>{{ $attributes->prop('model') }}</x-error>

</div>