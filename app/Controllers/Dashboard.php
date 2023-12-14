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
        $data['title'] = 'Dashboard';
        echo view('DashboardView', $data);
    }
}
