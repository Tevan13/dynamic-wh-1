<?php

namespace App\Controllers;

use App\Models\picModel;
use App\Models\rakModel;
use CodeIgniter\Controller;
use App\Models\TransaksiModel;
use App\Models\HistoryTransaksiModel;

class Checkout extends Controller
{
    public function __construct()
    {
        $this->picModel = new picModel();
        $this->RakModel = new rakModel();
        $this->TransaksiModel = new TransaksiModel();
        $this->HistoryModel = new HistoryTransaksiModel();
    }
    public function index()
    {
        if (session()->get('tb_user') == null) {
            return redirect()->to('/login');
        }

        $data = [
            'picList' => $this->picModel->getPicList(),
            'title' => 'SCAN CHECKOUT'
        ];
        return view('scan_co', $data);
    }

    public function store() {
        helper('date');
        $now = date('Y-m-d H:i:s', now());
        $input = $this->request->getPost();
        $data = explode(',', $input['scan']);
        $partNo = $data[0];
        $scan = $data[3];
        $transaksi = $this->TransaksiModel->where('unique_scanid', $scan)->whereNotIn('status', ['checkout'])->first();
        if (empty($transaksi)) {
            session()->setFlashdata("fail", "Part number $partNo tidak terdata dalam rak pada database atau sudah di checkout");
            return redirect()->route('scan-co');
        }
        $rak = $this->RakModel->find($transaksi['idRak']);
        $rak['total_packing'] -= 1;
        if ($rak['total_packing'] === 0) {
            $rak['status_rak'] = 'kosong';
        } else {
            $rak['status_rak'] = 'terisi';
        }
        // $coba = $this->RakModel->where('idRak', $transaksi['idRak'])->find();
        // return dd($coba);
        $this->RakModel->protect(false)->where('idRak', $transaksi['idRak'])->set(['total_packing' => $rak['total_packing'], 'status_rak' => $rak['status_rak']])->update();
        $historyData = [
            'trans_metadata' => json_encode([
                'idTransaksi' => $transaksi['idTransaksi'],
                'unique_scanid' => $scan,
                'part_number' => $partNo,
                'kode_rak' => $rak['kode_rak'],
                'status' => 'checkout',
                'pic' => $transaksi['pic'],
                'tgl_co' => $now,
            ]),
        ];
        $this->HistoryModel->insert($historyData);
        $update = $this->TransaksiModel->where('unique_scanid', $scan)->whereNotIn('status', ['checkout'])->set(['status' => 'checkout', 'tgl_co' => $now])->update();
        if ($update) {
            session()->setFlashdata("success", "Part number $partNo diambil dari rak");
        } else {
            session()->setFlashdata("fail", "Part number $partNo gagal diambil dari rak");
        }
        return redirect()->route('scan-co');
    }
}
