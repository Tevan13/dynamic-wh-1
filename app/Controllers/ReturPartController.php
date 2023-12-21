<?php

namespace App\Controllers;

use App\Models\HistoryTransaksiModel;
use CodeIgniter\Controller;
use App\Models\PartnumberModel;
use App\Models\picModel;
use App\Models\rakModel;
use App\Models\TransaksiModel;

class ReturPartController extends Controller
{
    public function __construct()
    {
        $this->PartnumberModel = new PartnumberModel();
        $this->TransaksiModel = new TransaksiModel();
        $this->picModel = new picModel();
        $this->RakModel = new rakModel();
        $this->historyModel = new HistoryTransaksiModel();
    }
    public function index()
    {
        if (session()->get('tb_user') == null) {
            return redirect()->to('/login');
        }
        $data = [
            'picList' => $this->picModel->getPicList(),
            'title' => 'SCAN RETUR PART'
        ];
        return view('returPart', $data);
    }
    public function retur()
    {
        helper('date');
        $now = date('Y-m-d H:i:s', now());
        $scan = $this->request->getPost('scan');
        $data = explode(',', $scan);

        if (count($data) !== 4) {
            session()->setFlashdata("fail", "Mohon scan QR Code LTS!");
            return redirect()->route('return-part');
        }

        $partNo = $data[0];
        $lot = $data[1];
        $quantity = $data[2];
        $scan = $data[3];

        $part = $this->PartnumberModel->where('part_number', $partNo)->first();
        // return dd($part);

        $existingScan = $this->TransaksiModel->where('unique_scanid', $scan)
            ->whereIn('status', ['checkout', 'adjust_co'])->first();
        // return dd($existingScan);
        if (!$existingScan) {
            // Check for 'checkin' or 'adjust_ci' status
            $checkin = $this->TransaksiModel->where('unique_scanid', $scan)
                ->whereIn('status', ['checkin', 'adjust_ci'])->first();

            if ($checkin) {
                session()->setFlashdata("fail", "Part gagal dikembalikan status masih checkin!");
                return redirect()->route('return-part');
            } else {
                session()->setFlashdata("fail", "Lot tidak ditemukan atau belum di checkin!");
                return redirect()->route('return-part');
            }
        }
        // Update status to 'checkin' for 'checkout' or 'adjust_co'
        $this->TransaksiModel->where('unique_scanid', $scan)
            ->protect(false)
            ->whereIn('status', ['checkout', 'adjust_co'])
            ->set(['status' => 'checkin'])
            ->update();

        $rak = $this->RakModel->find($existingScan['idRak']);
        $rak['total_packing'] += 1;

        // Update status_rak based on total_packing and max_kapasitas
        if ($rak['total_packing'] >= $part['max_kapasitas']) {
            $rak['status_rak'] = 'Penuh';
        } else {
            $rak['status_rak'] = ($rak['total_packing'] > 0) ? 'terisi' : 'kosong';
        }

        $this->RakModel->protect(false)
            ->where('idRak', $existingScan['idRak'])
            ->set(['total_packing' => $rak['total_packing'], 'status_rak' => $rak['status_rak']])
            ->update();
        // Continue with your logic for successful update, if needed
        // Redirect or return success message
        session()->setFlashdata("success", "Part berhasil dikembalikan ke rak " . $rak['kode_rak'] . "!");
        return redirect()->route('return-part');
    }
}
