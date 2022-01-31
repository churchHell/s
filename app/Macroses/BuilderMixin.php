<?php

namespace App\Macroses;

use Illuminate\Database\Eloquent\{Builder, Model};

class BuilderMixin
{

    public function findOrFirst()
    {   
        return function(?int $id = null): ?Model
        {
            $wheres = $this->getQuery()->wheres;
            $find = $this->whereId($id)->first();
            if($find){
                return $find;
            }
            $this->getQuery()->wheres = $wheres;
            return $this->first();
        };
    }
    
}