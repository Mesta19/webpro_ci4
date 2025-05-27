<?php

namespace App\Controllers;

use App\Models\M_Anggota;

class Anggota extends BaseController
{

    public function input_data_anggota()
    {
        if(session()->get('ses_id')==="" || session()->get('ses_user')==="" || session()->get('ses_level')==="") {
            session()->setFlashdata('error','Silakan login terlebih dahulu!');
            return redirect()->to(base_url('admin/login-admin'));
        } else {
            echo view('Backend/Template/header');
            echo view('Backend/Template/sidebar');
            echo view('Backend/MasterAnggota/input-anggota'); // Pastikan ini ada
            echo view('Backend/Template/footer');
        }
    }
    

public function simpan_data_anggota() {
   if(session()->get('ses_id')==="" or session()->get('ses_user')==="" or session()->get('ses_level')==="") {
       session()->setFlashdata('error','Silakan login terlebih dahulu!');
?>
<script>
   document.location = "<?= base_url('admin/login-admin');?>";
</script>
<?php
   }
   else {
       $modelAnggota = new M_Anggota; // inisiasi
       
       $nama = $this->request->getPost('nama');
       $passwordAnggota = $this->request->getPost('passwordAnggota'); // Sesuaikan dengan form
       $jenis_kelamin = $this->request->getPost('jenis_kelamin');
       $no_tlp = $this->request->getPost('no_tlp');
       $alamat = $this->request->getPost('alamat');
       $email = $this->request->getPost('email');
       
       $cekUname = $modelAnggota->getDataAnggota(['nama_anggota' => $nama])->getNumRows();
       if($cekUname > 0) {
           session()->setFlashdata('error','Nama anggota sudah ada!!');
            ?>
            <script>
            history.go(-1);
            </script>
            <?php
       }
       else {
        $hasil = $modelAnggota->autoNumber()->getRowArray();
        if(!$hasil) {
            $id = "ANG001";
        }
        else {
            $kode = $hasil['id_anggota'];
            $noUrut = (int) substr($kode, -3);
            $noUrut++;
            $id = "ANG".sprintf("%03s", $noUrut);
        }
        
        $dataSimpan = [
            'id_anggota' => $id,
            'nama_anggota' => $nama,
            'no_tlp'=> $no_tlp,
            'password_anggota' => password_hash($passwordAnggota, PASSWORD_DEFAULT),
            'alamat' => $alamat,
            'email' => $email,
            'jenis_kelamin' => $jenis_kelamin,
            'is_delete_anggota' => '0',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];
        $modelAnggota->saveDataAnggota($dataSimpan);
        session()->setFlashdata('success', 'Data Anggota Berhasil Ditambahkan!!');
     ?>
     <script>
        document.location = "<?= base_url('anggota/master-data-anggota');?>";
     </script>
     <?php
            }
        }
     }

     public function master_data_anggota()
     {
        if(session()->get('ses_id')=="" or session()->get('ses_user')=="" or session()->get('ses_level')==""){
            session()->setFlashdata('error','Silakan login terlebih dahulu!');
    ?>
            <script>
                document.location = "<?= base_url('admin/login-admin'); ?>";
            </script>
    <?php
        }
         // Kode untuk menampilkan data anggota
         $modelAnggota = new M_Anggota; // Pastikan model ini sudah dibuat
         $namaAnggota = $modelAnggota->getDataAnggota(['is_delete_anggota' => '0'])->getResultArray();
         
         $uri = service('uri');
         $page = $uri->getSegment(2);
         
         $data['page'] = $page;
         $data['web_title'] = "Master Data Anggota";
         $data['data_anggota'] = $namaAnggota;
         
         echo view('Backend/Template/header', $data);
         echo view('Backend/Template/sidebar', $data);
         echo view('Backend/MasterAnggota/master-data-anggota', $data);
         echo view('Backend/Template/footer', $data);
     }     


     public function logout(){
        session()->remove('ses_id');
        session()->remove('ses_user');
        session()->remove('ses_level');
        session()->setFlashdata('Info','Anda telah keluar dari sistem!');
        ?>
        <script>
            document.location="<?= base_url('admin/login-admin');?>";
        </script>
        <?php
    }

public function edit_data_anggota()
{
    $uri = service('uri');
    $idEdit = $uri->getSegment(3);
    $modelAnggota = new M_Anggota;

    $dataAnggota = $modelAnggota->getDataAnggota(['sha1(id_anggota)' => $idEdit])->getRowArray();
    session()->set(['idUpdate' => $dataAnggota['id_anggota']]);

    $page = $uri->getSegment(2);

    $data['page'] = $page;
    $data['web_title'] = "Edit Data Anggota";
    $data['data_anggota'] = $dataAnggota;

    echo view('Backend/Template/header', $data);
    echo view('Backend/Template/sidebar', $data);
    echo view('Backend/MasterAnggota/edit-anggota', $data);
    echo view('Backend/Template/footer', $data);
}

public function update_data_anggota()
{
    $modelAnggota = new M_Anggota;

    $idUpdate = session()->get('idUpdate');
    $nama = $this->request->getPost('nama');
    $password = $this->request->getPost('passwordAnggota');
    if (!empty($password)) {
        $dataUpdate['password_anggota'] = $password; // Simpan tanpa hash
    }

    $jenis_kelamin = $this->request->getPost('jenis_kelamin');
    $no_tlp = $this->request->getPost('no_tlp');
    $alamat = $this->request->getPost('alamat');
    $email = $this->request->getPost('email');

    
    if ($nama == "" || $jenis_kelamin == "" || $no_tlp == "" || $alamat == "" || $email == "") {
        session()->setFlashdata('error', 'Isian tidak boleh kosong!!');
        ?>
        <script>
            history.go(-1);
        </script>
        <?php
    }    
    else {
        $dataUpdate = [
            'nama_anggota' => $nama,
            'no_tlp'=> $no_tlp,
            'alamat' => $alamat,
            'email' => $email,
            'jenis_kelamin' => $jenis_kelamin,
            'updated_at' => date("Y-m-d H:i:s")
        ];
        
        if (!empty($password)) {
            $dataUpdate['password_anggota'] = password_hash($password, PASSWORD_DEFAULT);
        }
        
        $whereUpdate = ['id_anggota' => $idUpdate];

        $modelAnggota->updateDataAnggota($dataUpdate, $whereUpdate);
        session()->remove('idUpdate');
        session()->setFlashdata('success', 'Data Anggota Berhasil Diperbaharui!');
        ?>
        <script>
            document.location = "<?= base_url('anggota/master-data-anggota');?>";
        </script>
        <?php
    }
}

public function hapus_data_anggota()
{
    $modelAnggota = new M_Anggota;

    $uri = service('uri');
    $idHapus = $uri->getSegment(3);

    $dataUpdate = [
        'is_delete_anggota' => '1',
        'updated_at' => date("Y-m-d H:i:s")
    ];
    $whereUpdate = ['sha1(id_anggota)' => $idHapus];

    $modelAnggota->updateDataAnggota($dataUpdate, $whereUpdate);
    session()->setFlashdata('success', 'Data Anggota Berhasil Dihapus!');
    ?>
    <script>
        document.location = "<?= base_url('anggota/master-data-anggota');?>";
    </script>
    <?php
}
// Akhir modul anggota
}