<?php

namespace App\Controllers\Auth;

use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\Shield\Controllers\RegisterController as ShieldRegisterController;

class RegisterController extends ShieldRegisterController
{
    public function registerAction(): RedirectResponse
    {
        $response = parent::registerAction();

        if (auth()->loggedIn()) {
            auth()->logout();
        }

        return $response;
    }
}