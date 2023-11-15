<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class RakSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'kode_rak' => 'A220',
                'tipe_rak' => 'Kecil',
                'status_rak' => 'Terisi',
                'total_packing' => 0,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'kode_rak' => 'A330',
                'tipe_rak' => 'Kecil',
                'status_rak' => 'Kosong',
                'total_packing' => 0,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'kode_rak' => 'B112',
                'tipe_rak' => 'Besar',
                'status_rak' => 'Penuh',
                'total_packing' => 0,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'kode_rak' => 'B113',
                'tipe_rak' => 'Besar',
                'status_rak' => 'Kosong',
                'total_packing' => 0,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'kode_rak' => 'B114',
                'tipe_rak' => 'Besar',
                'status_rak' => 'Kosong',
                'total_packing' => 0,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'kode_rak' => 'B115',
                'tipe_rak' => 'Besar',
                'status_rak' => 'Kosong',
                'total_packing' => 0,
                'created_at' => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('tb_rak')->insertBatch($data);
    }
}
