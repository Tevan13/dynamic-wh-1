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
        $level = strtolower(session()->get('tb_user')["level"]);
        // var_dump($level);
        $data['title'] = 'Dashboard';
        $data['level'] = $level;
        echo view('DashboardView', $data);
    }
}
