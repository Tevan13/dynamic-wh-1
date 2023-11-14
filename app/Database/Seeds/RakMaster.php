<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class RakMaster extends Seeder
{
    public function run()
    {
        $data = [
            [
                'kode_rak' => 'A220',
                'tipe_rak' => 'Kecil',
                'status_rak' => 'Terisi',
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'kode_rak' => 'A330',
                'tipe_rak' => 'Kecil',
                'status_rak' => 'Kosong',
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'kode_rak' => 'B112',
                'tipe_rak' => 'Besar',
                'status_rak' => 'Penuh',
                'created_at' => date('Y-m-d H:i:s'),
            ],
        ];
        // masukkan data ke dalam tabel users
        $this->db->table('tb_rak')->insertBatch($data);
    }
}
