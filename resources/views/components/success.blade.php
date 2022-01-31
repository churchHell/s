@php
    $key = !empty($slot->toHtml()) ? $slot->toHtml() : 'success';
@endphp

@if(session()->has($key))
    <span class="bg-success text-success-darkest border-success-darkest rounded shadow-md text-xs xs">
        {{ session($key) }}
    </span>
@endif