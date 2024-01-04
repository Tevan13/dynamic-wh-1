<?php

namespace App\Controllers;

use App\Models\TransaksiModel;
use CodeIgniter\Controller;

class TestHistory extends Controller
{
    public function index()
    {
        $model = new TransaksiModel();
        $data['transaksi'] = $model->getTransaksi();

        return view('HistoryTransaksiView1', $data);
    }
}
