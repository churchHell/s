@error($slot->toHtml())
    <span class="text-xs text-red-800">
        {{ $message }}
    </span>
@enderror

@if(session()->has('success'))
    <span class="text-xs text-green-800">
        {{ session('success') }}
    </span>
@endif