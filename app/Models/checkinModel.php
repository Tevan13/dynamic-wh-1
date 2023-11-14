<?php

namespace App\Models;

use CodeIgniter\Model;

class checkinModel extends Model
{

    protected $table = 'tb_transaksi';
    protected $primaryKey = 'idTransaksi';
    protected $allowedFields = ['unique_scanid', 'status', 'tgl_ci', 'tgl_co', 'tgl_adjust']; // Add this line
    // public function addData($idPartno, $uniqueId)
    // {
    //     $this->db->table($this->table)->insert([
    //         'idPartno' => $idPartno,
    //         'unique_id' => $uniqueId,
    //         'status' => 'checkin',
    //         'tgl_ci' => date('Y-m-d H:i:s'), // Current datetime in SQL format
    //     ]);
    // }
}
