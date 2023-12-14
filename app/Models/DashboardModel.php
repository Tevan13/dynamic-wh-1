<?php

namespace App\Models;
use CodeIgniter\Model;

class DashboardModel extends Model {
    protected $table = 'tb_transaksi';

    public function getTransaksi($id = false) {
        if($id === false) {
            return $this->findAll();
        } else {
            return $this->getWhere(['idTransaksi' => $id]);
        }
    }
}