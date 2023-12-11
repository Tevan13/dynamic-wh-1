<?php

namespace App\Models;

use CodeIgniter\Model;

class overAreaModel extends Model
{
    public function getOverArea()
    {
        $result = $this->db->table("tb_rak")->getWhere(['tipe_rak' => 'Over Area'])->getResultArray();
        foreach ($result as &$item) {
            $item['transaksi'] = $this->getTransaksiForOverArea($item['idRak']);
        }

        return $result;
    }
    public function getTransaksiForOverArea($idRak)
    {
        $query = $this->db->query("SELECT tb_transaksi.*, tb_partno.part_number
        FROM tb_transaksi
        LEFT JOIN tb_partno ON tb_transaksi.idPartno = tb_partno.idPartno
        WHERE idRak = $idRak AND status IN ('checkin', 'adjust_ci')
        ");

        return $query->getResultArray();
    }
}
