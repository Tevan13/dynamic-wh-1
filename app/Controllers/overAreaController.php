<?php

namespace App\Controllers;

use App\Models\overAreaModel;


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
}
