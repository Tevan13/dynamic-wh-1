<?php

namespace App\Controllers;

use App\Models\userModel;
use App\Controllers\BaseController;
use App\Models\picModel;

class User extends BaseController
{
    public function __construct()
    {
        $this->UserModel = new userModel();
        $this->picModel = new picModel();
    }

    public function index()
    {
        if (session()->get('tb_user') == null) {
            return redirect()->to('/login');
        }
        $data = [
            'users' => $this->UserModel->findAll(),
            'pics' => $this->picModel->getPicList(),
            'tittle' => 'Master User',
            'tittles' => 'Master PIC',
        ];
        return view('master/masterUser', $data);
    }

    public function store()
    {
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

    public function update($id)
    {
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

    public function delete($id)
    {
        $delete = $this->UserModel->where('idUser', $id)->delete();
        if ($delete) {
            session()->setFlashdata("success", "User berhasil dihapus!");
        } else {
            session()->setFlashdata("fail", "User Number gagal dihapus!");
        }
        return redirect()->route('master-user');
    }
    public function createPic()
    {
        $pic = $this->request->getPost("pic");
        $departemen = $this->request->getPost("departemen");
        $data = [
            "pic" => $pic,
            "departemen" => $departemen,
        ];
        $this->picModel->addPic($data);
        $response = [
            "success" => true,
            "message" => "Akun User Berhasil Dibuat"
        ];
        return $this->response->setJSON($response);
    }
    public function editPic($id)
    {
        $pic = $this->request->getPost("pic");
        $departemen = $this->request->getPost("departemen");
        $data = [
            "pic" => $pic,
            "departemen" => $departemen,
        ];
        $this->picModel->updatePic($id, $data);
        session()->setFlashdata('message', '<div class="alert alert-success" style="font-color:white"><b>PIC Berhasil Diupdate</b></div>');
        return redirect()->to('/master-user');
    }
    public function deletePic($id)
    {
        $this->picModel->hapusPic($id);
        $response = [
            "success" => true,
            "message" => "PIC Berhasil Dihapus!"
        ];

        return $this->response->setJSON($response);
    }
}
