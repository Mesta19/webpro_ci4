<?php

namespace App\Models;

use CodeIgniter\Model;

class M_Rak extends Model
{
    protected $table      = 'tbl_rak';
    protected $primaryKey = 'id_rak';
    protected $allowedFields = [
        'id_rak',
        'nama_rak',
        'is_delete_rak',
        'created_at',
        'updated_at'
    ];

    public function getDataRak($where = [])
    {
    $builder = $this->db->table($this->table);
    $builder->select('*')
            ->where('is_delete_rak', '0');
    if (! empty($where)) {
        $builder->where($where);
    }
    $builder->orderBy('nama_rak', 'ASC');
    return $builder->get()->getResultArray();
    }

    public function nextId()
    {
        $row = $this->select('id_rak')
                    ->orderBy('id_rak', 'DESC')
                    ->limit(1)
                    ->get()
                    ->getRowArray();
        if (! $row) {
            return 'RAK001';
        }
        $num = (int) substr($row['id_rak'], 3) + 1;
        return 'RAK' . str_pad($num, 3, '0', STR_PAD_LEFT);
    }

    public function insertRak(array $data)
    {
        return $this->insert($data);
    }

    public function updateRak(array $data, array $where)
    {
        return $this->where($where)->set($data)->update();
    }

    public function softDelete(array $where)
    {
        return $this->where($where)
                    ->set([
                        'is_delete_rak' => '1',
                        'updated_at'    => date('Y-m-d H:i:s'),
                    ])->update();
    }
}
