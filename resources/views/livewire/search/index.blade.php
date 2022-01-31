<div class="container">

    <div class="flex flex-col sm:flex-row space-y-1 sm:space-y-0 justify-between items-center py-8">

        <div>
            <x-a 
                icon='home' 
                href="{{ route('index') }}" 
                class='btn m color-info' 
                title="{{ __('main') }}"
            >
                {{ __('main') }}
            </x-a>
        </div>

        <div class="flex flex-col items-end">
            <x-single 
                wire:model.delay.99999s='sid' 
                wire:submit.prevent='search' 
                btnicon='search'
                class='w-30 color-accent m'
            ></x-single>
        </div>

    </div>

    <div class="space-y-4">

        @forelse ($items as $key => $item)

            <livewire:search.show 
                :group="$group" 
                :item="$item" 
                :itemKey="$key" 
                :key="'search-show-'.$key" 
            />

        @empty
        @endforelse

    </div>

</div>
