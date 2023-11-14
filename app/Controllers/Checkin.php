<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\PartnumberModel;
use App\Models\rakModel;
use App\Models\TransaksiModel;

class Checkin extends Controller
{
    public function __construct()
    {
        $this->PartnumberModel = new PartnumberModel();
        $this->RakModel = new rakModel();
        $this->TransaksiModel = new TransaksiModel();
    }

    public function index()
    {
        return view('scan_ci');
    }

    public function store() {
        $input = $this->request->getPost();
        $data = explode(',', $input['scan']);
        $partNo = $data[0];
        $scan = $data[3];

        $part = $this->PartnumberModel->where('part_number', $partNo)->first();
        if ($part === null) {
            session()->setFlashdata("fail", "Part Number belum ada di data master!");
            return redirect()->route('scan-ci');
        }

        $transaksi = $this->TransaksiModel->where('idPartNo', $part['idPartNo'])->where('status', 'checkin')->findAll();
        if (count($transaksi) <= 0) {
            $rak = $this->RakModel->where('status_rak', 'Kosong')->where('keterangan', $part['tipe_rak'])->findAll();
        } else {
            $rak = $this->RakModel->where('idRak', $transaksi[0]['idRak']);
        }

        if (count($rak) <= 0) {
            session()->setFlashdata("fail", "Semua rak sudah penuh, masukkan kedalam over area!");
            return redirect()->route('scan-ci');
        }
        return dd($rak);
    }
}
