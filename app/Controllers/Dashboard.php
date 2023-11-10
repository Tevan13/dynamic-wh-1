<?php

namespace App\Controllers;

use App\Models\DashboardModel;
use CodeIgniter\Controller;

class Dashboard extends Controller
{
    public function index()
    {
        $model = new DashboardModel;
        $data['title'] = 'Dashboard';
        $data['getTransaksi'] = $model->getTransaksi();
        echo view('DashboardView', $data);
    }
}
