<?php

namespace App\Controllers;

use App\Models\M_Admin;
use App\Models\M_Kategori;
use App\Models\M_Rak;
use App\Models\M_Anggota;
use App\Models\M_Buku;
use App\Models\M_Peminjaman;

use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\Label\LabelAlignment;
use Endroid\QrCode\Label\Font\OpenSans;
use Endroid\QrCode\RoundBlockSizeMode;
use Endroid\QrCode\Writer\PngWriter;

class Admin extends BaseController
{
    public function login(){
        return view('Backend/Login/login');
    }
    
    public function dashboard()
{
    if(session()->get('ses_id') == "" || session()->get('ses_user') == "" || session()->get('ses_level') == ""){
        session()->setFlashdata('error','Silakan login terlebih dahulu!');
        ?>
        <script>
            document.location = "<?= base_url('admin/login-admin'); ?>";
        </script>
        <?php
    }
    else{
        echo view('Backend/Template/header');
        echo view('Backend/Template/sidebar');
        echo view('Backend/Login/dashboard_admin');
        echo view('Backend/Template/footer');
    }
}

    
    public function autentikasi()
{
    $modelAdmin = new M_Admin; // proses inisiasi model
    $username = $this->request->getPost('username');
    $password = $this->request->getPost('password');

    $cekUsername = $modelAdmin->getDataAdmin(['username_admin' => $username, 'is_delete_admin' => '0'])->getNumRows();
    if($cekUsername == 0){
        session()->setFlashdata('error','Username Tidak Ditemukan!');
        ?>
        <script>
            history.go(-1);
        </script>
        <?php
    }
    else{
        $dataUser = $modelAdmin->getDataAdmin(['username_admin' => $username, 'is_delete_admin' => '0'])->getRowArray();
        $passwordUser = $dataUser['password_admin'];

        $verifikasiPassword = password_verify($password, $passwordUser);
        if(!$verifikasiPassword){
            session()->setFlashdata('error','Password Tidak Sesuai!');
            ?>
            <script>
                history.go(-1);
            </script>
            <?php
        }
        else{
            $dataSession = [
                'ses_id'    => $dataUser['id_admin'],
                'ses_user'  => $dataUser['nama_admin'],
                'ses_level' => $dataUser['akses_level']
            ];
            session()->set($dataSession);
            session()->setFlashdata('success','Login Berhasil!');
            ?>
            <script>
                document.location = "<?= base_url('admin/dashboard-admin'); ?>";
            </script>
            <?php
        }
    }
}


    public function input_data_admin() {
        if(session()->get('ses_id')==="" or session()->get('ses_user')==="" or session()->get('ses_level')==="") {
            session()->setFlashdata('error','Silakan login terlebih dahulu!');
     ?>
     <script>
        document.location = "<?= base_url('admin/login-admin');?>";
     </script>
     <?php
        }
        else {
            echo view('Backend/Template/header');
            echo view('Backend/Template/sidebar');
            echo view('Backend/MasterAdmin/input-admin');
            echo view('Backend/Template/footer');
        }
     }

     public function simpan_data_admin() {
   if(session()->get('ses_id')==="" or session()->get('ses_user')==="" or session()->get('ses_level')==="") {
       session()->setFlashdata('error','Silakan login terlebih dahulu!');
?>
<script>
   document.location = "<?= base_url('admin/login-admin');?>";
</script>
<?php
   }
   else {
       $modelAdmin = new M_Admin; // inisiasi
       
       $nama = $this->request->getPost('nama');
       $username = $this->request->getPost('username');
       $level = $this->request->getPost('level');
       
       $cekUname = $modelAdmin->getDataAdmin(['username_admin' => $username])->getNumRows();
       if($cekUname > 0) {
           session()->setFlashdata('error','Username sudah digunakan!!');
            ?>
            <script>
            history.go(-1);
            </script>
            <?php
       }
       else {
        $hasil = $modelAdmin->autoNumber()->getRowArray();
        if(!$hasil) {
            $id = "ADM001";
        }
        else {
            $kode = $hasil['id_admin'];
            $noUrut = (int) substr($kode, -3);
            $noUrut++;
            $id = "ADM".sprintf("%03s", $noUrut);
        }
        
        $dataSimpan = [
            'id_admin' => $id,
            'nama_admin' => $nama,
            'username_admin' => $username,
            'password_admin' => password_hash('pass_admin', PASSWORD_DEFAULT),
            'akses_level' => $level,
            'is_delete_admin' => '0',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];
        $modelAdmin->saveDataAdmin($dataSimpan);
        session()->setFlashdata('success', 'Data Admin Berhasil Ditambahkan!!');
     ?>
     <script>
        document.location = "<?= base_url('admin/master-data-admin');?>";
     </script>
     <?php
            }
        }
     }

