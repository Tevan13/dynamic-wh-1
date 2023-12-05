<?php

namespace App\Models;

use CodeIgniter\Model;

class informationModel extends Model
{
    public function getTransaksi($idRak, $status)
    {
        $query = $this->db->query("SELECT tb_transaksi.*, tb_partno.part_number
                FROM tb_transaksi
                LEFT JOIN tb_partno ON tb_transaksi.idPartno = tb_partno.idPartno
                WHERE tb_transaksi.idRak = $idRak
                AND tb_transaksi.status = '$status'
                ORDER BY tb_transaksi.tgl_ci DESC
                LIMIT 1");

        return $query->getRowArray();
    }

    public function getInfoRak()
    {
        $result = $this->db->table("tb_rak")->get()->getResultArray();

        foreach ($result as &$item) {
            if ($item['tipe_rak'] === 'Over Area') {
                $item['transaksi'] = $this->getTransaksiForOverArea($item['idRak']);
            }

            $transaksi = $this->getTransaksi($item['idRak'], 'checkin');
            if ($transaksi) {
                $item['part_number'] = $transaksi['part_number'];
                $item['tgl_ci'] = $transaksi['tgl_ci'];
            } else {
                $item['part_number'] = null;
                $item['tgl_ci'] = null;
            }
        }

        return $result;
    }

    public function getTransaksiForOverArea($idRak)
    {
        $query = $this->db->query("SELECT tb_transaksi.*, tb_partno.part_number
            FROM tb_transaksi
            LEFT JOIN tb_partno ON tb_transaksi.idPartno = tb_partno.idPartno
            WHERE idRak = $idRak");

        return $query->getResultArray();
    }
}
