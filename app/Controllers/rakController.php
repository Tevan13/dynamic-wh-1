<?php

namespace App\Controllers;

use App\Models\rakModel;

class rakController extends BaseController
{
    public function __construct()
    {
        $this->rModel = new rakModel();
    }
    public function index()
    {
        $data = [
            'tittle' => 'Master Rak',
            'masterRak' => $this->rModel->getMasterRAk()
        ];
        return view('/cs/masterRak', $data);
    }
    public function create()
    {
        $data = [
            'kode_rak' => $this->request->getPost('kode_rak'),
            'jenis_rak' => $this->request->getPost('jenis_rak'),
            'keterangan' => $this->request->getPost('keterangan'),
            'created_at' => date('Y-m-d H:i:s'),
        ];
        $this->rModel->addMasterRak($data);

        $response = [
            "success" => true,
            "message" => "Rak berhasil dibuat!"
        ];
        return $this->response->setJSON($response);
    }
    public function updateRak($id)
    {
        $rak = $this->rModel->getRakBy($id);
        $data = [
            'kode_rak' => $this->request->getPost('kode_rak'),
            'jenis_rak' => $this->request->getPost('jenis_rak'),
            'keterangan' => $this->request->getPost('keterangan'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];
        $this->rModel->updateMasterRak($id, $data);

        $response = [
            "success" => true,
            "message" => "Rak berhasil terupdate!"
        ];

        return $this->response->setJSON($response);
    }
    public function delete($id)
    {
        $this->rModel->deleteMasterRak($id);
        $response = [
            "success" => true,
            "message" => "Rak berhasil terupdate!"
        ];

        return $this->response->setJSON($response);
    }
}
