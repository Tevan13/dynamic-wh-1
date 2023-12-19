<?php

namespace App\Controllers;

use App\Models\adjustmentModel;
use App\Models\HistoryTransaksiModel;
use App\Models\PartnumberModel;
use App\Models\picModel;
use App\Models\rakModel;
use App\Models\rModel;
use App\Models\TransaksiModel;
use CodeIgniter\Controller;

class AdjustmentController extends Controller
{
    public function __construct()
    {
        $this->picModel = new picModel();
        $this->rModel = new rakModel();
        $this->adjustModel = new adjustmentModel();
        $this->TransaksiModel = new TransaksiModel();
        $this->PnModel = new PartnumberModel();
        $this->HistoryModel = new HistoryTransaksiModel();
    }

    public function index()
    {
        if (session()->get('tb_user') == null) {
            return redirect()->to('/login');
        }
        $data = [
            'picList' => $this->picModel->getPicList(),
            'title' => 'SCAN ADJUSTMENT'
        ];
        return view('adjustment', $data);
    }

    public function store()
    {
        $pic = $this->request->getPost('pic');
        $uniqueAdjust = [];
        $now = date('Y-m-d H:i:s');
        $data = json_decode($this->request->getPost('hasil-scan'));
        $rakOver = $this->rModel->where('tipe_rak', 'Over Area')->first();
        $rak = $this->rModel->where('kode_rak', $this->request->getPost('rak'))->first();
        $pn = $this->PnModel->where('part_number', $data[0]->part_number)->first();
        $transaksi = $this->TransaksiModel->where('idRak', $rak['idRak'])
            ->whereIn('status', ['checkin', 'adjust_ci'])->findAll();
        $max = $pn['max_kapasitas'];
        $aktual = $rak['total_packing'];
        $history = [];

        foreach ($data as $d) {
            $exist = $this->TransaksiModel->where('idRak', $rak['idRak'])
                ->whereIn('status', ['checkin', 'adjust_ci'])
                ->where('unique_scanid', $d->unique_scanid)->first();
            $checkout = $this->TransaksiModel->where('unique_scanid', $d->unique_scanid)
                ->whereIn('status', ['checkout', 'adjust_co'])->first();
            // return dd($checkout);

            if ($exist !== null) {
                $history[] = [
                    'idTransaksi' => $exist['idTransaksi'],
                    'unique_scanid' => $d->unique_scanid,
                    'part_number' => $d->part_number,
                    'kode_rak' => $d->rak,
                    'lot' => $d->lts,
                    'quantity' => $d->qty,
                    'status' => 'adjust_ci',
                    'pic' => $d->pic,
                    'tgl_adjust' => $now,
                ];

                $uniqueAdjust[] = $exist['unique_scanid'];

                $this->TransaksiModel->protect(false)
                    ->where('unique_scanid', $exist['unique_scanid'])
                    ->set(['pic' => $d->pic, 'status' => 'adjust_ci', 'tgl_adjust' => $now])
                    ->update();
            } elseif ($checkout !== null) {
                $this->TransaksiModel->protect(false)
                    ->where('unique_scanid', $checkout['unique_scanid'])
                    ->set(['pic' => $d->pic, 'status' => 'adjust_ci', 'tgl_adjust' => $now])
                    ->update();
                $uniqueAdjust[] = $checkout['unique_scanid'];
                // return dd($uniqueAdjust);
            } else {
                $insertedId;
                if ((intval($aktual) + 1) <= intval($max)) {
                    $dataInput = [
                        'idPartNo' => $pn['idPartNo'],
                        'idRak' => $rak['idRak'],
                        'unique_scanid' => $d->unique_scanid,
                        'lot' => $d->lts,
                        'quantity' => $d->qty,
                        'status' => 'adjust_ci',
                        'pic' => $d->pic,
                        'tgl_adjust' => $now,
                    ];

                    $uniqueAdjust[] = $d->unique_scanid;

                    $store = $this->TransaksiModel->protect(false)->insert($dataInput, false);
                    $insertedID = $this->TransaksiModel->insertID();
                } else {
                    $dataInput = [
                        'idPartNo' => $pn['idPartNo'],
                        'idRak' => $rakOver['idRak'],
                        'unique_scanid' => $d->unique_scanid,
                        'lot' => $d->lts,
                        'quantity' => $d->qty,
                        'status' => 'adjust_ci',
                        'pic' => $d->pic,
                        'tgl_adjust' => $now,
                    ];

                    $store = $this->TransaksiModel->protect(false)->insert($dataInput, false);
                    $insertedID = $this->TransaksiModel->insertID();
                }
                $history[] = [
                    'idTransaksi' => $insertedID,
                    'unique_scanid' => $d->unique_scanid,
                    'part_number' => $d->part_number,
                    'kode_rak' => $d->rak,
                    'lot' => $d->lts,
                    'quantity' => $d->qty,
                    'status' => 'adjust_ci',
                    'pic' => $d->pic,
                    'tgl_adjust' => $now,
                ];
            }
        }

        $transaksi2 = $this->TransaksiModel->where('idRak', $rak['idRak'])
            ->whereIn('status', ['checkin', 'adjust_ci'])
            ->whereNotIn('unique_scanid', $uniqueAdjust)->findAll();
        // return dd($transaksi2);

        if (count($transaksi2) > 0) {
            foreach ($transaksi2 as $d) {
                $history[] = [
                    'idTransaksi' => $d['idTransaksi'],
                    'unique_scanid' => $d['unique_scanid'],
                    'part_number' => $pn['part_number'],
                    'kode_rak' => $rak['kode_rak'],
                    'lot' => $d['lot'],
                    'quantity' => $d['quantity'],
                    'status' => 'adjust_co',
                    'pic' => $d['pic'],
                    'tgl_adjust' => $now,
                ];

                $this->TransaksiModel->protect(false)
                    ->where('unique_scanid', $d['unique_scanid'])
                    ->set(['pic' => $pic, 'status' => 'adjust_co', 'tgl_adjust' => $now])
                    ->update();
            }
        }

        $nowPack = $this->TransaksiModel->where('idRak', $rak['idRak'])
            ->whereIn('status', ['checkin', 'adjust_ci'])->findAll();
        if (count($nowPack) == intval($max)) {
            $this->rModel->protect(false)->where('kode_rak', $rak['kode_rak'])
                ->set(['status_rak' => 'Penuh', 'total_packing' => count($nowPack)])->update();
        }
        if (count($nowPack) < intval($max)) {
            $this->rModel->protect(false)->where('kode_rak', $rak['kode_rak'])
                ->set(['status_rak' => 'Terisi', 'total_packing' => count($nowPack)])->update();
        }

        $historyData = [
            'trans_metadata' => json_encode($history),
        ];
        $this->HistoryModel->insert($historyData);

        session()->setFlashdata("success", "Data adjusted successfully");
        return redirect()->route('adjustment');
    }

