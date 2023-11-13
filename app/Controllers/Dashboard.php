<?php

namespace App\Controllers;

use App\Models\DashboardModel;
use CodeIgniter\Controller;

class Dashboard extends Controller
{
    public function index()
    {
        if (session()->get('tb_user') == null) {
            return redirect()->to('/login');
        }

        $model = new DashboardModel;
        $data['title'] = 'Dashboard';
        $data['getTransaksi'] = $model->getTransaksi();
        echo view('DashboardView', $data);
    }
}
