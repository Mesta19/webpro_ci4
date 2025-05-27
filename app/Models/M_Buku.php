<?php
namespace App\Models;

use CodeIgniter\Model;

class M_Buku extends Model
{
    protected $table = 'tbl_buku';
    protected $allowedFields = ['id_buku', 'judul_buku', 'pengarang', 'penerbit', 'tahun', 'jumlah_eksemplar', 'id_kategori', 'keterangan', 'id_rak', 'cover_buku', 'e_book', 'is_delete_buku', 'created_at', 'updated_at'];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $primaryKey = 'id_buku';

    public function getDataBuku($where = false)
    {
        $builder = $this->db->table($this->table);
        $builder->select('tbl_buku.*, kt.nama_kategori, rk.nama_rak');
        $builder->join('tbl_kategori kt', 'tbl_buku.id_kategori = kt.id_kategori', 'left');
        $builder->join('tbl_rak rk', 'tbl_buku.id_rak = rk.id_rak', 'left');
        $builder->where('tbl_buku.is_delete_buku', '0');
        if ($where) {
            $builder->where($where);
        }
        $builder->orderBy('judul_buku', 'ASC');
        return $builder->get();
    }

    public function saveDataBuku($data)
    {
        $builder = $this->db->table($this->table);
        return $builder->insert($data);
    }

    public function updateDataBuku($data, $where)
    {
        $builder = $this->db->table($this->table);
        $builder->where($where);
        return $builder->update($data);
    }

    public function getAllKategori()
    {
        $modelKategori = new M_Kategori();
        return $modelKategori->getDataKategori(['is_delete_kategori' => '0']);
    }

    public function getAllRak()
    {
        $modelRak = new M_Rak();
        return $modelRak->getDataRak(['is_delete_rak' => '0']);
    }

    public function autoNumber()
{
    log_message('debug', 'Memulai autoNumber...');
    $builder = $this->db->table($this->table);
    log_message('debug', 'Table: ' . $this->table);
    log_message('debug', 'Primary Key: ' . $this->primaryKey);
    $builder->selectMax($this->primaryKey);
    $query = $builder->get()->getRowArray();
    log_message('debug', 'Hasil Query selectMax: ' . print_r($query, true));
    if ($query) {
        $lastId = $query[$this->primaryKey];
        log_message('debug', 'Last ID dari query: ' . $lastId);
        $numericPart = intval(ltrim($lastId, 'BUK'));
        log_message('debug', 'Numeric Part: ' . $numericPart);
        $newNumericPart = $numericPart + 1;
        log_message('debug', 'New Numeric Part: ' . $newNumericPart);
        $newId = 'BUK' . sprintf('%03d', $newNumericPart);
        log_message('debug', 'New ID: ' . $newId);
        return $newId;
    } else {
        log_message('debug', 'Query tidak menghasilkan data, mengembalikan BUK001');
        return 'BUK001';
    }
}
}