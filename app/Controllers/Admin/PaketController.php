<?php namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PackageModel;
use App\Models\UserModel;

class PaketController extends BaseController
{
    protected $packageModel;
    protected $userModel;

    public function __construct()
    {
        $this->packageModel = new PackageModel();
        $this->userModel = new UserModel();
    }

    // READ
    public function index()
    {
        $packages = $this->packageModel->findAll();
        $userModel = new UserModel();

        $data = [
            'packages' => $packages,
            'total_users' => $userModel->where('role', 'user')->countAllResults()
        ];
        return view('admin/paket/index', $data); 
    }

    // CREATE (Form)
    public function new()
    {
        return view('admin/paket/new'); 
    }

    // CREATE (Process)
    public function create()
    {
        $validation = \Config\Services::validation();
        
        $rules = [
            'name' => 'required|min_length[3]|max_length[255]',
            'speed' => 'required|numeric|greater_than[0]',
            'price' => 'required|numeric|greater_than[0]',
            'description' => 'permit_empty|max_length[1000]',
            'popular' => 'permit_empty|in_list[0,1]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $validation->getErrors());
        }

        // Convert checkbox value to ENUM string
        $popularValue = $this->request->getPost('popular') ? 'true' : 'false';

        $data = [
            'name' => $this->request->getPost('name'),
            'speed' => $this->request->getPost('speed'),
            'price' => $this->request->getPost('price'),
            'description' => $this->request->getPost('description') ?? '',
            'popular' => $popularValue,
            'created_at' => date('Y-m-d H:i:s')
        ];

        if ($this->packageModel->insert($data)) {
            return redirect()->to('/admin/paket')
                ->with('success', 'Paket berhasil ditambahkan!');
        } else {
            return redirect()->back()
                ->withInput()
                ->with('errors', ['Database error occurred']);
        }
    }

    // UPDATE (Form)
    public function edit($id)
    {
        $package = $this->packageModel->find($id);
        
        if (!$package) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Package not found');
        }

        $data = [
            'package' => $package
        ];

