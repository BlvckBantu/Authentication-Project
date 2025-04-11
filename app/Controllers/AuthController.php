<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class AuthController extends BaseController
{
    public function loginPage()
    {
        $session = session();
        if ($session->get('isLoggedIn')) {
            return redirect()->to('/dashboard');
        }
        
        return view('auth/login');
    }
    
    public function registerPage()
    {
        $session = session();
        if ($session->get('isLoggedIn')) {
            return redirect()->to('/dashboard');
        }
        
        return view('auth/register');
    }
}