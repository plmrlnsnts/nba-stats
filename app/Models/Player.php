<?php

namespace App\Models;

class Player extends Model
{
    protected $hidden = ['id'];

    public function __construct($attributes)
    {
        $this->attributes = $attributes;
    }
}
