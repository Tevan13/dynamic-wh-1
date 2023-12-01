<?php

namespace App\Models;

use CodeIgniter\Model;

class HistoryTransaksiModel extends Model {
    protected $table            = 'tb_transaksi';
    protected $primaryKey       = 'idTransaksi';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
//     protected $allowedFields    = ['idTransaksi', 'idPartNo', 'idRak', 'status_delivery','tgl_ci','tgl_co'];

//     // Dates
    protected $useTimestamps = true;
    protected $createdField  = 'tgl_ci';
    protected $updatedField  = 'tgl_co';

//     // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    
    public function getTransaksi($id = false)
    {
        if ($id === false) {
            return $this->findAll();
        } else {
            return $this->getWhere(['idTransaksi' => $id]);
        }
    }
}
