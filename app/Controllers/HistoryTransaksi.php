<?php

namespace App\Controllers;

use App\Models\HistoryTransaksiModel;
use App\Controllers\BaseController;

//untuk export ke excel
if (isset($_POST['submit'])) {
    $history = new HistoryTransaksiModel();
    $data = [];

    if (!isset($error)) {
        $title = "No,No Transaksi, Part No, Status Delivery, Tanggal Check In, Tanggal Check Out";
        $content = $data;

        $fileName = ("HistoryTransaksi") . $data . $id . (".csv");
        header('Content-Type: application/csv');
        header('Content-Disposition: attachment; filename="' . $fileName);
        echo $content;
        exit();
    }
}

class HistoryTransaksi extends BaseController
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
    public function update()
    {
        $model = new HistoryTransaksiModel;
        $data = $this->request->getPost();
        // var_dump($model);
        $post = $this->$model->protect(false)->insert($data, false);

        if ($post) {
            return redirect()->route('history');
        }
        return redirect()->route('history');
    }

    public function search()
    {
        if (isset($_GET['cari'])) {
            $cari = $_GET['cari'];
            echo "<b>Hasil pencarian : " . $cari . "</b>";
        }
    }

    public function export() {
        $model = new HistoryTransaksiModel;
        $data = $this->request->getGet();
        $post = $this->$model->protect(false)->insert($data, false);
    }
}
