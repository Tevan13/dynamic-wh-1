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
            'rakList' => $this->rModel->getMasterRAk(),
            'title' => 'SCAN ADJUSTMENT'
        ];
        return view('adjustment', $data);
    }
    public function add()
    {
        // Check if it's a POST request and get JSON data from the AJAX request
        if ($this->request->isAJAX()) {
            $json = $this->request->getJSON();
            $dataInputs = [];

            // Update all data in the same 'idRak' to 'adjust_co'
            foreach ($json as $data) {
                $rak = $data->rak;
                $pic = $data->pic;
                $partNumber = $data->part_number;

                $rakRow = $this->rModel->where('kode_rak', $rak)->first();
                if (!$rakRow) {
                    return $this->response->setStatusCode(400)->setJSON(['success' => false, 'message' => 'Rak tidak ditemukan!']);
                }

                $partNumberRow = $this->PnModel->where('part_number', $partNumber)->first();
                if (!$partNumberRow) {
                    return $this->response->setStatusCode(400)->setJSON(['success' => false, 'message' => 'Part number tidak ditemukan!']);
                }

                $this->TransaksiModel->protect(false)->where('idRak', $rakRow['idRak'])
                    ->set(['pic' => $pic, 'status' => 'adjust_co', 'tgl_adjust' => date('Y-m-d H:i:s')])
                    ->update();
            }

            // Check each 'unique_scanid' in the JSON
            foreach ($json as $data) {
                $rak = $data->rak;
                $uniqueScanId = $data->unique_scanid;
                $partNumber = $data->part_number;
                $pic = $data->pic;
                $lot = $data->lts;
                $quantity = $data->qty;

                $rakRow = $this->rModel->where('kode_rak', $rak)->first();

                if (!$rakRow) {
                    return $this->response->setStatusCode(400)->setJSON(['success' => false, 'message' => 'Rak tidak ditemukan!']);
                }
                $partNumberRow = $this->PnModel->where('part_number', $partNumber)->first();

                if (!$partNumberRow) {
                    return $this->response->setStatusCode(400)->setJSON(['success' => false, 'message' => 'Part number tidak ditemukan!']);
                }


                // Check if 'unique_scanid' exists in the database
                $existingTransaksi = $this->TransaksiModel
                    ->where('idRak', $rakRow['idRak'])
                    ->where('unique_scanid', $uniqueScanId)
                    ->first();

                if ($existingTransaksi !== null) {
                    // Condition: unique_scanid matched in json and database
                    // Update the existing data to 'adjust_ci'
                    $this->TransaksiModel->protect(false)->where('unique_scanid', $existingTransaksi['unique_scanid'])
                        ->set(['pic' => $pic, 'status' => 'adjust_ci', 'tgl_adjust' => date('Y-m-d H:i:s')])
                        ->update();
                } else {
                    // Condition: unique_scanid not found in the database
                    // Insert new data
                    $dataInput = [
                        'idRak' => $rakRow['idRak'],
                        'idPartNo' => $partNumberRow['idPartNo'],
                        'unique_scanid' => $uniqueScanId,
                        'lot' => $lot,
                        'quantity' => $quantity,
                        'status' => 'adjust_ci',
                        'pic' => $pic,
                        'tgl_adjust' => date('Y-m-d H:i:s'),
                    ];
                    // Push each new row into the $dataInputs array
                    $dataInputs[] = $dataInput;
                }
            }
            // Insert new data if there are any
            if (!empty($dataInputs)) {
                $this->TransaksiModel->protect(false)->insertBatch($dataInputs);
            }
            // Calculate the count of 'adjust_ci' status
            $countStatus = $this->TransaksiModel->where('idRak', $rakRow['idRak'])
                ->where('status', 'adjust_ci')->countAllResults();

            // Get max_capacity from PnModel
            $maxCapacity = $this->PnModel->where('idPartNo', $partNumberRow['idPartNo'])->first()['max_kapasitas'];

            // Update 'total_packing' and 'status_rak' in RakModel
            $this->rModel->update($rakRow['idRak'], [
                'total_packing' => $countStatus,
                'status_rak' => ($countStatus === 0) ? 'kosong' : (($countStatus >= $maxCapacity && $rakRow['tipe_rak'] !== 'Over Area') ? 'penuh' : 'terisi'),
            ]);
            // Check if $countStatus is greater than $maxCapacity
            if ($countStatus > $maxCapacity) {
                return $this->response->setStatusCode(400)->setJSON(['success' => false, 'message' => "Rak ini melebihi batas maksimal yaitu $maxCapacity"]);
            }

            $insertedID = $this->TransaksiModel->insertID();
            $historyData = [
                'trans_metadata' => json_encode([
                    'idTransaksi' => $existingTransaksi['idTransaksi'],
                    'unique_scanid' => $uniqueScanId,
                    'part_number' => $partNumber,
                    'kode_rak' => $rak,
                    'lot' => $lot,
                    'quantity' => $quantity,
                    'status' => 'checkout',
                    'pic' => $pic,
                    'tgl_adjust' => date('Y-m-d H:i:s'),
                ]),
            ];
            $this->HistoryModel->insert($historyData);

            return $this->response->setJSON(['success' => true, 'message' => 'Data adjusted successfully']);
        } else {
            // Return an error for requests that are not relevant
            return $this->response->setStatusCode(400);
        }
    }
}
