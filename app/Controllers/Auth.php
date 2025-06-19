<?php namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    public function __construct()
    {
        helper(['form', 'url']);
    }

    public function index()
    {
        // Tampilkan form login
        return view('auth/login'); 
    }

    public function proses()
    {
        $session = session();
        $userModel = new UserModel();
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        // Cari user berdasarkan email
        $user = $userModel->where('email', $email)->first();

        if ($user) {
            // Verifikasi password
            if (password_verify($password, $user['password_hash'])) {
                $ses_data = [
                    'user_id'    => $user['id'],
                    'user_name'  => $user['name'],
                    'user_email' => $user['email'],
                    'user_role'  => $user['role'],
                    'isLoggedIn' => TRUE
                ];
                $session->set($ses_data);
                
                // Arahkan berdasarkan role
                if ($user['role'] == 'admin') {
                    return redirect()->to('/admin'); // Arahkan admin ke dashboard admin
                } else {
                    return redirect()->to('/dashboard'); // Arahkan user biasa ke dashboard mereka
                }
            }
        }
        
        // Jika login gagal
        $session->setFlashdata('msg', 'Email atau Password salah.');
        return redirect()->to('/login');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}