<a
    title="{{ $attributes->title($slot) }}"
    {{ $attributes->merge(['class' => 'whitespace-normal flex items-center space-x-2']) }}
>

    <i class="fas fa-{{ $attributes['icon'] }}"></i>

    {{--  <span class="w-min sm:w-max">  --}}
    <span class="w-full">
        {{ $slot }}
    </span>

</a>