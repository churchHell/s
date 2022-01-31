<?php

namespace App\Macroses;

class StrMixin
{

    public function only()
    {   
        return function(string $string, array $search = [], string $separator = ' '): string
        {
            dd(1, $this->value);
            $intersected = array_intersect($search, explode($separator, $string));
            return implode($separator, $intersected);
        };
    }
    
}