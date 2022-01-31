<?php

namespace App\Macroses;

class StringableMixin
{

    public function only()
    {   
        return function(array $only = [], string $separator = ' '): string
        {
            $intersected = array_intersect($only, explode($separator, $this->value));
            return implode($separator, $intersected);
        };
    }

    public function divide()
    {   
        return function(array $only = [], string $separator = ' '): array
        {
            $exploded = explode($separator, $this->value);
            $intersected = array_intersect($only, $exploded);
            $diffed = array_diff($exploded, $only);
            return [implode($separator, $diffed), implode($separator, $intersected)];
        };
    }

    public function sizes()
    {   
        return function(): string
        {
            return $this->only(['xs', 's', 'm', 'l']);
        };
    }

    public function divideSizes()
    {
        return function(): array
        {
            return $this->divide(['xs', 's', 'm', 'l']);
        };
    }
    
}