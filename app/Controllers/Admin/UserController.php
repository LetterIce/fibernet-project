<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\PackageModel;

class UserController extends BaseController
{
    protected $userModel;
    protected $packageModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->packageModel = new PackageModel();
    }

    public function index()
    {
        $data = [
            'users' => $this->userModel->select('users.*, packages.name as package_name, packages.speed, packages.price as package_price')
                                      ->join('packages', 'packages.id = users.subscribe_plan_id', 'left')
                                      ->orderBy('users.created_at', 'DESC')
                                      ->findAll(),
            'total_users' => $this->userModel->countAll(),
            'active_users' => $this->userModel->where('role', 'user')->countAllResults(),
            'subscribers' => $this->userModel->where('subscribe_plan_id IS NOT NULL')->countAllResults(),
            'new_users_this_month' => $this->userModel->where('DATE_FORMAT(created_at, "%Y-%m") = DATE_FORMAT(NOW(), "%Y-%m")')->countAllResults()
        ];

        return view('admin/users/index', $data);
    }

    public function view($id)
    {
        $user = $this->userModel->getUserWithPackage($id);
        
        if (!$user) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('User tidak ditemukan');
        }

        $data = [
            'user' => $user,
            'packages' => $this->packageModel->findAll()
        ];

        return view('admin/users/view', $data);
    }

    public function delete($id)
    {
        if (!$this->request->isAJAX()) {
            return redirect()->back();
        }

        $userModel = new \App\Models\UserModel();
        $subscriptionModel = new \App\Models\SubscriptionModel();

        // Get user data
        $user = $userModel->find($id);
        if (!$user) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'User tidak ditemukan'
            ]);
        }

        // Prevent deleting admin users
        if ($user['role'] === 'admin') {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Tidak dapat menghapus user admin'
            ]);
        }

        // Start transaction
        $db = \Config\Database::connect();
        $db->transStart();

        try {
            // Delete user subscriptions first (foreign key constraint)
            $subscriptionModel->where('user_id', $id)->delete();
            
            // Delete user
            $userModel->delete($id);

            $db->transComplete();

            if ($db->transStatus() === false) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Gagal menghapus user'
                ]);
            }

            return $this->response->setJSON([
                'success' => true,
                'message' => 'User berhasil dihapus'
            ]);

        } catch (\Exception $e) {
            $db->transRollback();
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ]);
        }
    }

    public function updatePackage($id)
    {
        $packageId = $this->request->getPost('package_id');
        
        $user = $this->userModel->find($id);
        if (!$user) {
            return $this->response->setJSON(['success' => false, 'message' => 'User tidak ditemukan']);
        }

        // Validate package exists if not empty
        $package = null;
        if (!empty($packageId)) {
            $package = $this->packageModel->find($packageId);
            if (!$package) {
                return $this->response->setJSON(['success' => false, 'message' => 'Paket tidak ditemukan']);
            }
        }

        // Update user's package
        $updateData = ['subscribe_plan_id' => empty($packageId) ? null : $packageId];
        
        if ($this->userModel->update($id, $updateData)) {
            $packageName = empty($packageId) ? 'dihapus' : $package['name'];
            return $this->response->setJSON([
                'success' => true, 
                'message' => "Paket berhasil diperbarui ke: {$packageName}"
            ]);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Gagal memperbarui paket']);
        }
    }

    public function changePackage($id)
    {
        $user = $this->userModel->getUserWithPackage($id);
        
        if (!$user) {
            return $this->response->setJSON(['success' => false, 'message' => 'User tidak ditemukan']);
        }

        $packages = $this->packageModel->findAll();
        
        $data = [
            'user' => $user,
            'packages' => $packages
        ];

        return $this->response->setJSON([
            'success' => true,
            'html' => view('admin/users/change_package_modal', $data)
        ]);
    }

    public function bulkUpdatePackage()
    {
        if ($this->request->getMethod() !== 'post') {
            return $this->response->setJSON(['success' => false, 'message' => 'Method not allowed']);
        }

        $userIds = $this->request->getPost('user_ids');
        $packageId = $this->request->getPost('package_id');

        if (empty($userIds) || !is_array($userIds)) {
            return $this->response->setJSON(['success' => false, 'message' => 'Pilih minimal satu user']);
        }

        // Validate package exists if not empty
        if (!empty($packageId)) {
            $package = $this->packageModel->find($packageId);
            if (!$package) {
                return $this->response->setJSON(['success' => false, 'message' => 'Paket tidak ditemukan']);
            }
        }

        $updated = 0;
        foreach ($userIds as $userId) {
            $user = $this->userModel->find($userId);
            if ($user && $user['role'] !== 'admin') {
                $updateData = ['subscribe_plan_id' => empty($packageId) ? null : $packageId];
                if ($this->userModel->update($userId, $updateData)) {
                    $updated++;
                }
            }
        }

        if ($updated > 0) {
            $packageName = empty($packageId) ? 'dihapus' : $package['name'];
            return $this->response->setJSON([
                'success' => true,
                'message' => "{$updated} user berhasil diperbarui paketnya ke: {$packageName}"
            ]);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Tidak ada user yang berhasil diperbarui']);
        }
    }

    public function export()
    {
        $users = $this->userModel->select('users.*, packages.name as package_name, packages.speed, packages.price as package_price')
                                 ->join('packages', 'packages.id = users.subscribe_plan_id', 'left')
                                 ->orderBy('users.created_at', 'DESC')
                                 ->findAll();

        // Set proper headers for CSV download
        $filename = 'users_export_' . date('Y-m-d_H-i-s') . '.csv';
        
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        header('Cache-Control: cache, must-revalidate');
        header('Pragma: public');

        // Create file pointer connected to PHP output stream
        $output = fopen('php://output', 'w');
        
        // Add BOM for proper UTF-8 encoding in Excel
        fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));
        
        // CSV headers with Indonesian labels
        $headers = [
            'ID User',
            'Nama Lengkap', 
            'Email',
            'Role',
            'Paket Internet',
            'Kecepatan (Mbps)',
            'Harga Paket',
            'Status Berlangganan',
            'Tanggal Daftar',
            'Terakhir Update',
            'Status Akun'
        ];
        
        fputcsv($output, $headers);
        
        // Add user data
        foreach ($users as $user) {
            $row = [
                str_pad($user['id'], 6, '0', STR_PAD_LEFT), // ID with leading zeros
                $user['name'] ?? '',
                $user['email'] ?? '',
                ucfirst($user['role'] ?? 'user'),
                $user['package_name'] ?? 'Tidak berlangganan',
                $user['speed'] ? $user['speed'] . ' Mbps' : '-',
                $user['package_price'] ? 'Rp ' . number_format($user['package_price'], 0, ',', '.') : 'Gratis',
                $user['package_name'] ? 'Berlangganan' : 'Belum berlangganan',
                $user['created_at'] ? date('d/m/Y H:i:s', strtotime($user['created_at'])) : '-',
                $user['updated_at'] ? date('d/m/Y H:i:s', strtotime($user['updated_at'])) : '-',
                'Aktif' // You can add logic here if you have status field
            ];
            
            fputcsv($output, $row);
        }
        
        // Add summary row
        fputcsv($output, []); // Empty row
        fputcsv($output, ['=== RINGKASAN ===']);
        fputcsv($output, ['Total Pengguna', count($users)]);
        fputcsv($output, ['Total Berlangganan', count(array_filter($users, fn($u) => !empty($u['package_name'])))]);
        fputcsv($output, ['Total Belum Berlangganan', count(array_filter($users, fn($u) => empty($u['package_name'])))]);
        fputcsv($output, ['Tanggal Export', date('d/m/Y H:i:s')]);
        fputcsv($output, ['Diexport oleh', session()->get('user_name') ?? 'Admin']);
        
        fclose($output);
        exit;
    }

    public function exportSelected()
    {
        $userIds = $this->request->getPost('user_ids');
        
        if (empty($userIds) || !is_array($userIds)) {
            return $this->response->setJSON(['success' => false, 'message' => 'Tidak ada user yang dipilih']);
        }

        $users = $this->userModel->select('users.*, packages.name as package_name, packages.speed, packages.price as package_price')
                                 ->join('packages', 'packages.id = users.subscribe_plan_id', 'left')
                                 ->whereIn('users.id', $userIds)
                                 ->orderBy('users.created_at', 'DESC')
                                 ->findAll();

        if (empty($users)) {
            return $this->response->setJSON(['success' => false, 'message' => 'Data user tidak ditemukan']);
        }

        // Set proper headers for CSV download
        $filename = 'selected_users_export_' . date('Y-m-d_H-i-s') . '.csv';
        
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        // Create file pointer connected to PHP output stream
        $output = fopen('php://output', 'w');
        
        // Add BOM for proper UTF-8 encoding in Excel
        fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));
        
        // CSV headers
        $headers = [
            'ID User',
            'Nama Lengkap', 
            'Email',
            'Role',
            'Paket Internet',
            'Kecepatan (Mbps)',
            'Harga Paket',
            'Status Berlangganan',
            'Tanggal Daftar',
            'Terakhir Update'
        ];
        
        fputcsv($output, $headers);
        
        // Add user data
        foreach ($users as $user) {
            $row = [
                str_pad($user['id'], 6, '0', STR_PAD_LEFT),
                $user['name'] ?? '',
                $user['email'] ?? '',
                ucfirst($user['role'] ?? 'user'),
                $user['package_name'] ?? 'Tidak berlangganan',
                $user['speed'] ? $user['speed'] . ' Mbps' : '-',
                $user['package_price'] ? 'Rp ' . number_format($user['package_price'], 0, ',', '.') : 'Gratis',
                $user['package_name'] ? 'Berlangganan' : 'Belum berlangganan',
                $user['created_at'] ? date('d/m/Y H:i:s', strtotime($user['created_at'])) : '-',
                $user['updated_at'] ? date('d/m/Y H:i:s', strtotime($user['updated_at'])) : '-'
            ];
            
            fputcsv($output, $row);
        }
        
        // Add summary
        fputcsv($output, []);
        fputcsv($output, ['=== RINGKASAN EXPORT TERPILIH ===']);
        fputcsv($output, ['Jumlah User Terpilih', count($users)]);
        fputcsv($output, ['Tanggal Export', date('d/m/Y H:i:s')]);
        
        fclose($output);
        exit;
    }
}
