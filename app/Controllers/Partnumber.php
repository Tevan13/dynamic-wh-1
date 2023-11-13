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
        $data['parts'] = $this->PartnumberModel->findAll();
        return view('master/partnumber', $data);
    }

    public function store()
    {
        $data = $this->request->getPost();
        $store = $this->PartnumberModel->protect(false)->insert($data, false);

        if ($store) {
            return redirect()->route('master-part');
        }
        return redirect()->route('master-part');
    }

    public function update($id)
    {
        $data = $this->request->getPost();
        unset($data['_method']);
        $this->PartnumberModel->protect(false)->update($id, $data);
        return redirect()->route('master-part');
    }

    public function delete($id)
    {
        $this->PartnumberModel->where('idPartNo', $id)->delete();
        return redirect()->route('master-part');
    }
}
