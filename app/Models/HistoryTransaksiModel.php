<?php

namespace App\Models;
use CodeIgniter\Model;

class HistoryTransaksiModel extends Model {
    protected $table = 'tb_transaksi';
    

    public function getTransaksi($id = false) {
        if($id === false) {
            return $this->findAll();
        } else {
            return $this->getWhere(['idTransaksi' => $id]);
        }
    }
}

// <?php

// namespace App\Models;

// use CodeIgniter\Model;

// class HistoryTransaksiModel extends Model {
//     protected $table            = 'tb_transaksi';
//     protected $primaryKey       = 'idTransaksi';
//     protected $useAutoIncrement = true;
//     protected $returnType       = 'array';
//     protected $allowedFields    = ['idTransaksi', 'idPartNo', 'idRak', 'status_delivery','tgl_ci','tgl_co'];

//     // Dates
//     protected $useTimestamps = false;
//     // protected $dateFormat    = 'datetime';
//     protected $createdField  = 'created_at';
//     protected $updatedField  = 'updated_at';
//     // protected $deletedField  = 'deleted_at';

//     // Validation
//     protected $validationRules      = [];
//     protected $validationMessages   = [];
//     protected $skipValidation       = false;
//     protected $cleanValidationRules = true;
// }

