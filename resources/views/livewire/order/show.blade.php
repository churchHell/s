<div class="flex flex-col items-start justify-between w-full space-x-0 space-y-2 order md:flex-row md:space-x-4 md:space-y-0">

    <div class="max-w-3xl">
        @include('layouts.item', ['item' => $order])
    </div>

    <div class="flex space-x-4">

        <div class="space-y-1 flex flex-col flex-no-wrap">

            @forelse ($order->users as $user)

                <div class="order__user space-x-2 flex flex-nowrap">

                    <span>
                        <div class="hidden sm:block whitespace-no-wrap">{{ $user->full_name }}</div>
                        <div class="sm:hidden whitespace-no-wrap">{{ $user->short_name }}</div>
                    </span>

                    <div class="space-x-2 flex whitespace-no-wrap">

                        @can('update', ['App\Models\Pivots\OrderUser', $user->pivot])

                            <x-button
                                wire:click="$set('editPivotId', {{ $user->pivot->id }})"
                                class="xs color-info"    
                                icon='cubes'                            
                                title="{{ __('edit') }}"
                            >
                                {{ $user->pivot->qty }} {{ $order->plural_name_format }}
                            </x-button>

                            <x-button
                                wire:click="updateDelivery({{ $user->pivot->id }})"
                                class="xs {{ isNewColor($user->pivot->updated_at) }}"    
                                icon='truck'                            
                                title="{{ __('refresh') }}"
                            >
                                {{ $user->pivot->delivery }} {{ $order->currency }}
                            </x-button>

                        @else

                            <span wire:click.prevent="$toggle('open')" class="xs rounded color-default space-x-1">
                                <i class="text-accent fas fa-cubes"></i>
                                <span>{{ $user->pivot->qty }} {{ $order->plural_name_format }}</span>
                            </span>

                            <span class="xs rounded space-x-1 {{ isNewColor($user->pivot->updated_at) }}">
                                <i class="fas fa-truck"></i>
                                <span>{{ $user->pivot->delivery }} {{ $order->currency }}</span>
                            </span> 

                        @endcan                

                    </div>

                    @if ($editPivotId == $user->pivot->id)
                        <x-modal title="{{ $user->short_name }}">
                            <livewire:edit class="\App\Models\Pivots\OrderUser" 
                                :row="$user->pivot->id"
                                :fields="['qty' => $user->pivot->qty]" 
                                :rules="$orderUserRules"
                                :key="'order-user-edit-'.$user->pivot->id" 
                            />
                            <livewire:delete class="\App\Models\Pivots\OrderUser" 
                                :row="$user->pivot->id"
                                :key="'order-user-delete-'.$user->pivot->id" 
                            />
                        </x-modal>
                    @endif

                </div>

            @empty

            @endforelse

            <div class="flex flex-col items-end space-y-2 pt-2">

                @can('join', $order)

                    <livewire:order.create :order="$order" :key="'order-create-'.$order->id" />

                @endcan

                <div class="w-full s color color-{{ $order->min_qty <= ($total = $order->users->sum('pivot.qty')) ? 'success' : 'error' }}">
                    Итого: {{ $total }}
                </div>

            </div>

        </div>

    </div>

</div>