    // public function add()
    // {
    //     $history = [];
    //     // Check if it's a POST request and get JSON data from the AJAX request
    //     if ($this->request->isAJAX()) {
    //         $json = $this->request->getJSON();
    //         $dataInputs = [];

    //         // Update all data in the same 'idRak' to 'adjust_co'
    //         foreach ($json as $data) {
    //             $rak = $data->rak;
    //             $pic = $data->pic;
    //             $partNumber = $data->part_number;

    //             $rakRow = $this->rModel->where('kode_rak', $rak)->first();
    //             if (!$rakRow) {
    //                 return $this->response->setStatusCode(400)->setJSON(['success' => false, 'message' => 'Rak tidak ditemukan!']);
    //             }

    //             $partNumberRow = $this->PnModel->where('part_number', $partNumber)->first();
    //             if (!$partNumberRow) {
    //                 return $this->response->setStatusCode(400)->setJSON(['success' => false, 'message' => 'Part number tidak ditemukan!']);
    //             }

    //             // $cek = $this->TransaksiModel->where('idRak', $rakRow['idRak'])->where("status != 'checkout' OR status != 'adjust_co'")->get();
    //             $cek = $this->TransaksiModel->where('idRak', $rakRow['idRak'])->where("status != 'checkout' OR status != 'adjust_co'");

    //             $history[] = $cek;

    //             // $this->TransaksiModel->protect(false)->where('idRak', $rakRow['idRak'])
    //             //     ->set(['pic' => $pic, 'status' => 'adjust_co', 'tgl_adjust' => date('Y-m-d H:i:s')])
    //             //     ->update();
    //         }

    //         return $this->response->setStatusCode(400)->setJSON(['success' => false, 'message' => $history]);

    //         // Check each 'unique_scanid' in the JSON
    //         foreach ($json as $data) {
    //             $rak = $data->rak;
    //             $uniqueScanId = $data->unique_scanid;
    //             $partNumber = $data->part_number;
    //             $pic = $data->pic;
    //             $lot = $data->lts;
    //             $quantity = $data->qty;

