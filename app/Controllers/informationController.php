<?php

namespace App\Controllers;

use App\Models\informationModel;
use App\Models\rakModel;
use App\Models\TransaksiModel;

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
}
