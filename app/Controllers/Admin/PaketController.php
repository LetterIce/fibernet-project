<?php namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PackageModel;

class PaketController extends BaseController
{
    protected $packageModel;

    public function __construct()
    {
        $this->packageModel = new PackageModel();
    }

    // READ
    public function index()
    {
        $data = [
            'packages' => $this->packageModel->findAll()
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
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Package not found');
        }

        $data = [
            'package' => $package
        ];

        return view('admin/paket/view', $data);
    }

    // DELETE
    public function delete($id)
    {
        $package = $this->packageModel->find($id);
        
        if (!$package) {
            return $this->response->setJSON([
                'success' => false, 
                'message' => 'Package not found'
            ]);
        }

        if ($this->packageModel->delete($id)) {
            return $this->response->setJSON([
                'success' => true, 
                'message' => 'Paket berhasil dihapus!'
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false, 
                'message' => 'Failed to delete package'
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