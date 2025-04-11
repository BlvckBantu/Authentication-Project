<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use App\Models\UserModel;

class AuthController extends ResourceController
{
    protected $format = 'json';
    
    // Register a new user
    public function register()
    {
        $rules = [
            'username' => 'required|min_length[3]|max_length[100]|is_unique[users.username]',
            'email'    => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[8]',
        ];
        
        if (!$this->validate($rules)) {
            return $this->fail($this->validator->getErrors());
        }
        
        $userModel = new UserModel();
        $data = [
            'username' => $this->request->getVar('username'),
            'email'    => $this->request->getVar('email'),
            'password' => $this->request->getVar('password'),
        ];
        
        $userModel->save($data);
        
        return $this->respondCreated([
            'status' => 201,
            'message' => 'User registered successfully',
        ]);
    }
    
    // Login a user
    public function login()
    {
        $session = session();
        $userModel = new UserModel();
        
        $username = $this->request->getVar('username');
        $password = $this->request->getVar('password');
        
        $user = $userModel->where('username', $username)->first();
        
        if (!$user) {
            return $this->fail('Invalid username or password');
        }
        
        if (!password_verify($password, $user['password'])) {
            return $this->fail('Invalid username or password');
        }
        
        $sessionData = [
            'user_id'    => $user['id'],
            'username'   => $user['username'],
            'email'      => $user['email'],
            'isLoggedIn' => true,
        ];
        
        $session->set($sessionData);
        
        return $this->respond([
            'status' => 200,
            'message' => 'Login successful',
            'user' => [
                'id' => $user['id'],
                'username' => $user['username'],
                'email' => $user['email'],
            ]
        ]);
    }
    
    // Logout
    public function logout()
    {
        $session = session();
        $session->destroy();
        
        return $this->respond([
            'status' => 200,
            'message' => 'Logout successful',
        ]);
    }
    
    // Get user profile
    public function profile()
    {
        $session = session();
        
        if (!$session->get('isLoggedIn')) {
            return $this->failUnauthorized('User not logged in');
        }
        
        return $this->respond([
            'status' => 200,
            'user' => [
                'id' => $session->get('user_id'),
                'username' => $session->get('username'),
                'email' => $session->get('email'),
            ]
        ]);
    }
}