<?php

namespace App\Controllers;

use App\Models\HistoryTransaksiModel;
use CodeIgniter\Controller;

class HistoryTransaksi extends Controller {
    public function index() {
        $model = new HistoryTransaksiModel;
        $data['title'] = 'History Transaksi';
        $data['trans'] = $model->getTransaksi();
        echo view('historyTransaksiView', $data);
    }
}