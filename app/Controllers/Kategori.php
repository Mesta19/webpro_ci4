<?php

namespace App\Controllers;

use App\Models\M_Kategori;

class Kategori extends BaseController
{
    protected $kategoriModel;

    public function __construct()
    {
        $this->kategoriModel = new M_Kategori();
        helper('url');
    }

    // Tampilkan master data
    public function index()
    {
        $data['data_kategori'] = $this->kategoriModel->getDataKategori();

        echo view('Backend/Template/header', $data);
        echo view('Backend/Template/sidebar', $data);
        echo view('Backend/MasterKategori/master-data-kategori', $data);
        echo view('Backend/Template/footer', $data);
    }

    // Tampilkan form input
    public function input()
    {
        echo view('Backend/Template/header');
        echo view('Backend/Template/sidebar');
        echo view('Backend/MasterKategori/input-kategori');
        echo view('Backend/Template/footer');
    }

    // Simpan data baru
    public function save()
    {
        $newId = $this->kategoriModel->getNextId();

        $data = [
            'id_kategori'        => $newId,
            'nama_kategori'      => $this->request->getPost('nama_kategori'),
            'is_delete_kategori' => '0',
            'created_at'         => date('Y-m-d H:i:s'),
            'updated_at'         => date('Y-m-d H:i:s'),
        ];

        $this->kategoriModel->saveDataKategori($data);
        return redirect()->to(base_url('kategori'));
    }

    // Tampilkan form edit
    public function edit($id)
    {
        $data['data_kategori'] = $this->kategoriModel
                                     ->getDataKategori(['SHA1(id_kategori)' => $id])[0];

        echo view('Backend/Template/header', $data);
        echo view('Backend/Template/sidebar', $data);
        echo view('Backend/MasterKategori/edit-kategori', $data);
        echo view('Backend/Template/footer', $data);
    }

    // Proses update
    public function update()
    {
        $id = $this->request->getPost('id_kategori');
        $data = [
            'nama_kategori' => $this->request->getPost('nama_kategori'),
            'updated_at'    => date('Y-m-d H:i:s'),
        ];

        $this->kategoriModel->updateDataKategori($data, ['id_kategori' => $id]);
        return redirect()->to(base_url('kategori'));
    }

    // Soft delete
    public function delete($id)
    {
        $this->kategoriModel->softDelete(['SHA1(id_kategori)' => $id]);
        return redirect()->to(base_url('kategori'));
    }
}
