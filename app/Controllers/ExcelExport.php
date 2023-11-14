<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\HistoryTransaksiModel;

class ExcelExport extends BaseController
{
    function index()
    {
        $model = new HistoryTransaksiModel;
        $this->load->model("HistoryTransaksiModel");
        $data["historyData"] = $this->$model->fetch_data();
        $this->load->view("excelExportView");
    }

    function action()
    {
        $model = new HistoryTransaksiModel;
        $this->load->model($model);
        $this->load->library("Excel");
        $this->load->library("IOFactory");

        $object = new PHPExcel();
        $object->setActiveSheetIndex(0);

        $table_columns = array("No", "No_Transaksi", "Part_No", "Rak", "Status_Delivery", "Tanggal_CI", "Tanggal_CO");

        $column = 0;

        foreach ($table_columns as $field) {
            $object->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
            $column++;
        }

        $historyData = $this->$model->fetch_data();

        $excel_row = 2;

        foreach ($historyData as $row) {
            $object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $row->No);
            $object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $row->No_Transaksi);
            $object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, $row->Part_No);
            $object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, $row->Rak);
            $object->getActiveSheet()->setCellValueByColumnAndRow(4, $excel_row, $row->Status_Delivery);
            $object->getActiveSheet()->setCellValueByColumnAndRow(4, $excel_row, $row->Tangal_CI);
            $object->getActiveSheet()->setCellValueByColumnAndRow(4, $excel_row, $row->Tangal_CO);
            $excel_row++;
        }

        $object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel5');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="file.xls"');
        $object_writer->save('php://output');
    }
}
