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
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'kode_rak' => 'A330',
                'tipe_rak' => 'Kecil',
                'status_rak' => 'Kosong',
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'kode_rak' => 'A331',
                'tipe_rak' => 'Kecil',
                'status_rak' => 'Penuh',
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'kode_rak' => 'A221',
                'tipe_rak' => 'Kecil',
                'status_rak' => 'Terisi',
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'kode_rak' => 'A332',
                'tipe_rak' => 'Kecil',
                'status_rak' => 'Kosong',
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'kode_rak' => 'A333',
                'tipe_rak' => 'Kecil',
                'status_rak' => 'Penuh',
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'kode_rak' => 'B112',
                'tipe_rak' => 'Besar',
                'status_rak' => 'Penuh',
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'kode_rak' => 'B113',
                'tipe_rak' => 'Besar',
                'status_rak' => 'Kosong',
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'kode_rak' => 'B114',
                'tipe_rak' => 'Besar',
                'status_rak' => 'Kosong',
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'kode_rak' => 'B115',
                'tipe_rak' => 'Besar',
                'status_rak' => 'Kosong',
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'kode_rak' => 'B116',
                'tipe_rak' => 'Besar',
                'status_rak' => 'Terisi',
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'kode_rak' => 'C001',
                'tipe_rak' => 'Over Area',
                'status_rak' => 'Terisi',
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'kode_rak' => 'C002',
                'tipe_rak' => 'Over Area',
                'status_rak' => 'Kosong',
                'created_at' => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('tb_rak')->insertBatch($data);
    }
}
