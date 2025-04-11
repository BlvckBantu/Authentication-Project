<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Models\UserModel;

class UserSeeder extends Seeder
{
    public function run()
    {
        $userModel = new UserModel();
        
        $userModel->insertBatch([
            [
                'username' => 'admin',
                'email'    => 'admin@example.com',
                'password' => 'password123',
            ],
            [
                'username' => 'user',
                'email'    => 'user@example.com',
                'password' => 'password123',
            ],
        ]);
    }
}