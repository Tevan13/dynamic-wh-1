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
    }
    public function index()
    {
        if (session()->get('tb_user') == null) {
            return redirect()->to('/login');
        }

        $infoRak = $this->infoModel->getInfoRak();

        $data = [
            'dataRak' => $infoRak
        ];

        // echo '<pre>';
        // var_dump($infoRak);
        // echo '</pre>';
        return view('informationRak', $data);
    }

    public function export()
    {
        $allData = $this->infoModel->getInfoRak();
        foreach ($allData as $item) {
            if ($item['part_number'] !== null && $item['tipe_rak'] !== 'Over Area') {
                $data[] = $item;
            }
            if ($item['tipe_rak'] === 'Over Area') {
                if (!empty($item['transaksi'])) {
                    $dataOver = $item;
                }
            }
        }
        foreach ($dataOver['transaksi'] as $item) {
            $parts[] = $item['part_number'];
        }
        $parts = array_unique($parts);
        unset($dataOver['transaksi']);
        $dataOver['part_number'] = implode(';', $parts);
        $data[] = $dataOver;

        $fileName = 'informasi_rak.xlsx';
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'Kode Rak');
        $sheet->setCellValue('B1', 'Tipe Rak');
        $sheet->setCellValue('C1', 'Status Rak');
        $sheet->setCellValue('D1', 'Total Packing');
        $sheet->setCellValue('E1', 'Part Number');
        $sheet->setCellValue('F1', 'Tanggal Checkin Terakhir');
        $sheet->getStyle('A1:F1')->getFont()->setBold(true);

        // Adjust column widths
        foreach (range('A', 'F') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }
        $count = 2;
        foreach ($data as $row) {
            $sheet->setCellValue('A' . $count, $row['kode_rak']);
            $sheet->setCellValue('B' . $count, $row['tipe_rak']);
            $sheet->setCellValue('C' . $count, $row['status_rak']);
            $sheet->setCellValue('D' . $count, $row['total_packing']);
            $sheet->setCellValue('E' . $count, $row['part_number']);
            $sheet->setCellValue('F' . $count, $row['tgl_ci']);
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
