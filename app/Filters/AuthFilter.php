<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();
        
        if (!$session->get('isLoggedIn')) {
            // Check if the request wants JSON response
            // This replaces the old isAJAX() method
            $isAjax = $request->getHeaderLine('X-Requested-With') === 'XMLHttpRequest' || 
                     $request->getHeaderLine('Accept') === 'application/json';
            
            if ($isAjax) {
                return service('response')
                    ->setStatusCode(401)
                    ->setJSON([
                        'status' => 401,
                        'message' => 'Unauthorized. Please login.'
                    ]);
            } else {
                return redirect()->to('/login');
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // No actions needed after the request
    }
}