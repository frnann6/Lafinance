<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class LafinanceHome extends BaseController
{
    public function index()
    {
        return view('layouts/mobile', [
            'title' => 'Lafinance',
            'content' => view('home'),
        ]);
    }
}
