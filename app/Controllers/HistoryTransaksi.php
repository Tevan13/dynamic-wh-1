<?php

namespace App\Controllers;

use App\Models\HistoryTransaksiModel;
use CodeIgniter\Controller;

class HistoryTransaksi extends Controller
{
    public function index()
    {
        if (session()->get('tb_user') == null) {
            return redirect()->to('/login');
        }
        $model = new HistoryTransaksiModel;
        $data['title'] = 'History Transaksi';
        $data['trans'] = $model->getTransaksi();
        echo view('historyTransaksiView', $data);
    }
}
