<?php

namespace App\Controllers;

use App\Models\rakModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

class rakController extends BaseController
{
    public function __construct()
    {
        $this->rModel = new rakModel();
    }

    public function index()
    {
        if (session()->get('tb_user') == null) {
            return redirect()->to('/login');
        }
        $data = [
            'tittle' => 'Master Rak',
            'masterRak' => $this->rModel->getMasterRAk()
        ];
        return view('master/masterRak', $data);
    }

    public function create()
    {
        $data = [
            'kode_rak' => $this->request->getPost('kode_rak'),
            'tipe_rak' => $this->request->getPost('tipe_rak'),
            'status_rak' => 'Kosong',
            'total_packing' => 0,
            'created_at' => date('Y-m-d H:i:s'),
        ];
        $this->rModel->addMasterRak($data);

        $response = [
            "success" => true,
            "message" => "Rak berhasil dibuat!"
        ];
        return $this->response->setJSON($response);
    }

    public function updateRak($id)
    {
        $rak = $this->rModel->getRakBy($id);
        $data = [
            'kode_rak' => $this->request->getPost('kode_rak'),
            'tipe_rak' => $this->request->getPost('tipe_rak'),
            'status_rak' => $this->request->getPost('status_rak'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];
        $this->rModel->updateMasterRak($id, $data);

        $response = [
            "success" => true,
            "message" => "Rak berhasil terupdate!"
        ];

        return $this->response->setJSON($response);
    }
    public function delete($id)
    {
        $this->rModel->deleteMasterRak($id);
        $response = [
            "success" => true,
            "message" => "Rak berhasil terupdate!"
        ];

        return $this->response->setJSON($response);
    }
    public function export()
    {
        $borderstyle = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],

        ];
        $data = $this->rModel->getMasterRAk();
        if (!empty($data)) {
            $spreadsheet = new Spreadsheet();
            $spreadsheet->setActiveSheetIndex(0)->getColumnDimension('A')->setAutoSize(true);
            $spreadsheet->setActiveSheetIndex(0)->getColumnDimension('B')->setAutoSize(true);
            $spreadsheet->setActiveSheetIndex(0)->getColumnDimension('C')->setAutoSize(true);
            $spreadsheet->setActiveSheetIndex(0)->getColumnDimension('D')->setAutoSize(true);

            $sheet = $spreadsheet->getActiveSheet()->setTitle('Master Data Rak');
            $sheet->setCellValue('A1', 'NO');
            $sheet->setCellValue('B1', 'Kode Rak');
            $sheet->setCellValue('C1', 'Tipe Rak');
            $sheet->setCellValue('D1', 'Status Rak');
            $sheet->getStyle('A1:D1')->getFont()->setBold(true);
            $sheet->getStyle('A1:D1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setRGB('FFFF00');

            $column = 2;
            $i = 1;
            foreach ($data as $row) {

                $sheet->setCellValue('A' . $column, $i);
                $sheet->setCellValue('B' . $column, $row['kode_rak']);
                $sheet->setCellValue('C' . $column, $row['tipe_rak']);
                $sheet->setCellValue('D' . $column, $row['status_rak']);
                $sheet->getStyle('A1:D' . $column)->applyFromArray($borderstyle);
                $column++;
                $i++;
            }
        } else {
            $spreadsheet = new Spreadsheet();
            $spreadsheet->getActiveSheet()->setTitle('Master Data Rak');
        }
        $writer = new Xlsx($spreadsheet);
        $fileName = 'Master Data Rak';
        $writer->save($fileName);

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename=' . $fileName . '.xlsx');
        header('Cache-Control: max-age=0');
        flush();
        readfile($fileName);
        exit;
    }
    public function upload()
    {
        $file_excel = $this->request->getFile('fileexcel');
        $ext = $file_excel->getClientExtension();

        if ($ext == 'xls') {
            $render = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
        } else {
            $render = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        }

        try {
            $spreadsheet = $render->load($file_excel->getTempName());
            $data = $spreadsheet->getActiveSheet()->toArray();
        } catch (\PhpOffice\PhpSpreadsheet\Reader\Exception $e) {
            // Handle Excel format mismatch error
            return $this->response->setStatusCode(400)->setJSON(['success' => false, 'message' => 'Error reading Excel file. Please ensure it is in the correct format.']);
        }

        $tipeRakMapping = [
            'SLOT BESAR' => 'Besar',
            'SLOT KECIL' => 'Kecil',
            // Add more mappings as needed
        ];

        $db = \Config\Database::connect();
        foreach ($data as $x => $row) {
            if ($x == 0) {
                continue; // Skip header row
            }

            $kode_rak = $row[2];
            $tipe_rak = $row[3];

            // Check if the rak exists by kode rak in the table
            $existingRak = $db->table('tb_rak')->getWhere(['kode_rak' => $kode_rak])->getRow();

            // Start a database transaction
            $db->transBegin();
            try {
                if ($existingRak) {
                    // Existing rack found, skip
                    session()->setFlashdata('message', '<div class="alert alert-warning" style="font-color:white"><b>Data dengan Kode Rak ' . $kode_rak . ' sudah ada. Data dilewati.</b></div>');
                } else {
                    // Rack not found, insert new data
                    $simpandata = [
                        'kode_rak' => $kode_rak,
                        'tipe_rak' => isset($tipeRakMapping[$tipe_rak]) ? $tipeRakMapping[$tipe_rak] : $tipe_rak, // Map tipe_rak if needed
                        'status_rak' => 'Kosong',
                        'created_at' => date('Y-m-d H:i:s'),
                        'total_packing' => 0,
                    ];
                    $db->table('tb_rak')->insert($simpandata);
                    session()->setFlashdata('message', '<div class="alert alert-success" style="font-color:white"><b>Data Berhasil Ditambahkan</b></div>');
                }

                // Commit the transaction for this row
                $db->transCommit();
            } catch (\Exception $e) {
                // Something went wrong, roll back the transaction for this row
                $db->transRollback();
            }
        }
        return redirect()->to('/master_rak');
    }
}
