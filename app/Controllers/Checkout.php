<?php

namespace App\Controllers;

use App\Models\picModel;
use App\Models\rakModel;
use CodeIgniter\Controller;

class Checkout extends Controller
{
    public function __construct()
    {
        $this->picModel = new picModel();
        $this->RakModel = new rakModel();
    }
    public function index()
    {
        if (session()->get('tb_user') == null) {
            return redirect()->to('/login');
        }

        $data = [
            'pic' => $this->picModel->getPicList(),
            'title' => 'SCAN CHECKOUT'
        ];
        return view('scan-co', $data);
    }
}
