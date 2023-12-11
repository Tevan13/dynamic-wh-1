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

    public function store()
    {
        if ($this->request->isAJAX()) {
            $json = $this->request->getJSON();

            foreach ($json as $data) {
                helper('date');
                $now = date('Y-m-d H:i:s', now());
                $scan = $data->unique_scanid;
                $partNo = $data->part_number;
                $pic = $data->pic;

                // Check if transaction exists and status is suitable
                $transaksi = $this->TransaksiModel
                    ->where('unique_scanid', $scan)
                    ->whereNotIn('status', ['checkout', 'adjust_co'])
                    ->first();

                if (empty($transaksi)) {
                    return $this->response->setJSON(['success' => false, 'message' => 'LTS tidak ada atau sudah di checkout!']);
                }

                $rak = $this->RakModel->find($transaksi['idRak']);
                $rak['total_packing'] -= 1;

                if ($rak['total_packing'] === 0) {
                    $rak['status_rak'] = 'kosong';
                } else {
                    $rak['status_rak'] = 'terisi';
                }

                $this->RakModel->protect(false)
                    ->where('idRak', $transaksi['idRak'])
                    ->set(['total_packing' => $rak['total_packing'], 'status_rak' => $rak['status_rak']])
                    ->update();

                $historyData = [
                    'trans_metadata' => json_encode([
                        'idTransaksi' => $transaksi['idTransaksi'],
                        'unique_scanid' => $scan,
                        'part_number' => $partNo,
                        'kode_rak' => $rak['kode_rak'],
                        'status' => 'checkout',
                        'pic' => $pic,
                        'tgl_co' => $now,
                    ]),
                ];
                $this->HistoryModel->insert($historyData);

                $update = $this->TransaksiModel->protect(false)
                    ->where('unique_scanid', $scan)
                    ->whereNotIn('status', ['checkout', 'adjust_co'])
                    ->set(['status' => 'checkout', 'tgl_co' => $now, 'pic' => $pic])
                    ->update();

                if ($update) {
                    session()->setFlashdata("success", "Part number $partNo diambil dari rak");
                } else {
                    session()->setFlashdata("fail", "Part number $partNo gagal diambil dari rak");
                }
            }

            return $this->response->setJSON(['success' => true, 'message' => 'Data berhasil di checkout']);
        }

        return $this->response->setStatusCode(400);
    }
}
