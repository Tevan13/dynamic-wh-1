<?php

namespace App\Controllers;

use App\Models\informationModel;
use App\Models\rakModel;
use App\Models\TransaksiModel;
use \PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx as WriterXlsx;

class informationController extends BaseController
{
    public function __construct()
    {
        $this->infoModel = new informationModel();
        $this->rakModel = new rakModel();
    }

    public function index()
    {
        if (session()->get('tb_user') == null) {
            return redirect()->to('/login');
        }

        $infoRak = $this->infoModel->getInfoRak();

        $data = [
            'dataRak' => $infoRak,
            'title' => 'Informasi Rak'
        ];
        return view('informationRak', $data);
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
        $data = $this->infoModel->getTransactionCheckin();
        $newData = [];
        foreach ($data as $d) {
            $d['rak'] = $this->rakModel->find($d['idRak'])['kode_rak'];
            $d['tipe_rak'] = $this->rakModel->find($d['idRak'])['tipe_rak'];
            $d['status_rak'] = $this->rakModel->find($d['idRak'])['status_rak'];
            $newData[] = $d;
        }

        $fileName = 'informasi_rak.xlsx';
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'Kode Rak');
        $sheet->setCellValue('B1', 'Tipe Rak');
        $sheet->setCellValue('C1', 'Status Rak');
        $sheet->setCellValue('D1', 'Quantity');
        $sheet->setCellValue('E1', 'Part Number');
        $sheet->setCellValue('F1', 'No Scan');
        $sheet->setCellValue('G1', 'Tgl Checkin');
        $sheet->setCellValue('H1', 'Tgl Adjust');
        $sheet->getStyle('A1:H1')->getFont()->setBold(true);
        $sheet->getStyle('A1:H1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setRGB('FFFF00');

        // Adjust column widths
        foreach (range('A', 'H') as $count) {
            $sheet->getColumnDimension($count)->setAutoSize(true);
        }
        $count = 2;
        foreach ($newData as $row) {
            $sheet->setCellValue('A' . $count, $row['rak']);
            $sheet->setCellValue('B' . $count, $row['tipe_rak']);
            $sheet->setCellValue('C' . $count, $row['status_rak']);
            $sheet->setCellValue('D' . $count, $row['quantity']);
            $sheet->setCellValue('E' . $count, $row['part_number']);
            $sheet->setCellValue('F' . $count, $row['unique_scanid']);
            $sheet->setCellValue('G' . $count, date('d-M-Y', strtotime($row['tgl_ci'])));
            if (!empty($row['tgl_adjust'])) {
                $sheet->setCellValue('H' . $count, date('d-M-Y', strtotime($row['tgl_adjust'])));
            } else {
                $sheet->setCellValue('H' . $count, '-');
            }
            $sheet->getStyle('A1:H' . $count)->applyFromArray($borderstyle);
            $count++;
        }

        $writer = new WriterXlsx($spreadsheet);
        $writer->save($fileName);
        header("Content-Type: application/vnd.ms-excel");
        header('Content-Disposition: attachment; filename="' . basename($fileName) . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length:' . filesize($fileName));
        flush();
        readfile($fileName);
        exit;
    }
}
