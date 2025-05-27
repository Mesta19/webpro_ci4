<?php

namespace App\Controllers;

use App\Models\M_Rak;

class Rak extends BaseController
{
    protected $rakModel;

    public function __construct()
    {
        $this->rakModel = new M_Rak();
        helper('url');
    }

    public function index()
    {
        $data['data_rak'] = $this->rakModel->getDataRak();
        echo view('Backend/Template/header');
        echo view('Backend/Template/sidebar');
        echo view('Backend/MasterRak/master-data-rak', $data);
        echo view('Backend/Template/footer');
    }

    public function input()
    {
        echo view('Backend/Template/header');
        echo view('Backend/Template/sidebar');
        echo view('Backend/MasterRak/input-rak');
        echo view('Backend/Template/footer');
    }

    public function save()
    {
        $newId = $this->rakModel->nextId();
        $this->rakModel->insertRak([
            'id_rak'         => $newId,
            'nama_rak'       => $this->request->getPost('nama_rak'),
            'is_delete_rak'  => '0',
            'created_at'     => date('Y-m-d H:i:s'),
            'updated_at'     => date('Y-m-d H:i:s'),
        ]);
        return redirect()->to(base_url('rak'));
    }

    public function edit($hash)
    {
        $all = $this->rakModel->getDataRak(['SHA1(id_rak)' => $hash]);
        $data['data_rak'] = $all ? $all[0] : null;
        echo view('Backend/Template/header');
        echo view('Backend/Template/sidebar');
        echo view('Backend/MasterRak/edit-rak', $data);
        echo view('Backend/Template/footer');
    }

    public function update()
    {
        $id = $this->request->getPost('id_rak');
        $this->rakModel->updateRak([
            'nama_rak'    => $this->request->getPost('nama_rak'),
            'updated_at'  => date('Y-m-d H:i:s'),
        ], ['id_rak' => $id]);
        return redirect()->to(base_url('rak'));
    }

    public function delete($hash)
    {
        $this->rakModel->softDelete(['SHA1(id_rak)' => $hash]);
        return redirect()->to(base_url('rak'));
    }
}
