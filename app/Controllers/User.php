<?php

namespace App\Controllers;

use App\Models\userModel;
use App\Controllers\BaseController;

class User extends BaseController
{
    public function __construct()
    {
        $this->UserModel = new userModel();
    }

    public function index()
    {
        $data = [
            'users' => $this->UserModel->findAll(),
            'tittle' => 'Master User',
        ];
        return view('master/masterUser', $data);
    }

    public function store() {
        $data = $this->request->getPost();
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        $store = $this->UserModel->protect(false)->insert($data);
        if ($store) {
            session()->setFlashdata("success", "User berhasil ditambahkan!");
        } else {
            session()->setFlashdata("fail", "User gagal ditambahkan!");
        }
        return redirect()->route('master-user');
    }

    public function update($id) {
        $data = $this->request->getPost();
        unset($data['_method']);
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        $update = $this->UserModel->protect(false)->update($id, $data);
        if ($update) {
            session()->setFlashdata("success", "User berhasil diedit!");
        } else {
            session()->setFlashdata("fail", "User gagal diedit!");
        }
        return redirect()->route('master-user');
    }

    public function delete($id) {
        $delete = $this->UserModel->where('idUser', $id)->delete();
        if ($delete) {
            session()->setFlashdata("success", "User berhasil dihapus!");
        } else {
            session()->setFlashdata("fail", "User Number gagal dihapus!");
        }
        return redirect()->route('master-user');
    }
}
