<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PartSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'part_number' => '4111-03550-C',
            'tipe_rak' => 'Besar',
            'max_kapasitas' => 14,
            'created_at' => date('Y-m-d H:i:s'),
        ];

        $this->db->table('tb_partno')->insert($data);
    }
}
