<?php

namespace App\Models;

use CodeIgniter\Model;

class picModel extends Model
{
    protected $table = 'tb_pic';
    protected $primaryKey = 'id';
    protected $allowedFields = ['pic', 'departemen'];
    public function getPicList()
    {
        return $this->db->table('tb_pic')->get()->getResultArray();
    }
    public function addPic($pic)
    {
        return $this->db->table('tb_pic')->insert($pic);
    }
    public function updatePic($id, $pic)
    {
        if ($this->db->table('tb_pic')->getWhere(["id" => $id])->getResultArray() == null) {
            return $this->db->table('tb_pic')->insert($pic);
        }
        return $this->db->table('tb_pic')->update($pic, ["id" => $id]);
    }
    public function deleteUser($id)
    {
        return $this->db->query('DELETE FROM `tb_user` WHERE id=?', [$id]);
    }
}
