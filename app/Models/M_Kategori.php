<?php

namespace App\Models;

use CodeIgniter\Model;

class M_Kategori extends Model
{
    protected $table      = 'tbl_kategori';
    protected $primaryKey = 'id_kategori';
    protected $allowedFields = [
        'id_kategori',
        'nama_kategori',
        'is_delete_kategori',
        'created_at',
        'updated_at'
    ];

    public function getDataKategori($where = [])
    {
        $builder = $this->db->table($this->table);
        $builder->select('*')
                ->where('is_delete_kategori', '0');

        if (! empty($where)) {
            $builder->where($where);
        }

        $builder->orderBy('nama_kategori', 'ASC');
        return $builder->get()->getResultArray();
    }

    public function saveDataKategori(array $data)
    {
        return $this->insert($data);
    }

    public function updateDataKategori(array $data, array $where)
    {
        return $this->where($where)->set($data)->update();
    }

    public function softDelete(array $where)
    {
        $data = [
            'is_delete_kategori' => '1',
            'updated_at'         => date('Y-m-d H:i:s'),
        ];
        return $this->where($where)->set($data)->update();
    }

    public function getNextId()
    {
        $row = $this->select('id_kategori')
                    ->orderBy('id_kategori', 'DESC')
                    ->limit(1)
                    ->get()
                    ->getRowArray();
        if (! $row) {
            return 'KTG001';
        }
        $num = (int) substr($row['id_kategori'], 3) + 1;
        return 'KTG' . str_pad($num, 3, '0', STR_PAD_LEFT);
    }
}
