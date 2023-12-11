<?php

namespace App\Controllers;

use App\Models\HistoryTransaksiModel;
use App\Controllers\BaseController;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx as WriterXlsx;

class HistoryTransaksi extends BaseController
{
    public $historyModel;
    public function __construct()
    {
        $this->historyModel = new HistoryTransaksiModel();
    }
    public function index()
    {
        if (session()->get('tb_user') == null) {
            return redirect()->to('/login');
        }

        $status = ['checkin', 'checkout', 'adjustment'];
        $start = $this->request->getGet('min');
        $end = $this->request->getGet('max');
        // Validate the date format before using them
        $start = $this->isValidDate($start) ? $start : '2023-12-08';
        $end = $this->isValidDate($end) ? $end : '2023-12-08';
        // Use the updated date range in your existing logic
        $dateRange = ['min' => $start, 'max' => $end];
        // Call the model function to get filtered data
        $transaksiData = $this->historyModel->getCheckin($status[0], $dateRange);
        $transaksiData2 = $this->historyModel->getCheckout($status[1], $dateRange);
        // Decode the 'trans_metadata' in each row
        foreach ($transaksiData as &$transaksiRow) {
            $transaksi = json_decode($transaksiRow['trans_metadata'], true);

            // Check if $transaksi is an array before pushing it back
            if (is_array($transaksi)) {
                // Merge the decoded data with the original row data
                $transaksiRow = array_merge($transaksiRow, $transaksi);
                $transaksiRow = array_reverse($transaksiRow, true);
            }
        }
        foreach ($transaksiData2 as &$checkout) {
            $transaksi = json_decode($checkout['trans_metadata'], true);
            $checkout = array_reverse($transaksi, true);

            // Check if $transaksi is an array before pushing it back
            if (is_array($transaksi)) {
                // Merge the decoded data with the original row data
                $checkout = array_merge($checkout, $transaksi);
            }
        }
        $data = [
            'title' => 'History Transaksi',
            'historyCheckin' => $transaksiData,
            'historyCheckout' => $transaksiData2,
            'historyAdjustment'
        ];
        echo view('historyTransaksiView', $data);
    }

    private function isValidDate($date)
    {
        $d = \DateTime::createFromFormat('Y/m/d', $date);
        return $d && $d->format('Y/m/d') === $date;
    }

    public function update()
    {
        $data = $this->request->getPost();
        $post = $this->historyModel->protect(false)->insert($data, false);

        if ($post) {
            return redirect()->route('history');
        }
        return redirect()->route('history');
    }

    public function search()
    {
        if (isset($_GET['cari'])) {
            $cari = $_GET['cari'];
            echo "<b>Hasil pencarian : " . $cari . "</b>";
        }
    }

    public function export()
    {
        $export = $this->historyModel->select('*')->findAll();
        $filename = 'History Transaksi.xlsx';
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'idTransaksi');
        $sheet->setCellValue('B1', 'idPartNo');
        $sheet->setCellValue('C1', 'idRak');
        $sheet->setCellValue('D1', 'status_delivery');
        $sheet->setCellValue('E1', 'tgl_ci');
        $sheet->setCellValue('F1', 'tgl_co');

        $count = 2;
        foreach ($export as $exp) {
            $sheet->setCellValue('A' . $count, $exp['idTransaksi']);
            $sheet->setCellValue('B' . $count, $exp['idPartNo']);
            $sheet->setCellValue('C' . $count, $exp['idRak']);
            $sheet->setCellValue('D' . $count, $exp['status_delivery']);
            $sheet->setCellValue('E' . $count, $exp['tgl_ci']);
            $sheet->setCellValue('F' . $count, $exp['tgl_co']);
        }

        $writer = new WriterXlsx($spreadsheet);
        $writer->save($filename);
        header("Content-Type: application/vnd.ms-excel");
        header('Content-Disposition: attachment; filename="' . basename($filename) . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length:' . filesize($filename));
        flush();
        readfile($filename);
        exit;
    }
}
