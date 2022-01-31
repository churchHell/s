<?php

namespace App\Macroses;

class LangMixin
{

    public function getOrNull()
    {   
        return function(?string $key = null): ?string
        {
            return $this->has($key) ? $this->get($key) : null;
        };
    }
    
}