<?php

namespace App\Controllers;

use App\Models\PartnumberModel;
use App\Controllers\BaseController;

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
        return view('cs/masterPart', $data);
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

    public function delete($id) {
        $delete = $this->PartnumberModel->where('idPartNo', $id)->delete();
        if ($delete) {
            session()->setFlashdata("success", "Part Number berhasil dihapus!");
        } else {
            session()->setFlashdata("fail", "Part Number gagal dihapus!");
        }
        return redirect()->route('master-part');
    }
}
