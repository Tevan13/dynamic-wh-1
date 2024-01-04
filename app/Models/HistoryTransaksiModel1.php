<?php

namespace App\Models;

use CodeIgniter\Model;

class HistoryTransaksiModel1 extends Model
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


    public function getCheckin($status, $minDate)
    {
        // $minDate = isset($dateRange['min']) ? $dateRange['min'] : date('Y-m-d');
        // $maxDate = isset($dateRange['max']) ? $dateRange['max'] : date('Y-m-d');

        $result = $this->db->table('transaksi_history')
            ->where("trans_metadata LIKE '%\"status\":\"$status\"%'")
            ->where("trans_metadata LIKE '%\"tgl_ci\":\"$minDate%'")
            ->orderBy('id', 'desc') // Assuming you want to order by id in descending order
            ->get()
            ->getResultArray();
        return $result;
    }

    public function getCheckout($status, $minDate)
    {
        // $minDate = isset($dateRange['min']) ? $dateRange['min'] : '2000/01/01';
        // $maxDate = isset($dateRange['max']) ? $dateRange['max'] : '2000/01/10';

        $result = $this->db->table('transaksi_history')
            ->where("trans_metadata LIKE '%\"status\":\"$status\"%'")
            ->where("trans_metadata LIKE '%\"tgl_co\":\"$minDate%'")
            // ->where("order by id desc")
            ->orderBy('id', 'desc') // Assuming you want to order by id in descending order
            ->get()
            ->getResultArray();
        return $result;
    }

    public function getTransaksiCheckout($status, $dateRange)
    {
        $minDate = isset($dateRange['min']) ? $dateRange['min'] : '2000/01/01';
        $maxDate = isset($dateRange['max']) ? $dateRange['max'] : '2000/01/10';

        $result = $this->db->table('transaksi_history')
            ->where("trans_metadata LIKE '%\"status\":\"$status\"%'")
            ->where("trans_metadata LIKE '%\"tgl_co\":\"$minDate%'")
            ->where("trans_metadata LIKE '%\"tgl_co\":\"$maxDate%'")
            ->get()
            ->getResultArray();
        return $result;
    }
    // protected $table = 'transaksi_history'; // Sesuaikan dengan nama tabel yang digunakan

    // public function deleteTransaction($checkout, $status)
    // {
    //     // Implementasi query DELETE
    //     $this->where('idTransaksi', $checkout)
    //          ->where('status', $status)
    //          ->delete();

    //     // Tambahan untuk menghapus dari tabel transaksi_history
    //     $this->deleteFromHistory($checkout, $status);

    //     return true; // Atau sesuaikan dengan logika yang sesuai
    // }

    // private function deleteFromHistory($checkout, $status)
    // {
    //     // Implementasi query DELETE dari tabel transaksi_history
    //     $this->db->table('transaksi_history')
    //          ->where("JSON_EXTRACT(transaksi_history.trans_metadata, '$.idTransaksi')", $checkout)
    //          ->where("JSON_EXTRACT(transaksi_history.trans_metadata, '$.status')", $status)
    //          ->delete();
    // }
    public function hapusHistory($id)
    {
        return $this->db->query('DELETE FROM history_transaksi WHERE id=?', [$id]);
    }

    public function getAdjustment($minDate)
    {
        $result = $this->db->table('transaksi_history')
            ->where("trans_metadata LIKE '%\"tgl_adjust\":\"$minDate%'")
            ->orderBy('id', 'desc') // Assuming you want to order by id in descending order
            ->get()
            ->getResultArray();
        return $result;
    }
    public function getRetur($status, $minDate)
    {
        // $minDate = isset($dateRange['min']) ? $dateRange['min'] : date('Y-m-d');
        // $maxDate = isset($dateRange['max']) ? $dateRange['max'] : date('Y-m-d');

        $result = $this->db->table('transaksi_history')
            ->where("trans_metadata LIKE '%\"status\":\"$status\"%'")
            ->where("trans_metadata LIKE '%\"tgl_retur\":\"$minDate%'")
            ->orderBy('id', 'desc') // Assuming you want to order by id in descending order
            ->get()
            ->getResultArray();
        return $result;
    }
    public function deleteCheckout($status, $minDate)
{
    try {
        // Begin transaction
        $this->db->transBegin();

        // Step 1: Get checkin entities to be deleted
        $checkoutsToDelete = $this->db->table('transaksi_history')
            ->select('id') // Select only the IDs for deletion
            ->where("trans_metadata LIKE '%\"status\":\"$status\"%'")
            ->where("trans_metadata LIKE '%\"tgl_ci\":\"$minDate%'")
            ->get()
            ->getResultArray();

        // Step 2: Delete each checkin entity
        foreach ($checkoutsToDelete as $checkout) {
            $this->deleteCheckoutEntity($checkout['id']);
        }

        // Commit transaction if everything is successful
        $this->db->transCommit();

        return true;
    } catch (Exception $e) {
        // Rollback transaction if an error occurs
        $this->db->transRollback();
        echo "Error: " . $e->getMessage();
        return false;
    }
}

private function deleteCheckoutEntity($checkoutId)
{
    // Implementation to delete checkin entity
    // Example: DELETE FROM transaksi_history WHERE id = :checkinId
    // Use the appropriate query for your database structure
    $this->db->table('transaksi_history')->delete(['id' => $checkoutId]);
}

}
