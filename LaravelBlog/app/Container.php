<?php

namespace App\Console;

class Container
{
    protected $binding = [];
    public function bind($key, $value)
    {
        $this->binding[$key] = $value;
    }
}
