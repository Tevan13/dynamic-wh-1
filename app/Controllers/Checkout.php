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
            $successMessage = false;

            foreach ($json as $data) {
                helper('date');
                $now = date('Y-m-d H:i:s', now());
                $scan = $data->unique_scanid;
                $lot = $data->lts;
                $quantity = $data->qty;
                $partNo = $data->part_number;
                $pic = $data->pic;

                // Check if transaction exists and status is suitable
                $transaksi = $this->TransaksiModel
                    ->where('unique_scanid', $scan)
                    ->whereNotIn('status', ['checkout', 'adjust_co'])
                    ->first();

                if (empty($transaksi)) {
                    continue; // Skip to the next iteration if the transaction doesn't exist
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
                        'lot' => $lot,
                        'quantity' => $quantity,
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
                    $successMessage = true; // Set the flag to true if at least one update is successful
                }
            }
            if ($successMessage) {
                session()->setFlashdata("success", "Setidaknya satu part number berhasil diambil dari rak");
            } else {
                session()->setFlashdata("fail", "LTS tidak ada atau sudah di checkout!");
            }

            return $this->response->setJSON(['success' => $successMessage, 'message' => $successMessage ? 'Data berhasil di checkout' : 'LTS tidak ada atau sudah di checkout!']);
        } else {

            return $this->response->setStatusCode(400);
        }
    }
}
