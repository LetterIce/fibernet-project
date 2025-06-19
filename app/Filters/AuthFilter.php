<?php namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();
        // Jika session 'isLoggedIn' tidak ada atau false
        if (! $session->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        // Jika filter diberi argumen (misal: 'admin'), cek rolenya
        if (!empty($arguments)) {
            $requiredRole = $arguments[0];
            if ($session->get('user_role') !== $requiredRole) {
                // Jika role tidak sesuai, lempar ke halaman yang sesuai
                // atau tampilkan halaman 'unauthorized'
                if ($session->get('user_role') === 'admin') {
                    return redirect()->to('/admin');
                } else {
                    return redirect()->to('/dashboard');
                }
            }
        }
    }
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Tidak melakukan apa-apa setelah request
    }
}