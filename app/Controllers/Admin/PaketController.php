<?php namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PackageModel;

class PaketController extends BaseController
{
    // READ
    public function index()
    {
        $model = new PackageModel();
        $data = [
            'packages' => $model->findAll()
        ];
        // Buat view di app/Views/admin/paket/index.php
        return view('admin/paket/index', $data); 
    }

    // CREATE (Form)
    public function new()
    {
        // Buat view di app/Views/admin/paket/new.php
        return view('admin/paket/new'); 
    }

    // CREATE (Process)
    public function create()
    {
        $rules = [
            'name'  => 'required|min_length[5]',
            'speed' => 'required|numeric',
            'price' => 'required|numeric'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $model = new PackageModel();
        $model->save([
            'name'        => $this->request->getPost('name'),
            'speed'       => $this->request->getPost('speed'),
            'price'       => $this->request->getPost('price'),
            'description' => $this->request->getPost('description'),
        ]);

        return redirect()->to('/admin/paket')->with('success', 'Paket berhasil ditambahkan.');
    }

    // UPDATE (Form)
    public function edit($id)
    {
        $model = new PackageModel();
        $data['package'] = $model->find($id);
        // Buat view di app/Views/admin/paket/edit.php
        return view('admin/paket/edit', $data);
    }

    // UPDATE (Process)
    public function update($id)
    {
        // ... (logika validasi sama seperti create)
        
        $model = new PackageModel();
        $model->update($id, [
            'name'        => $this->request->getPost('name'),
            'speed'       => $this->request->getPost('speed'),
            'price'       => $this->request->getPost('price'),
            'description' => $this->request->getPost('description'),
        ]);

        return redirect()->to('/admin/paket')->with('success', 'Paket berhasil diperbarui.');
    }

    // DELETE
    public function delete($id)
    {
        $model = new PackageModel();
        $model->delete($id);
        return redirect()->to('/admin/paket')->with('success', 'Paket berhasil dihapus.');
    }
}