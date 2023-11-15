<?php

namespace App\Models;

use CodeIgniter\Model;

class rakModel extends Model
{
    protected $table = "tb_rak";
    protected $primaryKey = "idRak";
    protected $allowedFields = ["kode_rak", "tipe_rak", "status_rak", "created_at", "updated_at"];

    public function getMasterRAk()
    {
        return $this->db->table("tb_rak")->get()->getResultArray();
    }

    public function addMasterRak($data)
    {
        return $this->db->table('tb_rak')->insert($data);
    }

    public function updateMasterRak($id, $data)
    {
        if ($this->db->table('tb_rak')->getWhere(["idRak" => $id])->getResultArray() == null) {
            return $this->db->table('tb_rak')->insert($data);
        }
        return $this->db->table('tb_rak')->update($data, ["idRak" => $id]);
    }

    public function deleteMasterRak($id)
    {
        return $this->db->query('DELETE FROM `tb_rak` WHERE idRak=?', [$id]);
    }

    public function getRakBy($id)
    {
        return $this->db->table('tb_rak')->getWhere(["idRak" => $id])->getResultArray();
    }
}
