<div class="flex flex-col space-y-2 sm:flex-row sm:space-y-0">

    <a class="font-bold sm:hidden" href="https://sima-land.ru{{ $item['url'] }}">
        {{ $item['name'] }}
    </a>

    <div class="flex space-x-4 sm:space-x-10">

        <a href="https://sima-land.ru{{ $item['url'] }}" title="{{ $item['name'] }}">
            <img 
                class="rounded-lg max-w-sm" 
                src="{{ $item['img'] }}" 
                alt="{{ $item['name'] }}"
            >
        </a>

        <div class="flex flex-col">

            <a class="font-bold text-primary hidden sm:block" href="https://sima-land.ru{{ $item['url'] }}">{{ $item['name'] }}</a>

            <div class="space-x-1">
                <i class="text-accent fas fa-tag"></i>
                <span class="text-accent">Артикул:</span>
                <span>{{ $item['sid'] }}</span>
            </div>

            <div class="flex space-x-1">
                <i class="text-accent fas fa-coins"></i>
                <span class="text-accent">Цена:</span>
                <span>
                    @ordercan($item, 'refresh')
                        <x-button
                            icon="redo"
                            wire:click="updatePrice"
                            class="xs {{ isNewColor($item['updated_at']) }}"
                            title="{{ __('refresh') }}"
                        >

                            {{ $item['price'] }}
                            {{ data_get($item, 'currency', '') }}

                        </x-button>
                    @else
                        {{ $item['price'] }}
                        {{ data_get($item, 'currency', '') }}
                    @endordercan
                </span>
            </div>

            <div class="space-x-1">
                <i class="text-accent fas fa-cubes"></i>
                <span class="text-accent">Минимум:</span>
                <span>
                    {{ $item['min_qty'] }}
                    {{ data_get($item, 'plural_name_format', '') }}
                </span>
            </div>

            @order($item)
                <div class="space-x-1">
                    <i class="text-accent fas fa-clock"></i>
                    <span class="text-accent">Создан:</span>
                    <span>{{ dateToShow($item['created_at']) }}</span>
                </div>
            @endorder

            @if (false && $item['cart_status_id'])
                @php
                    $component = 'messages.'. $item->cartStatus->status->slug;
                @endphp

                {{--  <x-dynamic-component :component="$component" size="xs" icon="{{$item->cartStatus->status->icon}}">
                    {{ $item->cartStatus->name }}
                </x-dynamic-component>  --}}
            @endif

        </div>

    </div>

</div>
