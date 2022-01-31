<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Support\Str;

class DuplicateException extends Exception
{
    
    public function __construct(string $key = '')
    {
        parent::__construct(Str::ucfirst(trim(__($key) . ' уже существует')));
    }

}
