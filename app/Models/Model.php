<?php

namespace App\Models;

use ArrayAccess;
use Tightenco\Collect\Support\Arr;

abstract class Model
{
    protected $attributes = [];

    protected $hidden = [];

    public function __construct($attributes)
    {
        $this->attributes = $attributes;
    }

    public function toArray()
    {
        return Arr::except($this->attributes, $this->hidden);
    }
}
