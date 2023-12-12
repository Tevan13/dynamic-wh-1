<?php

namespace App\Controllers;

use App\Models\PartnumberModel;
use App\Controllers\BaseController;
use \PhpOffice\PhpSpreadsheet\Reader\Xls;
use \PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx as WriterXlsx;
use \PhpOffice\PhpSpreadsheet\Spreadsheet;

class Partnumber extends BaseController
{
    public function __construct()
    {
        $this->PartnumberModel = new PartnumberModel();
    }

    public function index()
    {
        if (session()->get('tb_user') == null) {
            return redirect()->to('/login');
        }
        $data = [
            'parts' => $this->PartnumberModel->findAll(),
            'tittle' => 'Master Part',
        ];
        return view('master/masterPart', $data);
    }

    public function store()
    {
        $data = $this->request->getPost();
        $store = $this->PartnumberModel->protect(false)->insert($data, false);
        if ($store) {
            session()->setFlashdata("success", "Part Number berhasil ditambahkan!");
        } else {
            session()->setFlashdata("fail", "Part Number gagal ditambahkan!");
        }
        return redirect()->route('master-part');
    }

    public function update($id)
    {
        $data = $this->request->getPost();
        unset($data['_method']);
        $update = $this->PartnumberModel->protect(false)->update($id, $data);
        if ($update) {
            session()->setFlashdata("success", "Part Number berhasil diedit!");
        } else {
            session()->setFlashdata("fail", "Part Number gagal diedit!");
        }
        return redirect()->route('master-part');
    }

    public function delete($id)
    {
        $delete = $this->PartnumberModel->where('idPartNo', $id)->delete();
        if ($delete) {
            session()->setFlashdata("success", "Part Number berhasil dihapus!");
        } else {
            session()->setFlashdata("fail", "Part Number gagal dihapus!");
        }
        return redirect()->route('master-part');
    }

    public function import()
    {
        $file = $this->request->getFile('fileexcel');
        $ext = $file->getClientExtension();
        if ($ext === 'xls') {
            $render = new Xls();
        } else {
            $render = new Xlsx();
        }

        $spreadsheet = $render->load($file);
        $data = $spreadsheet->getActiveSheet()->toArray();
        // Define a mapping array for 'Tipe Rak'
        $tipeRakMapping = [
            'SLOT BESAR' => 'Besar',
            'SLOT KECIL' => 'Kecil',
            // Add more mappings as needed
        ];
        foreach (array_slice($data, 1) as $d) {
            // Map 'Tipe Rak' value using the mapping array
            $tipeRak = isset($tipeRakMapping[$d[2]]) ? $tipeRakMapping[$d[2]] : $d[2];
            $insert = [
                'part_number' => $d[0],
                'tipe_rak' => $tipeRak,
                'max_kapasitas' => $d[3],
            ];
            $store = $this->PartnumberModel->protect(false)->insert($insert, false);
            if (!$store) {
                session()->setFlashdata("fail", "Part Number gagal ditambahkan!");
                return redirect()->route('master-part');
            }
        }
        session()->setFlashdata("success", "Part Number berhasil ditambahkan!");
        return redirect()->route('master-part');
    }
    public function export()
    {
        $data = $this->PartnumberModel->findAll();
        $fileName = 'master_part_number.xlsx';
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'Part Number');
        $sheet->setCellValue('B1', 'Jenis Rak');
        $sheet->setCellValue('C1', 'Maximum Kapasitas');

        $count = 2;
        foreach ($data as $row) {
            $sheet->setCellValue('A' . $count, $row['part_number']);
            $sheet->setCellValue('B' . $count, $row['tipe_rak']);
            $sheet->setCellValue('C' . $count, $row['max_kapasitas']);
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
