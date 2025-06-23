<?php
namespace App\Models;

use CodeIgniter\Model;

class M_Pengembalian extends Model
{
    protected $table = 'tbl_pengembalian';
    protected $primaryKey = 'no_pengembalian';
    protected $allowedFields = [
        'no_pengembalian', 'no_peminjaman', 'denda', 'id_admin'
    ];

    public function getDataPengembalian($where = false)
    {
        $builder = $this->db->table($this->table);
        $builder->select('*');
        if ($where) {
            $builder->where($where);
        }
        $builder->orderBy('no_pengembalian', 'DESC');
        return $builder->get();
    }

    public function saveDataPengembalian($data)
    {
        $builder = $this->db->table($this->table);
        return $builder->insert($data);
    }
}
