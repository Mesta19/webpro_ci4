<?php

namespace App\Controllers;

use App\Models\M_Buku;

class Buku extends BaseController
{
    private function generateRandomName($ext = '')
    {
        return md5(uniqid(rand(), true)) . '.' . $ext;
    }

    public function index()
    {
        if(session()->get('ses_id')=="" or session()->get('ses_user')=="" or session()->get('ses_level')==""){
            session()->setFlashdata('error','Silakan login terlebih dahulu!');
            return redirect()->to(base_url('admin/login-admin'));
        }
         $modelBuku = new M_Buku;
         $data['web_title'] = "Master Data Buku";
         $data['data_buku'] = $modelBuku->getDataBuku()->getResultArray();

         echo view('Backend/Template/header');
         echo view('Backend/Template/sidebar');
         echo view('Backend/MasterBuku/master-data-buku', $data);
         echo view('Backend/Template/footer');
    }

    public function input()
    {
        if(session()->get('ses_id')==="" || session()->get('ses_user')==="" || session()->get('ses_level')==="") {
            session()->setFlashdata('error','Silakan login terlebih dahulu!');
            return redirect()->to(base_url('admin/login-admin'));
        }
        $modelBuku = new M_Buku();
        $data['kategori'] = $modelBuku->getAllKategori();
        $data['rak'] = $modelBuku->getAllRak();
        echo view('Backend/Template/header');
        echo view('Backend/Template/sidebar');
        echo view('Backend/MasterBuku/input-buku', $data);
        echo view('Backend/Template/footer');
    }

    public function save() {
        log_message('debug', 'Method save() dipanggil... (langkah 1)');
        if(session()->get('ses_id')==="" or session()->get('ses_user')==="" or session()->get('ses_level')==="") {
            session()->setFlashdata('error','Silakan login terlebih dahulu!');
            return redirect()->to(base_url('admin/login-admin'));
        }
        log_message('debug', 'Session checked (langkah 2)');
        $modelBuku = new M_Buku;
        log_message('debug', 'Model M_Buku diinisialisasi (langkah 3)');
    
        $postData = $this->request->getPost(); // Ambil semua data POST
    
        $judul_buku = $postData['judul_buku'];
        $pengarang = $postData['pengarang'];
        $penerbit = $postData['penerbit'];
        $tahun = $postData['tahun'];
        $jumlah_eksemplar = $postData['jumlah_eksemplar'];
        $id_kategori = $postData['id_kategori'];
        $keterangan = $postData['keterangan'];
        $id_rak = $postData['id_rak'];
        $e_book = $postData['e_book'];
        log_message('debug', 'Data POST berhasil diambil (langkah 4)');
    
        $cekJudul = $modelBuku->getDataBuku(['judul_buku' => $judul_buku])->getNumRows();
        log_message('debug', 'Hasil cek judul: ' . print_r($cekJudul, true) . ' (langkah 5)');
        if($cekJudul > 0) {
            session()->setFlashdata('error','Judul buku sudah ada!!');
            return redirect()->back()->withInput();
        }
        log_message('debug', 'Cek judul lolos (langkah 6)');
    
        $fileCover = $this->request->getFile('cover_buku');
        $namaCover = '';
    
        if ($fileCover && $fileCover->isValid() && !$fileCover->hasMoved()) {
            $ext = $fileCover->getClientExtension();
            $namaCover = $this->generateRandomName($ext);
            $fileCover->move(ROOTPATH . 'public/Assets/cover_buku', $namaCover);
        }
        log_message('debug', 'Penanganan cover selesai (langkah 7)');
    
        // Generate ID Buku Otomatis
        $id_buku = $modelBuku->autoNumber();
        log_message('debug', 'Nilai id_buku setelah autoNumber(): ' . print_r($id_buku, true) . ' (langkah 8)');
    
        $dataSimpan = [
            'id_buku' => $id_buku,
            'judul_buku' => $judul_buku,
            'pengarang' => $pengarang,
            'penerbit' => $penerbit,
            'tahun' => $tahun,
            'jumlah_eksemplar' => $jumlah_eksemplar,
            'id_kategori' => $id_kategori,
            'keterangan' => $keterangan,
            'id_rak' => $id_rak,
            'cover_buku' => $namaCover,
            'e_book' => $e_book,
            'is_delete_buku' => '0',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];
        log_message('debug', 'DataSimpan dibuat (langkah 9)');
    
        $modelBuku->saveDataBuku($dataSimpan);
        log_message('debug', 'Data berhasil disimpan (langkah 10)');
        session()->setFlashdata('success', 'Data Buku Berhasil Ditambahkan!!');
        return redirect()->to(base_url('buku'));
    }

