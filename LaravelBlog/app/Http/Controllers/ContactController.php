<?php

namespace App\Http\Controllers;

class COntactController
{
    public function store()
    {
        request()->validate(['email' => 'required']);

    }
}
