<?php

namespace App\Controllers;

use App\Models\overAreaModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;


class overAreaController extends BaseController
{
    public function __construct()
    {
        $this->overModel = new overAreaModel();
    }
    public function index()
    {
        if (session()->get('tb_user') == null) {
            return redirect()->to('/login');
        }
        $overArea = $this->getData();

        $data = [
            'overArea' => $overArea
        ];

        // echo '<pre>';
        // var_dump($overArea);
        // echo '</pre>';
        return view('overArea', $data);
    }
    public function getData()
    {
        $overArea = $this->overModel->getOverArea();
        $filtered_item_request = [];
        foreach ($overArea as $rak) {
            if (is_array($rak["transaksi"]) && !empty($rak["transaksi"])) {
                foreach ($rak["transaksi"] as $detail) {
                    if ($detail['status'] != 'checkout' && $detail['status'] != 'adjust_co') {
                        array_push($filtered_item_request, $detail);
                    }
                }
            }
        }
        // Count occurrences of each part_number
        $countPacking = array_count_values(array_column($filtered_item_request, 'part_number'));
        // Sum quantity for each part_number
        $quantity = array_reduce(
            $filtered_item_request,
            function ($carry, $item) {
                $partNumber = $item['part_number'];
                $quantity = $item['quantity'];
                $carry[$partNumber] = isset($carry[$partNumber]) ? $carry[$partNumber] + $quantity : $quantity;
                return $carry;
            },
            []
        );
        $latestTglCi = null;
        foreach ($filtered_item_request as $transaction) {
            if ($transaction['part_number']) {
                $latestTglCi = $transaction['tgl_ci'];
            }
        }
        $latestAdjustCi = null;
        foreach ($filtered_item_request as $transaction) {
            if ($transaction['part_number']) {
                $latestAdjustCi = $transaction['tgl_adjust'];
            }
        }
        // Create a new array with additional information
        $result = [];
        foreach ($countPacking as $partNumber => $count) {
            $result[] = [
                'part_number' => $partNumber,
                'total_packing' => $count,
                'quantity' => $quantity[$partNumber] ?? 0,
                'tgl_ci' => $latestTglCi,
                'tgl_adjust' => $latestAdjustCi,
            ];
        }
        return $result;
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
        $overArea = $this->overModel->getOverArea();
        foreach ($overArea as $dataOver) {
            if (!empty($dataOver)) {
                $spreadsheet = new Spreadsheet();
                $spreadsheet->setActiveSheetIndex(0)->getColumnDimension('A')->setAutoSize(true);
                $spreadsheet->setActiveSheetIndex(0)->getColumnDimension('B')->setAutoSize(true);
                $spreadsheet->setActiveSheetIndex(0)->getColumnDimension('C')->setAutoSize(true);
                $spreadsheet->setActiveSheetIndex(0)->getColumnDimension('D')->setAutoSize(true);
                $spreadsheet->setActiveSheetIndex(0)->getColumnDimension('E')->setAutoSize(true);
                $spreadsheet->setActiveSheetIndex(0)->getColumnDimension('F')->setAutoSize(true);
                $spreadsheet->setActiveSheetIndex(0)->getColumnDimension('G')->setAutoSize(true);

                $sheet = $spreadsheet->getActiveSheet()->setTitle('Data Over Area');
                $sheet->setCellValue('A1', 'Part Number');
                $sheet->setCellValue('B1', 'No Lot');
                $sheet->setCellValue('C1', 'UNIQUE SCAN ID');
                $sheet->setCellValue('D1', 'Quantity');
                $sheet->setCellValue('E1', 'PIC');
                $sheet->setCellValue('F1', 'Tanggal Checkin');
                $sheet->setCellValue('G1', 'Tanggal Adjust');
                $sheet->getStyle('A1:G1')->getFont()->setBold(true);
                $sheet->getStyle('A1:G1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()->setRGB('FFFF00');

                $column = 2;
                foreach ($dataOver['transaksi'] as $row) {
                    // return d($row);
                    $sheet->setCellValue('A' . $column, $row['part_number']);
                    $sheet->setCellValue('B' . $column, $row['lot']);
                    $sheet->setCellValue('C' . $column, $row['unique_scanid']);
                    $sheet->setCellValue('D' . $column, $row['quantity']);
                    $sheet->setCellValue('E' . $column, $row['pic']);
                    $sheet->setCellValue('F' . $column, $row['tgl_ci']);
                    $sheet->setCellValue('G' . $column, $row['tgl_adjust']);
                    $sheet->getStyle('A1:G' . $column)->applyFromArray($borderstyle);
                    $column++;
                }
            } else {
                $spreadsheet = new Spreadsheet();
                $spreadsheet->getActiveSheet()->setTitle('Data Over Area');
            }
            $writer = new Xlsx($spreadsheet);
            $fileName = 'Data Over Area';
            $writer->save($fileName);

            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename=' . $fileName . '.xlsx');
            header('Cache-Control: max-age=0');
            flush();
            readfile($fileName);
            exit;
        }
    }
}
