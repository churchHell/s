<header class="py-3 w-full bg-default">
    <div class="container flex sm:row justify-between text-white">
        <nav class="flex space-x-5">
            <x-a class="" icon='home' href="{{ route('index') }}" >Главная</x-a>
        </nav>

        <div class="flex order-first items-center sm:order-none mb-2 sm:mb-0 space-x-4">
            @guest
                <nav class="flex space-x-5">
                    <x-a class="" href="{{ route('login') }}"  icon="sign-in-alt">{{ __('login') }}</x-a>
                    <x-a class="" href="{{ route('register') }}"  icon="user-plus">{{ __('register') }}</x-a>
                </nav>
            @else
                <span class="text-white">{{ auth()->user()->short_name }}</span>
                <nav class="flex space-x-2">
                    <x-a class="" icon='user-cog' href="{{ route('account.index') }}"  title='Аккаунт'></x-a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-a 
                            title='Выйти' 
                            :href="route('logout')"
                            onclick="
                                event.preventDefault(); 
                                this.closest('form').submit();
                            "
                        >
                            <i wire:click='logout' class="cursor-pointer accent-link fas fa-door-open"></i>
                        </x-a>
                    </form>
                </nav>
            @endguest
        </div>
    </div>
</header>