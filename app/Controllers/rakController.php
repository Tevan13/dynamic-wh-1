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
        $data = [
            'tittle' => 'Master Rak',
            'masterRak' => $this->rModel->getMasterRAk()
        ];
        return view('/cs/masterRak', $data);
    }

    public function create()
    {
        $data = [
            'kode_rak' => $this->request->getPost('kode_rak'),
            'tipe_rak' => $this->request->getPost('tipe_rak'),
            'keterangan' => $this->request->getPost('keterangan'),
            'status_rak' => 'Kosong',
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
            'keterangan' => $this->request->getPost('keterangan'),
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
            $sheet->setCellValue('D1', 'Keterangan');
            $sheet->setCellValue('E1', 'Status Rak');
            $sheet->getStyle('A1:E1')->getFont()->setBold(true);
            $sheet->getStyle('A1:E1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setRGB('FFFF00');

            $column = 2;
            $i = 1;
            foreach ($data as $row) {

                $sheet->setCellValue('A' . $column, $i);
                $sheet->setCellValue('B' . $column, $row['kode_rak']);
                $sheet->setCellValue('C' . $column, $row['tipe_rak']);
                $sheet->setCellValue('D' . $column, $row['keterangan']);
                $sheet->setCellValue('E' . $column, $row['status_rak']);
                $sheet->getStyle('A1:E' . $column)->applyFromArray($borderstyle);
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
}
