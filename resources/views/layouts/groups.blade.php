<section class="relative bg-default-light text-default-lightest">


    <div class="container flex items-center justify-between flex-col sm:flex-row py-4 space-x-4">

        @if(empty($currentGroup))

            Групп нет. Обратитьесь к администрации

        @else

            <div class='flex flex-col w-full space-y-2'>

                <div class="flex space-x-4 items-center">

                    <span x-data="{ open : false }">

                        <div 
                            @click="open = !open" 
                            @keydown.escape="open = false" 
                            class="s color-accent btn center"
                        >

                            <span>
                                <i class="fas fa-layer-group"></i>
                                Группа #{{ $currentGroup->id }}
                            </span>

                            <i class="fas fa-chevron-down"></i>
                            
                        </div>

                        <div 
                            x-show="open" 
                            @click.away="open = false"
                            x-transition 
                            class="bg-default absolute rounded shadow text-white"
                            style="display: none;"
                        >
                            @foreach ($groups->except($currentGroup->id) as $group)
                                <a 
                                    href="{{ route($route ?? 'index', [$group->id]) }}" 
                                    title=" ___('group', 1) #{{$group->id}}"
                                >
                                    <div class="px-4 py-2 hover:bg-default-dark">
                                        Группа #{{$group->id}}
                                        <div class="text-sm italic text-default-lightest">
                                            {{ Str::words($group->comment, 5, '...') }}
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>

                    </span>

                    <span class='text-sm'>
                        <i class="fas fa-clock"></i>
                        {{ $groups->get($currentGroup->id)->created_at }}
                    </span>

                </div>
                
                @if (!empty($groups->get($currentGroup->id)->comment))

                    <div class="text-sm italic text-justify">
                        <i class="fas fa-comment text-accent"></i>
                        {{ $groups->get($currentGroup->id)->comment }}
                    </div>

                @endif
                
            </div>

            <div class="flex space-x-4">

                @route(['index', 'search.index'])
                    <x-a 
                        icon="search"
                        class='s btn color-accent'
                        href="{{ route('search.index', [$currentGroup->id]) }}"
                    >
                        Найти товар
                    </x-a>

                    <x-a 
                        icon="clipboard-list" 
                        class='s btn color-default'
                        href="{{ route('report.index', [$currentGroup->id]) }}"
                    >
                        Создать отчет
                    </x-a>
                @endroute

            </div>

        @endif

    </div>

</section>