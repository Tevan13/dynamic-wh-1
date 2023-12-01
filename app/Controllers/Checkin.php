<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\PartnumberModel;
use App\Models\picModel;
use App\Models\rakModel;
use App\Models\TransaksiModel;

class Checkin extends Controller
{
    public function __construct()
    {
        $this->PartnumberModel = new PartnumberModel();
        $this->RakModel = new rakModel();
        $this->TransaksiModel = new TransaksiModel();
        $this->picModel = new picModel();
    }

    public function index()
    {
        if (session()->get('tb_user') == null) {
            return redirect()->to('/login');
        }
        $data = [
            'picList' => $this->picModel->getPicList(),
            'title' => 'SCAN CHECKIN'
        ];
        return view('scan_ci', $data);
    }

    public function store()
    {
        helper('date');
        $now = date('Y-m-d H:i:s', now());
        $input = $this->request->getPost();
        $pic = $this->request->getPost('pic');
        $data = explode(',', $input['scan']);
        $partNo = $data[0];
        $scan = $data[3];

        $part = $this->PartnumberModel->where('part_number', $partNo)->first();
        if ($part === null) {
            session()->setFlashdata("fail", "Part Number belum ada di data master!");
            return redirect()->route('scan-ci');
        }
        // $existingScan = $this->TransaksiModel->where('unique_scanid', $scan)->first();
        // if ($existingScan !== null) {
        //     session()->setFlashdata("fail", "LTS ini sudah terscan. Mohon scan LTS lain");
        //     return redirect()->route('scan-ci');
        // }

        $transaksi = $this->TransaksiModel->where('idPartNo', $part['idPartNo'])->where('status', 'checkin')->findAll();
        $countPart = count($transaksi);
        if ($countPart <= 0) {
            $rak = $this->RakModel->where('status_rak', 'Kosong')->where('tipe_rak', $part['tipe_rak'])->first();
            $dataInput = [
                'idPartNo' => $part['idPartNo'],
                'idRak' => $rak['idRak'],
                'unique_scanid' => $scan,
                'status' => 'checkin',
                'pic' => $pic,
                'tgl_ci' => $now,
            ];
            $store = $this->TransaksiModel->protect(false)->insert($dataInput, false);
            if ($store) {
                // Increment total_packing in tb_rak
                $updateResult = $this->RakModel->updateTotalPackingAndStatus($rak['idRak'], $part['max_kapasitas']);
                if ($updateResult) {
                    session()->setFlashdata("success", "Part number $partNo masuk kedalam rak " . $rak['kode_rak']);
                    return redirect()->route('scan-ci');
                } else {
                    session()->setFlashdata("fail", "Failed to update total_packing in tb_rak");
                    return redirect()->route('scan-ci');
                }
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
                    'pic' => $pic,
                    'tgl_ci' => $now,
                ];
                $store = $this->TransaksiModel->protect(false)->insert($dataInput, false);
                if ($store) {
                    $updateResult = $this->RakModel->updateTotalPackingAndStatus($rak['idRak'], $part['max_kapasitas']);
                    if ($updateResult) {
                        session()->setFlashdata("success", "Part number $partNo masuk kedalam rak " . $rak['kode_rak']);
                        return redirect()->route('scan-ci');
                    } else {
                        session()->setFlashdata("fail", "Failed to update total_packing in tb_rak");
                        return redirect()->route('scan-ci');
                    }
                } else {
                    session()->setFlashdata("fail", "Gagal menambahkan part number ke rak!");
                    return redirect()->route('scan-ci');
                }
            } else {
                $rak = $this->RakModel->where('tipe_rak', 'Over Area')->first();
                $dataInput = [
                    'idPartNo' => $part['idPartNo'],
                    'idRak' => $rak['idRak'],
                    'unique_scanid' => $scan,
                    'status' => 'checkin',
                    'pic' => $pic,
                    'tgl_ci' => $now,
                ];
                $store = $this->TransaksiModel->protect(false)->insert($dataInput, false);
                if ($store) {
                    $updateResult = $this->RakModel->updateOverArea($rak['idRak']);
                    if ($updateResult) {
                        session()->setFlashdata("success", "Part number $partNo masuk kedalam rak " . $rak['kode_rak']);
                        return redirect()->route('scan-ci');
                    } else {
                        session()->setFlashdata("fail", "Failed to update total_packing in tb_rak");
                        return redirect()->route('scan-ci');
                    }
                } else {
                    session()->setFlashdata("fail", "Gagal menambahkan part number ke rak over area!");
                    return redirect()->route('scan-ci');
                }
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