     public function master_data_admin(){
        if(session()->get('ses_id')=="" or session()->get('ses_user')=="" or session()->get('ses_level')==""){
            session()->setFlashdata('error','Silakan login terlebih dahulu!');
    ?>
            <script>
                document.location = "<?= base_url('admin/login-admin'); ?>";
            </script>
    <?php
        }
        else{
            $modelAdmin = new M_Admin; // inisiasi
    
            $uri = service('uri');
            $pages = $uri->getSegment(2);
            $dataUser = $modelAdmin->getDataAdmin(['is_delete_admin' => '0', 'akses_level !=' => '1'])->getResultArray();
    
            $data['pages'] = $pages;
            $data['data_user'] = $dataUser;
    
            echo view('Backend/Template/header', $data);
            echo view('Backend/Template/sidebar', $data);
            echo view('Backend/MasterAdmin/master-data-admin', $data);
            echo view('Backend/Template/footer', $data);
        }
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

    public function edit_data_admin()
    {
    $uri = service('uri');
    $idEdit = $uri->getSegment(3);
    $modelAdmin = new M_Admin;
    // Mengambil data admin dari table admin di database berdasarkan parameter yang dikirimkan
    $dataAdmin = $modelAdmin->getDataAdmin(['sha1(id_admin)' => $idEdit])->getRowArray();
    session()->set(['idUpdate' => $dataAdmin['id_admin']]);

    $page = $uri->getSegment(2);

    $data['page'] = $page;
    $data['web_title'] = "Edit Data Admin";
    $data['data_admin'] = $dataAdmin; // mengirim array data admin ke view

    echo view('Backend/Template/header', $data);
    echo view('Backend/Template/sidebar', $data);
    echo view('Backend/MasterAdmin/edit-admin', $data);
    echo view('Backend/Template/footer', $data);
    }

    public function update_data_admin()
    {
    $modelAdmin = new M_Admin;

    $idUpdate = session()->get('idUpdate');
    $nama = $this->request->getPost('nama');
    $level = $this->request->getPost('level');

    if($nama == "" || $level == ""){
        session()->setFlashdata('error', 'Isian tidak boleh kosong!!');
        ?>
        <script>
            history.go(-1);
        </script>
        <?php
    }
    else {
        $dataUpdate = [
            'nama_admin' => $nama,
            'akses_level' => $level,
            'updated_at' => date("Y-m-d H:i:s")
        ];
        $whereUpdate = ['id_admin' => $idUpdate];

        $modelAdmin->updateDataAdmin($dataUpdate, $whereUpdate);
        session()->remove('idUpdate');
        session()->setFlashdata('success', 'Data Admin Berhasil Diperbaharui!');
        ?>
        <script>
            document.location = "<?= base_url('admin/master-data-admin');?>";
        </script>
        <?php
    }
    }

    public function hapus_data_admin()
    {
    $modelAdmin = new M_Admin;

    $uri = service('uri');
    $idHapus = $uri->getSegment(3);

    $dataUpdate = [
        'is_delete_admin' => '1',
        'updated_at' => date("Y-m-d H:i:s")
    ];
    $whereUpdate = ['sha1(id_admin)' => $idHapus];

    $modelAdmin->updateDataAdmin($dataUpdate, $whereUpdate);
    session()->setFlashdata('success', 'Data Admin Berhasil Dihapus!');
    ?>
    <script>
        document.location = "<?= base_url('admin/master-data-admin');?>";
    </script>
    <?php
    }

// Akhir modul admin

// method untuk peminjaman
public function peminjaman_step1()
{
    $uri = service('uri');
    $page = $uri->getSegment(2);

    $data['page'] = $page;
    $data['web_title'] = "Transaksi Peminjaman";

    echo view('Backend/Template/header', $data);
    echo view('Backend/Template/sidebar', $data);
    echo view('Backend/Transaksi/peminjaman-step-1', $data);
    echo view('Backend/Template/footer', $data);
}

public function peminjaman_step2()
{
    $modelAnggota = new M_Anggota;
    $modelBuku = new M_Buku;
    $modelPeminjaman = new M_Peminjaman;
    $uri = service('uri');
    $page = $uri->getSegment(2);

    if($this->request->getPost('id_anggota')){
        $idAnggota = $this->request->getPost('id_anggota');
        session()->set(['idAgt' => $idAnggota]);
    }
    else{
        $idAnggota = session()->get('idAgt');
    }

    $cekPeminjaman = $modelPeminjaman->getDataPeminjaman(['id_anggota' => $idAnggota, 'status_transaksi' => "Berjalan"])->getNumRows();
    if($cekPeminjaman > 0){
        session()->setFlashdata('error','Transaksi Tidak Dapat Dilakukan, Masih Ada Transaksi Peminjaman yang Belum Diselesaikan!!');
        ?>
        <script>
            history.go(-1);
        </script>
        <?php
    }
else{
    $dataAnggota = $modelAnggota->getDataAnggota(['id_anggota' => $idAnggota])->getRowArray();
    $dataBuku = $modelBuku->getDataBukuJoin()->getResultArray();

    $jumlahTemp = $modelPeminjaman->getDataTemp(['id_anggota' => $idAnggota])->getNumRows();
    $data['jumlahTemp'] = $jumlahTemp;
    // Mengambil data keseluruhan buku dari table buku di database

    $dataTemp = $modelPeminjaman->getDataTempJoin(['tbl_temp_peminjaman.id_anggota' => $idAnggota])->getResultArray();

    $data['page'] = $page;
    $data['web_title'] = "Transaksi Peminjaman";
    $data['dataAnggota'] = $dataAnggota;
    $data['dataBuku'] = $dataBuku;
    $data['dataTemp'] = $dataTemp;

    echo view('Backend/Template/header', $data);
    echo view('Backend/Template/sidebar', $data);
    echo view('Backend/Transaksi/peminjaman-step-2', $data);
    echo view('Backend/Template/footer', $data);
}
}

public function simpan_temp_pinjam()
{
    $modelPeminjaman = new M_Peminjaman;
    $modelBuku = new M_Buku;

    $uri = service('uri');
    $idBuku = $uri->getSegment(3);
    $dataBuku = $modelBuku->getDataBuku(['sha1(id_buku)' => $idBuku])->getRowArray();

    $adaTemp = $modelPeminjaman->getDataTemp(['sha1(id_buku)' => $idBuku])->getNumRows();
    $adaBerjalan = $modelPeminjaman->getDataPeminjaman(['id_anggota' => session()->get('idAgt'), 'status_transaksi' => "Berjalan"])->getNumRows();
    if($adaTemp){
        session()->setFlashdata('error','Satu Anggota Hanya Bisa Meminjam 1 Buku dengan Judul yang Sama!');
    ?>
        <script>
            history.go(-1);
        </script>
    <?php
    }
    elseif ($adaBerjalan){
        session()->setFlashdata('error','Masih ada transaksi peminjaman yang belum diselesaikan, silakan selesaikan peminjaman sebelumnya terlebih dahulu!');
    ?>
        <script>
            history.go(-1);
        </script>
    <?php
    }
else{
    $dataSimpanTemp = [
        'id_anggota' => session()->get('idAgt'),
        'id_buku' => $dataBuku['id_buku'],
        'jumlah_temp' => '1'
    ];
    $modelPeminjaman->saveDataTemp($dataSimpanTemp);

    $stok = $dataBuku['jumlah_eksemplar']-1;
    $dataUpdate = [
        'jumlah_eksemplar' => $stok
    ];
    $modelBuku->updateDataBuku($dataUpdate,['sha1(id_buku)' => $idBuku]);
?>
    <script>
        document.location = "<?= base_url('admin/peminjaman-step-2');?>";
    </script>
<?php
}
}

public function hapus_peminjaman()
{
    $modelPeminjaman = new M_Peminjaman;
    $modelBuku = new M_Buku;

    $uri = service('uri');
    $idBuku = $uri->getSegment(3);
    $dataBuku = $modelBuku->getDataBuku(['sha1(id_buku)' => $idBuku])->getRowArray();

    $modelPeminjaman->hapusDataTemp([
        'sha1(id_buku)' => $idBuku,
        'id_anggota' => session()->get('idAgt')
    ]);

    $stok = $dataBuku['jumlah_eksemplar'] + 1;
    $dataUpdate = [
        'jumlah_eksemplar' => $stok
    ];
    $modelBuku->updateDataBuku($dataUpdate, ['sha1(id_buku)' => $idBuku]);
    ?>
    <script>
        document.location = "<?= base_url('admin/peminjaman-step-2'); ?>";
    </script>
    <?php
}

public function simpan_transaksi_peminjaman()
{
    $modelPeminjaman = new M_Peminjaman;
    $idPeminjaman = date("ymdHis");
    $time_sekarang = time();
    $kembali = date("Y-m-d", strtotime("+7 days", $time_sekarang));
    $jumlahPinjam = $modelPeminjaman->getDataTemp([
        'id_anggota' => session()->get('idAgt')
    ])->getNumRows();

    $dataQR = $idPeminjaman;
    $labelQR = $idPeminjaman;
    $builder = new Builder(
        writer: new PngWriter(),
        // writerOptions: [], // Bisa dihilangkan jika kosong
        validateResult: false,
        data: $dataQR,
        encoding: new Encoding('UTF-8'),
        errorCorrectionLevel: ErrorCorrectionLevel::High,
        size: 300,
        margin: 10,
        roundBlockSizeMode: RoundBlockSizeMode::Margin,
        logoPath: FCPATH . 'Assets/logo-ubsi.png', // Pastikan path ini benar
        logoResizeToWidth: 50,
        logoPunchoutBackground: true,
        labelText: $labelQR,
        labelFont: new OpenSans(20), // Menggunakan OpenSans seperti contoh dokumentasi. Jika ingin tetap NotoSans, pastikan class NotoSans ada dan di-import.
        labelAlignment: LabelAlignment::Center
    );

    $result = $builder->build();
    

    header('Content-Type: ' . $result->getMimeType());

    $namaQR = "qr_" . $idPeminjaman . ".png";
    $result->saveToFile(FCPATH . 'Assets/qr_code/' . $namaQR);
        $dataSimpan = [
    'no_peminjaman'     => $idPeminjaman,
    'id_anggota'        => session()->get('idAgt'),
    'tgl_pinjam'        => date("Y-m-d"),
    'total_pinjam'      => $jumlahPinjam,
    'id_admin'          => '-',
    'status_transaksi'  => "Berjalan",
    'status_ambil_buku' => "Sudah Diambil"
];

$modelPeminjaman->saveDataPeminjaman($dataSimpan);

$dataTemp = $modelPeminjaman->getDataTemp([
    'id_anggota' => session()->get('idAgt')
])->getResultArray();

foreach ($dataTemp as $sementara) {
    $simpanDetail = [
        'no_peminjaman' => $idPeminjaman,
        'id_buku'       => $sementara['id_buku'],
        'status_pinjam' => "Sedang Dipinjam",
        'perpanjangan'  => "2",
        'tgl_kembali'   => $kembali
    ];
    $modelPeminjaman->saveDataDetail($simpanDetail);
}

$modelPeminjaman->hapusDataTemp([
    'id_anggota' => session()->get('idAgt')
]);

session()->remove('idAgt');
session()->setFlashdata('success', 'Data Peminjaman Buku Berhasil Disimpan!');
?>
<script>
    document.location = "<?= base_url('admin/data-transaksi-peminjaman'); ?>";
</script>
<?php
}
public function data_transaksi_peminjaman()
{
    // Pengecekan sesi
    if(session()->get('ses_id')==="" || session()->get('ses_user')==="" || session()->get('ses_level')==="") {
        session()->setFlashdata('error','Silakan login terlebih dahulu!');
        return redirect()->to(base_url('admin/login-admin'));
    }

    // Inisiasi model
    $modelPeminjaman = new M_Peminjaman();
    
    // Mengambil data peminjaman dengan detail anggota dan admin
    // Menggunakan method getDataPeminjamanJoin() dari model Anda.
    // Kita asumsikan ingin mengambil semua data peminjaman (tanpa $where clause spesifik)
    // dan mengubah hasilnya menjadi array.
    $data['transaksi'] = $modelPeminjaman->getDataPeminjamanJoin()->getResultArray();

    // Data untuk dikirim ke view
    $data['web_title'] = "Data Transaksi Peminjaman";

    // Memuat view-view
    echo view('Backend/Template/header', $data);
    echo view('Backend/Template/sidebar', $data);
    // Pastikan Anda memiliki file view ini: app/Views/Backend/Transaksi/data_transaksi_peminjaman.php
    echo view('Backend/Transaksi/data_transaksi_peminjaman', $data); 
    echo view('Backend/Template/footer', $data);
}

}
