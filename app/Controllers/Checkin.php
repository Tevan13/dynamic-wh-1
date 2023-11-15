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
        helper('date');
        $now = date('Y-m-d H:i:s', now());
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
        $countPart = count($transaksi);
        if ($countPart <= 0) {
            $rak = $this->RakModel->where('status_rak', 'Kosong')->where('tipe_rak', $part['tipe_rak'])->first();
            $dataInput = [
                'idPartNo' => $part['idPartNo'],
                'idRak' => $rak['idRak'],
                'unique_scanid' => $scan,
                'status' => 'checkin',
                'tgl_ci' => $now,
            ];
            $store = $this->TransaksiModel->protect(false)->insert($dataInput, false);
            if ($store) {
                session()->setFlashdata("success", "Part number $partNo masuk kedalam rak " . $rak['kode_rak']);
                return redirect()->route('scan-ci');
            } else {
                session()->setFlashdata("fail", "Gagal menambahkan part number ke rak!");
                return redirect()->route('scan-ci');
            }
        } else {
            $rak = $this->RakModel->where('idRak', $transaksi[0]['idRak'])->first();
            if (($countPart + 1) <= intval($part['max_kapasitas'])) {
                $dataInput = [
                    'idPartNo' => $part['idPartNo'],
                    'idRak' => $rak['idRak'],
                    'unique_scanid' => $scan,
                    'status' => 'checkin',
                    'tgl_ci' => $now,
                ];
                $store = $this->TransaksiModel->protect(false)->insert($dataInput, false);
                if ($store) {
                    session()->setFlashdata("success", "Part number $partNo masuk kedalam rak " . $rak['kode_rak']);
                    return redirect()->route('scan-ci');
                } else {
                    session()->setFlashdata("fail", "Gagal menambahkan part number ke rak!");
                    return redirect()->route('scan-ci');
                }
            } else {
                session()->setFlashdata("fail", "Semua rak sudah penuh, masukkan kedalam over area!");
                return redirect()->route('scan-ci');
            }
        }

        if (count($rak) <= 0) {
            session()->setFlashdata("fail", "Semua rak sudah penuh, masukkan kedalam over area!");
            return redirect()->route('scan-ci');
        }
        session()->setFlashdata("fail", "Terjadi kesalahan program!");
        return redirect()->route('scan-ci');

    }
}