    public function edit($idRak)
    {
        if(session()->get('ses_id')==="" || session()->get('ses_user')==="" || session()->get('ses_level')==="") {
            session()->setFlashdata('error','Silakan login terlebih dahulu!');
            return redirect()->to(base_url('admin/login-admin'));
        }
        $modelBuku = new M_Buku;
        $dataBuku = $modelBuku->getDataBuku(['sha1(tbl_buku.id_rak)' => $idRak])->getRowArray();
        if ($dataBuku) {
            session()->set(['idUpdateRak' => $dataBuku['id_rak']]);
            $data['kategori'] = $modelBuku->getAllKategori();
            $data['rak'] = $modelBuku->getAllRak();
            $data['web_title'] = "Edit Data Buku";
            $data['data_buku'] = $dataBuku;
            $data['cover_path'] = base_url('public/uploads/cover_buku/');
            echo view('Backend/Template/header');
            echo view('Backend/Template/sidebar');
            echo view('Backend/MasterBuku/edit-buku', $data);
            echo view('Backend/Template/footer');
        } else {
            session()->setFlashdata('error', 'Data Buku tidak ditemukan!');
            return redirect()->to(base_url('buku'));
        }
    }

    public function update()
    {
        if(session()->get('ses_id')==="" or session()->get('ses_user')==="" or session()->get('ses_level')==="") {
            session()->setFlashdata('error','Silakan login terlebih dahulu!');
            return redirect()->to(base_url('admin/login-admin'));
        }
        $modelBuku = new M_Buku;
        $idUpdateRak = session()->get('idUpdateRak');

        $dataBukuLama = $modelBuku->getDataBuku(['id_rak' => $idUpdateRak])->getRow();

        $judul_buku = $this->request->getPost('judul_buku');
        $pengarang = $this->request->getPost('pengarang');
        $penerbit = $this->request->getPost('penerbit');
        $tahun = $this->request->getPost('tahun');
        $jumlah_eksemplar = $this->request->getPost('jumlah_eksemplar');
        $id_kategori = $this->request->getPost('id_kategori');
        $keterangan = $this->request->getPost('keterangan');
        $id_rak = $this->request->getPost('id_rak');
        $e_book = $this->request->getPost('e_book');

        if ($judul_buku == "" || $pengarang == "" || $penerbit == "" || $tahun == "" || $jumlah_eksemplar == "" || $id_kategori == "" || $id_rak == "") {
            session()->setFlashdata('error', 'Isian tidak boleh kosong!!');
            return redirect()->back()->withInput();
        }

        $fileCover = $this->request->getFile('cover_buku');
        $namaCover = $dataBukuLama ? $dataBukuLama->cover_buku : '';

        if ($fileCover && $fileCover->isValid() && !$fileCover->hasMoved()) {
            if ($dataBukuLama && $dataBukuLama->cover_buku && $dataBukuLama->cover_buku !== '') {
                $oldCoverPath = ROOTPATH . 'public/uploads/cover_buku/' . $dataBukuLama->cover_buku;
                if (file_exists($oldCoverPath)) {
                    unlink($oldCoverPath);
                }
            }
            $ext = $fileCover->getClientExtension();
            $namaCover = $this->generateRandomName($ext);
            $fileCover->move(ROOTPATH . 'public/uploads/cover_buku', $namaCover);
        }

        $dataUpdate = [
            'judul_buku' => $judul_buku,
            'pengarang' => $pengarang,
            'penerbit' => $penerbit,
            'tahun' => $tahun,
            'jumlah_eksemplar' => $jumlah_eksemplar,
            'id_kategori' => $id_kategori,
            'keterangan' => $keterangan,
            'id_rak' => $id_rak,
            'cover_buku' => $namaCover,
            'e_book' => $e_book,
            'updated_at' => date("Y-m-d H:i:s")
        ];

        $whereUpdate = ['id_rak' => $idUpdateRak];

        $modelBuku->updateDataBuku($dataUpdate, $whereUpdate);
        session()->remove('idUpdateRak');
        session()->setFlashdata('success', 'Data Buku Berhasil Diperbaharui!');
        return redirect()->to(base_url('buku'));
    }

    public function delete($idRak)
{
    if(session()->get('ses_id')==="" or session()->get('ses_user')=="" or session()->get('ses_level')==="") {
        session()->setFlashdata('error','Silakan login terlebih dahulu!');
?>
        <script>
            document.location = "<?= base_url('admin/login-admin'); ?>";
        </script>
<?php
    } else {
        $modelBuku = new M_Buku;

        $builder = $modelBuku->db->table('tbl_buku');
        $builder->where("SHA1(tbl_buku.id_rak) = '$idRak'"); // Spesifikasi tabel di sini
        $builder->update([
            'is_delete_buku' => '1',
            'updated_at' => date("Y-m-d H:i:s")
        ]);

        session()->setFlashdata('success', 'Data Buku Berhasil Dihapus!');
?>
        <script>
            document.location = "<?= base_url('buku');?>";
        </script>
<?php
    }
}
}