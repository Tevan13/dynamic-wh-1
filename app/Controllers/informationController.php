<?php

namespace App\Controllers;

class informationController extends BaseController
{
    public function index()
    {
        if (session()->get('tb_user') == null) {
            return redirect()->to('/login');
        }
        return view('informationRak');
    }
}