    //             $rakRow = $this->rModel->where('kode_rak', $rak)->first();

    //             if (!$rakRow) {
    //                 return $this->response->setStatusCode(400)->setJSON(['success' => false, 'message' => 'Rak tidak ditemukan!']);
    //             }
    //             $partNumberRow = $this->PnModel->where('part_number', $partNumber)->first();

    //             if (!$partNumberRow) {
    //                 return $this->response->setStatusCode(400)->setJSON(['success' => false, 'message' => 'Part number tidak ditemukan!']);
    //             }


    //             // Check if 'unique_scanid' exists in the database
    //             $existingTransaksi = $this->TransaksiModel
    //                 ->where('idRak', $rakRow['idRak'])
    //                 ->where('unique_scanid', $uniqueScanId)
    //                 ->first();

    //             if ($existingTransaksi !== null) {
    //                 // Condition: unique_scanid matched in json and database
    //                 // Update the existing data to 'adjust_ci'
    //                 $this->TransaksiModel->protect(false)->where('unique_scanid', $existingTransaksi['unique_scanid'])
    //                     ->set(['pic' => $pic, 'status' => 'adjust_ci', 'tgl_adjust' => date('Y-m-d H:i:s')])
    //                     ->update();
    //             } else {
    //                 // Condition: unique_scanid not found in the database
    //                 // Insert new data
    //                 $dataInput = [
    //                     'idRak' => $rakRow['idRak'],
    //                     'idPartNo' => $partNumberRow['idPartNo'],
    //                     'unique_scanid' => $uniqueScanId,
    //                     'lot' => $lot,
    //                     'quantity' => $quantity,
    //                     'status' => 'adjust_ci',
    //                     'pic' => $pic,
    //                     'tgl_ci' => null,
    //                     'tgl_adjust' => date('Y-m-d H:i:s'),
    //                 ];
    //                 // Push each new row into the $dataInputs array
    //                 $dataInputs[] = $dataInput;
    //             }
    //             $historyDataRow = [
    //                 'idTransaksi' => ($existingTransaksi !== null) ? $existingTransaksi['idTransaksi'] : null,
    //                 'unique_scanid' => $uniqueScanId,
    //                 'part_number' => $partNumber,
    //                 'kode_rak' => $rak,
    //                 'lot' => $lot,
    //                 'quantity' => $quantity,
    //                 'status' => ($existingTransaksi !== null) ? $existingTransaksi['status'] : 'adjust_ci',
    //                 'pic' => ($existingTransaksi !== null) ? $existingTransaksi['pic'] : null,
    //                 'tgl_adjust' => date('Y-m-d H:i:s'),
    //             ];

    //             // Push the historical data row into the array
    //             $historyDataArray[] = $historyDataRow;
    //         }
    //         // Encode the array as a JSON string
    //         $historyData = [
    //             'trans_metadata' => json_encode($historyDataArray),
    //         ];

    //         // Insert historical data into HistoryModel
    //         $this->HistoryModel->insert($historyData);
    //         // Insert new data if there are any
    //         if (!empty($dataInputs)) {
    //             $this->TransaksiModel->protect(false)->insertBatch($dataInputs);
    //         }
    //         // Calculate the count of 'adjust_ci' status
    //         $countStatus = $this->TransaksiModel->where('idRak', $rakRow['idRak'])
    //             ->where('status', 'adjust_ci')->countAllResults();

    //         // Get max_capacity from PnModel
    //         $maxCapacity = $this->PnModel->where('idPartNo', $partNumberRow['idPartNo'])->first()['max_kapasitas'];

    //         // Update 'total_packing' and 'status_rak' in RakModel
    //         $this->rModel->update($rakRow['idRak'], [
    //             'total_packing' => $countStatus,
    //             'status_rak' => ($countStatus === 0) ? 'kosong' : (($countStatus >= $maxCapacity && $rakRow['tipe_rak'] !== 'Over Area') ? 'penuh' : 'terisi'),
    //         ]);
    //         // Check if $countStatus is greater than $maxCapacity
    //         if ($countStatus > $maxCapacity) {
    //             return $this->response->setStatusCode(400)->setJSON(['success' => false, 'message' => "Rak ini melebihi batas maksimal yaitu $maxCapacity"]);
    //         }
    //         // $this->HistoryModel->insert($historyData);

    //         return $this->response->setJSON(['success' => true, 'message' => 'Data adjusted successfully']);
    //     } else {
    //         // Return an error for requests that are not relevant
    //         return $this->response->setStatusCode(400);
    //     }
    // }
}
