<?php

namespace App\Models;

use CodeIgniter\Model;

class TransaksiModel extends Model
{
    protected $table            = 'tb_transaksi';
    protected $primaryKey       = 'idTransaksi';
    protected $allowedFields    = ['idTransaksi,idPartNo,idRak,unique_scanid,status,pic,tgl_ci,tgl_co,tgl_adjust'];

    // protected $useAutoIncrement = true;
    // protected $returnType       = 'array';
    // protected $protectFields    = false;

    // // Dates
    // protected $useTimestamps = false;
    // protected $createdField  = 'created_at';
    // protected $updatedField  = 'updated_at';

    // // Validation
    // protected $validationRules      = [];
    // protected $validationMessages   = [];
    // protected $skipValidation       = false;
    // protected $cleanValidationRules = true;
    public function getTransaksiByUniqueId($unique_scanid)
    {
        return $this->where('unique_scanid', $unique_scanid)->first();
    }

    public function updateTransaksi($data)
    {
        $idTransaksi = $this->getTransaksiByUniqueId($data['unique_scanid'])['idTransaksi'];

        if ($idTransaksi) {
            $this->update($idTransaksi, $data);
            return true;
        }

        return false;
    }

    public function insertTransaksi($data)
    {
        $this->insert($data);
        return $this->insertID();
    }
    public function updateExistingData($unique_scanid, $partNumberId, $pic)
    {
        // Implement your logic to update existing data in the TransaksiModel
        $this->set(['idPartNo' => $partNumberId, 'pic' => $pic, 'status' => 'adjust_ci', 'tgl_adjust' => date('Y-m-d H:i:s')])
            ->where('unique_scanid', $unique_scanid)
            ->update();
    }
    public function insertNewData($data)
    {
        // Implement your logic to insert new data in the TransaksiModel
        $this->insertBatch($data);
    }
    public function updateAllAdjustCo($idRak, $unique_scanid)
    {
        // Update all records with the same 'idRak' to 'adjust_co'
        // Exclude records with the specified 'unique_scanid' values
        $this->set(['status' => 'adjust_co', 'tgl_adjust' => date('Y-m-d H:i:s')])
            ->where('idRak', $idRak)
            ->whereNotIn('unique_scanid', [$unique_scanid])
            ->update();
    }
}
