<?php

use App\Models\User;

if (!function_exists('isSynced')) {
    function isSynced(array $result): bool
    {
        return count($result['attached']) > 0 || count($result['updated']) > 0;
    }
}

if (!function_exists('isUnsynced')) {
    function isUnsynced(array $result): bool
    {
        return count($result['detached']) > 0;
    }
}

if (!function_exists('dateToShow')) {
    function dateToShow(string $date): string
    {
        return \Carbon\Carbon::make($date)->format('d.m H:i');
    }
}

if (!function_exists('isNewColor')) {
    function isNewColor(string $date): string
    {
        return \Carbon\Carbon::now()->diffInMinutes(new \Carbon\Carbon($date)) < 1440 ? 'color-success' : 'color-error';
    }
}

if (!function_exists('array_keys_prepend')) {
    function array_keys_prepend(array $data, string $prepend): array
    {
        $keys = array_map(fn($key) => $prepend.$key, array_keys($data));
        return array_combine($keys, $data);
    }
}

if (!function_exists('id')) {
    function id(): int
    {
        return auth()->id();
    }
}

if (!function_exists('user')) {
    function user(): User
    {
        return auth()->user();
    }
}

// Binds

if (!function_exists('cartRepository')) {
    function cartRepository()
    {
        return app(\App\Repositories\Contracts\CartRepositoryContract::class);
    }
}

if (!function_exists('deliveryRepository')) {
    function deliveryRepository()
    {
        return app(\App\Repositories\Contracts\DeliveryRepositoryContract::class);
    }
}

if (!function_exists('itemRepository')) {
    function itemRepository()
    {
        return app(\App\Repositories\Contracts\ItemRepositoryContract::class);
    }
}