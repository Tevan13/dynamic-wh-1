<?php

namespace App\Models;

use CodeIgniter\Model;

class HistoryTransaksiModel extends Model
{
    protected $table            = 'transaksi_history';
    // protected $primaryKey       = 'idTransaksi';
    // protected $useAutoIncrement = true;
    // protected $returnType       = 'array';
    protected $allowedFields    = ['trans_metadata'];

    //     // Dates
    // protected $useTimestamps = true;
    // protected $createdField  = 'tgl_ci';
    // protected $updatedField  = 'tgl_co';

    // //     // Validation
    // protected $validationRules      = [];
    // protected $validationMessages   = [];
    // protected $skipValidation       = false;
    // protected $cleanValidationRules = true;


    public function getTransaksiBy($status, $dateRange)
    {
        $minDate = isset($dateRange['min']) ? $dateRange['min'] : '2000/01/01';
        $maxDate = isset($dateRange['max']) ? $dateRange['max'] : '2000/01/10';

        $result = $this->db->table('transaksi_history')
            ->where("trans_metadata LIKE '%\"status\":\"$status\"%'")
            ->where("trans_metadata LIKE '%\"tgl_ci\":\"$minDate%'")
            ->where("trans_metadata LIKE '%\"tgl_ci\":\"$maxDate%'")
            ->get()
            ->getResultArray();
        return $result;
    }
}
