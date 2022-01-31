<div class="container space-y-8">

    <div class="flex justify-end">        
        <div class='flex sm:row space-x-2 base-block bg-default m'>
            <x-input wire:model='filters.title' class="s border-none bg-default-light text-default-lightest">
                <i class="text-default-lightest fas fa-tag"></i>
            </x-input>
            <x-input wire:model='filters.user' class="s border-none bg-default-light text-default-lightest">
                <i class="text-default-lightest fas fa-user"></i>
            </x-input>
        </div>
    </div>

    <div class='flex flex-col space-y-4 sm:space-y-10'>
        @forelse($orders as $order)

            <livewire:order.show :order="$order" :key="'order-show-'.$order->id" />

        @empty
        @endforelse
    </div>
</div>
