<?php

namespace App\Models;

use CodeIgniter\Model;

class rakModel extends Model
{
    protected $table = "tb_rak";
    protected $primaryKey = "idRak";
    protected $allowedFields = ["kode_rak", "tipe_rak", "total_packing", "status_rak", "created_at", "updated_at"];

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
    public function updateTotalPackingAndStatus($idRak, $maxCapacity)
    {
        try {
            // Increment total_packing
            $this->where('idRak', $idRak)->set('total_packing', 'total_packing + 1', false)->update();

            // Get updated total_packing
            $updatedTotalPacking = $this->where('idRak', $idRak)->get()->getRowArray()['total_packing'];

            // Update status_rak based on conditions
            $newStatus = ($updatedTotalPacking < $maxCapacity) ? 'Terisi' : 'Penuh';
            $this->where('idRak', $idRak)->set('status_rak', $newStatus)->update();

            return true;  // Success
        } catch (\Exception $e) {
            log_message('error', 'Error updating total_packing and status_rak: ' . $e->getMessage());
            return false;  // Error
        }
    }
    public function updateOverArea($idRak)
    {
        try {
            $this->where('idRak', $idRak)->set('total_packing', 'total_packing + 1', false)->update();
            return true;  // Success
        } catch (\Exception $e) {
            log_message('error', 'Error updating total_packing: ' . $e->getMessage());
            return false;  // Error
        }
    }
}
