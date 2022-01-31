<?php

namespace App\Macroses;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Lang;

class ComponentAttributeBagMixin
{

    public function prop()
    {   
        return function(string $action): ?string
        {
            $value = $this->wire($action)->value();
            return !(empty($value)) ? $value : null;
        };
    }

    public function lang()
    {   
        return function(string $action): ?string
        {
            return Lang::getOrNull($this->prop($action));
        };
    }

    public function firstProp()
    {   
        return function(array $keys): ?string
        {
            foreach($keys as $key){
                $value = $this->prop($key);
                if($value){
                    return $value;
                }
            }
            return null;
        };
    }

    public function icon()
    {   
        return function(string $action): string
        {
            $icons = [
                'archivate' => 'archive',
                'batch' => 'layer-group',
                'comment' => 'tag',
                'create' => 'plus',
                'delay' => 'stopwatch',
                'delivery' => 'truck',
                'delete' => 'trash',
                'destroy' => 'trash',
                'email' => 'at',
                'login' => 'sign-in-alt',
                'name' => 'user',
                'password' => 'key',
                'password_confirmation' => 'key',
                'old_password' => 'key',
                'phone' => 'phone-alt',
                'qty' => 'cubes',
                'refresh' => 'sync-alt',
                'sid' => 'tag',
                'store' => 'plus',
                'submit' => 'plus',
                'surname' => 'user-friends',
                'update' => 'check',
            ];
            $wire = $this->wire($action)->value();
            $method = explode('(', $wire)[0];
            $dotten = explode('.', $method);
            $dotten = end($dotten);
            return $this['icon'] ?? $icons[$dotten] ?? '';
        };
    }

    public function type()
    {   
        return function(): ?string
        {
            return $this['type']
                ?? Str::of($this->prop('model'))->contains('password') ? 'password' : null
                ?? 'text';
        };
    }

    public function placeholder()
    {
        return function(): string
        {
            // dd($this['placeholder']);
            return Lang::getOrNull($this['placeholder'])
                ?? Lang::getOrNull(Str::of($this->prop('model'))->explode('.')->last())
                ?? '';
        };
        
    }

    public function onlyClasses()
    {
        return function(array $matches = []): ?string
        {
            $classes = Str::of($this['class']);
            $splits = collect($matches)->map(
                fn($match) => $classes->match('/\b'.$match.'\S*\b/')
            );
            return $splits->implode(' ');
        };
    }

    public function withoutClasses()
    {
        return function(array $matches = []): ?string
        {
            $classes = Str::of($this['class']);
            $splits = collect($matches)->map(
                fn($match) => $classes->remove($classes->match('/\b'.$match.'\S*\b/'))
            );
            return $splits->first();
        };
    }

    public function title()
    {
        return function($slot): string
        {
            return isset($this['title']) ? $this['title'] : $slot->toHtml();
        };
    }

    public function size()
    {
        return function(): string
        {
            // if(empty($this['class'])){
            //     return '';
            // }
            return Str::of($this['class'] ?? '')->sizes();
        };
    }
    
}