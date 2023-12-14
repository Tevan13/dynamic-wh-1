<?php

namespace App\Controllers;

use App\Models\HistoryTransaksiModel;
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
            'title' => 'SCAN CHECKIN'
        ];
        return view('scan_ci', $data);
    }

    public function store()
    {
        helper('date');
        $now = date('Y-m-d H:i:s', now());
        $scan = $this->request->getPost('scan');
        $pic = $this->request->getPost('pic');
        $data = explode(',', $scan);
        if (count($data) !== 4) {
            session()->setFlashdata("fail", "Mohon scan QR Code LTS!");
            return redirect()->route('scan-ci');
        }
        $partNo = $data[0];
        $lot = $data[1];
        $quantity = $data[2];
        $scan = $data[3];

        $part = $this->PartnumberModel->where('part_number', $partNo)->first();
        if ($part === null) {
            session()->setFlashdata("fail", "Part Number belum ada di data master!");
            return redirect()->route('scan-ci');
        }

        $existingScan = $this->TransaksiModel->where('unique_scanid', $scan)
                        ->where('status', 'checkin')->first();
        if ($existingScan !== null) {
            session()->setFlashdata("fail", "LTS ini sudah terscan. Mohon scan LTS lain");
            return redirect()->route('scan-ci');
        }

        $transaksi = $this->TransaksiModel->where('idPartNo', $part['idPartNo'])->where('status', 'checkin')->findAll();
        if (count($transaksi) <= 0) {
            $rak = $this->RakModel->where('status_rak', 'Kosong')->where('tipe_rak', $part['tipe_rak'])->first();
            if (!$rak) {
                $rak = $this->RakModel->where('tipe_rak', 'Over Area')->first();
            }
            $dataInput = [
                'idPartNo' => $part['idPartNo'],
                'idRak' => $rak['idRak'],
                'unique_scanid' => $scan,
                'lot' => $lot,
                'quantity' => $quantity,
                'status' => 'checkin',
                'pic' => $pic,
                'tgl_ci' => $now,
            ];
            $store = $this->TransaksiModel->protect(false)->insert($dataInput, false);
            $insertedID = $this->TransaksiModel->insertID();
            if ($store) {
                if ($rak['tipe_rak'] !== 'Over Area') {
                    // Increment total_packing in tb_rak
                    $updateResult = $this->RakModel->updateTotalPackingAndStatus($rak['idRak'], $part['max_kapasitas']);
                    if ($updateResult) {
                        // Insert into transaksi_history
                        $historyData = [
                            'trans_metadata' => json_encode([
                                'idTransaksi' => $insertedID,
                                'unique_scanid' => $scan,
                                'part_number' => $partNo,
                                'lot' => $lot,
                                'quantity' => $quantity,
                                'kode_rak' => $rak['kode_rak'],
                                'status' => 'checkin',
                                'pic' => $pic,
                                'tgl_ci' => $now,
                            ]),
                        ];
                        $this->historyModel->insert($historyData);
                        session()->setFlashdata("success", "Part number $partNo masuk kedalam rak " . $rak['kode_rak']);
                        return redirect()->route('scan-ci');
                    } else {
                        session()->setFlashdata("fail", "Failed to update total_packing in tb_rak");
                        return redirect()->route('scan-ci');
                    }
                } else {
                    // If the rack is 'Over Area', only increment total_packing
                    $updateResult = $this->RakModel->updateTotalPacking($rak['idRak']);
                    if ($updateResult) {
                        // Insert into transaksi_history
                        $historyData = [
                            'trans_metadata' => json_encode([
                                'idTransaksi' => $insertedID,
                                'unique_scanid' => $scan,
                                'part_number' => $partNo,
                                'lot' => $lot,
                                'quantity' => $quantity,
                                'kode_rak' => $rak['kode_rak'],
                                'status' => 'checkin',
                                'pic' => $pic,
                                'tgl_ci' => $now,
                            ]),
                        ];
                        $this->historyModel->insert($historyData);
                        session()->setFlashdata("success", "Part number $partNo masuk kedalam rak " . $rak['kode_rak']);
                        return redirect()->route('scan-ci');
                    } else {
                        session()->setFlashdata("fail", "Failed to update total_packing in tb_rak");
                        return redirect()->route('scan-ci');
                    }
                }
            } else {
                session()->setFlashdata("fail", "Gagal menambahkan part number ke rak!");
                return redirect()->route('scan-ci');
            }
        } else {
            $count = 0;
            foreach ($transaksi as $t) {
                $rak = $this->RakModel->find($t['idRak']);
                if ($rak['tipe_rak'] !== 'Over Area') {
                    $count++;
                }
            }
            $rak = $this->RakModel->where('idRak', $transaksi[0]['idRak'])->first();
            if ($count + 1 <= intval($part['max_kapasitas'])) {
                $dataInput = [
                    'idPartNo' => $part['idPartNo'],
                    'idRak' => $rak['idRak'],
                    'unique_scanid' => $scan,
                    'lot' => $lot,
                    'quantity' => $quantity,
                    'status' => 'checkin',
                    'pic' => $pic,
                    'tgl_ci' => $now,
                ];
                $store = $this->TransaksiModel->protect(false)->insert($dataInput, false);
                $insertedID = $this->TransaksiModel->insertID();
                if ($rak['tipe_rak'] !== 'Over Area') {
                    // Increment total_packing in tb_rak
                    $updateResult = $this->RakModel->updateTotalPackingAndStatus($rak['idRak'], $part['max_kapasitas']);
                    if ($updateResult) {
                        // Insert into transaksi_history
                        $historyData = [
                            'trans_metadata' => json_encode([
                                'idTransaksi' => $insertedID,
                                'unique_scanid' => $scan,
                                'part_number' => $partNo,
                                'lot' => $lot,
                                'quantity' => $quantity,
                                'kode_rak' => $rak['kode_rak'],
                                'status' => 'checkin',
                                'pic' => $pic,
                                'tgl_ci' => $now,
                            ]),
                        ];
                        $this->historyModel->insert($historyData);
                        session()->setFlashdata("success", "Part number $partNo masuk kedalam rak " . $rak['kode_rak']);
                        return redirect()->route('scan-ci');
                    } else {
                        session()->setFlashdata("fail", "Failed to update total_packing in tb_rak");
                        return redirect()->route('scan-ci');
                    }
                } else {
                    // If the rack is 'Over Area', only increment total_packing
                    $updateResult = $this->RakModel->updateTotalPacking($rak['idRak']);
                    if ($updateResult) {
                        // Insert into transaksi_history
                        $historyData = [
                            'trans_metadata' => json_encode([
                                'idTransaksi' => $insertedID,
                                'unique_scanid' => $scan,
                                'part_number' => $partNo,
                                'lot' => $lot,
                                'quantity' => $quantity,
                                'kode_rak' => $rak['kode_rak'],
                                'status' => 'checkin',
                                'pic' => $pic,
                                'tgl_ci' => $now,
                            ]),
                        ];
                        $this->historyModel->insert($historyData);
                        session()->setFlashdata("success", "Part number $partNo masuk kedalam rak " . $rak['kode_rak']);
                        return redirect()->route('scan-ci');
                    } else {
                        session()->setFlashdata("fail", "Failed to update total_packing in tb_rak");
                        return redirect()->route('scan-ci');
                    }
                }
            } else {
                $rak = $this->RakModel->where('tipe_rak', 'Over Area')->first();
                $dataInput = [
                    'idPartNo' => $part['idPartNo'],
                    'idRak' => $rak['idRak'],
                    'unique_scanid' => $scan,
                    'lot' => $lot,
                    'quantity' => $quantity,
                    'status' => 'checkin',
                    'pic' => $pic,
                    'tgl_ci' => $now,
                ];
                $store = $this->TransaksiModel->protect(false)->insert($dataInput, false);
                $insertedID = $this->TransaksiModel->insertID();
                if ($store) {
                    $updateResult = $this->RakModel->updateOverArea($rak['idRak']);
                    if ($updateResult) {
                        // Insert into tb_history
                        $historyData = [
                            'trans_metadata' => json_encode([
                                'idTransaksi' => $insertedID,
                                'unique_scanid' => $scan,
                                'part_number' => $partNo,
                                'lot' => $lot,
                                'quantity' => $quantity,
                                'kode_rak' => $rak['kode_rak'],
                                'status' => 'checkin',
                                'pic' => $pic,
                                'tgl_ci' => $now,
                            ]),
                        ];
                        $this->historyModel->insert($historyData);
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
