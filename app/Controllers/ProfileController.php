<?php

namespace App\Controllers;

use App\Models\UserModel;

class ProfileController extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $userId = session()->get('user_id');
        $user = $this->userModel->getUserWithPackage($userId);

        if (!$user) {
            return redirect()->to('/dashboard')->with('error', 'User not found');
        }

        $data = [
            'user' => $user
        ];

        return view('dashboard/profile', $data);
    }

    public function update()
    {
        $userId = session()->get('user_id');
        
        // Validation rules
        $rules = [
            'name' => 'required|min_length[3]|max_length[100]',
            'email' => 'required|valid_email|is_unique[users.email,id,' . $userId . ']'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'name' => $this->request->getPost('name'),
            'email' => $this->request->getPost('email')
        ];

        if ($this->userModel->update($userId, $data)) {
            // Update session data
            session()->set('user_name', $data['name']);
            session()->set('user_email', $data['email']);
            
            return redirect()->to('/dashboard/profile')->with('success', 'Profil berhasil diperbarui');
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui profil');
        }
    }
}
