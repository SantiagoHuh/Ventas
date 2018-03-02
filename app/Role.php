<?php

namespace Ventas;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    public function users()
    {
        return $this
            ->belongsToMany('Ventas\User')
            ->withTimestamps();
    }
}
