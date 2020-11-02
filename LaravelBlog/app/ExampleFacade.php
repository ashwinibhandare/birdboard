<?php

namespace App\Console;

use App\Example;

class ExampleFacade
{
    public function getFacadeAccessor()
    {
        return 'example';
    }
}
