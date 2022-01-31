<?php

namespace App\Exceptions;

use Illuminate\Support\Str;


class NotFoundException extends \Exception
{

    public function __construct(string $key = '')
    {
        parent::__construct(Str::ucfirst(trim(__($key) . ' не найден(а)')));
    }

}