        return view('admin/paket/edit', $data);
    }

    // UPDATE (Process)
    public function update($id)
    {
        $package = $this->packageModel->find($id);
        
        if (!$package) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Package not found');
        }

        $validation = \Config\Services::validation();
        
        $rules = [
            'name' => 'required|min_length[3]|max_length[255]',
            'speed' => 'required|numeric|greater_than[0]',
            'price' => 'required|numeric|greater_than[0]',
            'description' => 'permit_empty|max_length[1000]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $validation->getErrors());
        }

        // Handle checkbox values properly - convert to ENUM string values
        $popularValue = $this->request->getPost('popular') !== null ? 'true' : 'false';

        $data = [
            'name' => $this->request->getPost('name'),
            'speed' => $this->request->getPost('speed'),
            'price' => $this->request->getPost('price'),
            'description' => $this->request->getPost('description') ?? '',
            'popular' => $popularValue,
            'updated_at' => date('Y-m-d H:i:s')
        ];

        // Debug: Log what we're trying to update
        log_message('debug', 'Updating package ID: ' . $id . ' with data: ' . json_encode($data));

        if ($this->packageModel->update($id, $data)) {
            return redirect()->to('/admin/paket')
                ->with('success', 'Paket berhasil diperbarui!');
        } else {
            // Get validation errors from model if any
            $errors = $this->packageModel->errors();
            log_message('error', 'Failed to update package: ' . json_encode($errors));
            
            return redirect()->back()
                ->withInput()
                ->with('errors', $errors ?: ['Failed to update package']);
        }
    }

    // VIEW
    public function view($id)
    {
        $package = $this->packageModel->find($id);
        
        if (!$package) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Paket tidak ditemukan');
        }

        // Get package statistics
        $statistics = $this->packageModel->getPackageStatistics($id);

        $data = [
            'title' => 'Detail Paket - ' . $package['name'],
            'package' => $package,
            'total_pelanggan' => $statistics['total_subscribers'],
            'pelanggan_aktif' => $statistics['total_subscribers'], // All subscribers are considered active
            'monthly_revenue' => $statistics['monthly_revenue']
        ];

        return view('admin/paket/view', $data);
    }

    // DELETE
    public function delete($id)
    {
        // Ensure this is a DELETE request or AJAX request
        if (!$this->request->isAJAX() && $this->request->getMethod() !== 'delete') {
            return $this->response->setJSON([
                'success' => false, 
                'message' => 'Invalid request method'
            ]);
        }

        $package = $this->packageModel->find($id);
        
        if (!$package) {
            return $this->response->setJSON([
                'success' => false, 
                'message' => 'Paket tidak ditemukan'
            ]);
        }

        // Check if there are users subscribed to this package
        $subscribedUsers = $this->userModel->where('subscribe_plan_id', $id)->countAllResults();
        
        if ($subscribedUsers > 0) {
            return $this->response->setJSON([
                'success' => false, 
                'message' => "Tidak dapat menghapus paket ini karena masih ada {$subscribedUsers} pelanggan yang menggunakan paket ini. Pindahkan pelanggan ke paket lain terlebih dahulu."
            ]);
        }

        try {
            if ($this->packageModel->delete($id)) {
                return $this->response->setJSON([
                    'success' => true, 
                    'message' => 'Paket berhasil dihapus!'
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false, 
                    'message' => 'Gagal menghapus paket'
                ]);
            }
        } catch (\Exception $e) {
            log_message('error', 'Error deleting package: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false, 
                'message' => 'Terjadi kesalahan saat menghapus paket'
            ]);
        }
    }

    // TOGGLE POPULAR
    public function togglePopular($id)
    {
        $package = $this->packageModel->find($id);
        
        if (!$package) {
            return $this->response->setJSON([
                'success' => false, 
                'message' => 'Package not found'
            ]);
        }

        // Toggle ENUM string values
        $newPopularStatus = $package['popular'] === 'true' ? 'false' : 'true';
        
        $data = [
            'popular' => $newPopularStatus,
            'updated_at' => date('Y-m-d H:i:s')
        ];

        if ($this->packageModel->update($id, $data)) {
            return $this->response->setJSON([
                'success' => true, 
                'message' => 'Status popular berhasil diubah',
                'popular' => $newPopularStatus
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false, 
                'message' => 'Failed to update status'
            ]);
        }
    }

    // EXPORT
    public function export()
    {
        try {
            // Get all packages from database
            $packages = $this->packageModel->findAll();
            
            // Set headers for CSV download
            $filename = 'paket_internet_' . date('Y-m-d_H-i-s') . '.csv';
            
            header('Content-Type: text/csv; charset=utf-8');
            header('Content-Disposition: attachment; filename="' . $filename . '"');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Expires: 0');
            
            // Create file pointer connected to the output stream
            $output = fopen('php://output', 'w');
            
            // Add BOM for UTF-8 encoding (helps with Excel compatibility)
            fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));
            
            // Add CSV headers
            fputcsv($output, [
                'ID',
                'Nama Paket',
                'Deskripsi',
                'Kecepatan (Mbps)',
                'Harga (Rp)',
                'Popular',
                'Tanggal Dibuat',
                'Tanggal Diupdate'
            ]);
            
            // Add data rows
            foreach ($packages as $package) {
                fputcsv($output, [
                    $package['id'],
                    $package['name'],
                    $package['description'],
                    $package['speed'],
                    $package['price'],
                    $package['popular'] === 'true' ? 'Ya' : 'Tidak',
                    $package['created_at'] ? date('d/m/Y H:i:s', strtotime($package['created_at'])) : '-',
                    $package['updated_at'] ? date('d/m/Y H:i:s', strtotime($package['updated_at'])) : '-'
                ]);
            }
            
            fclose($output);
            exit;
            
        } catch (\Exception $e) {
            log_message('error', 'Export error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal mengexport data: ' . $e->getMessage());
        }
    }
}