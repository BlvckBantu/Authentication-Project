<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class DashboardController extends BaseController
{
    public function index()
    {
        $session = session();
        $data = [
            'username' => $session->get('username'),
            'email' => $session->get('email'),
        ];
        
        return view('dashboard/index', $data);
    }
}