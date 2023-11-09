<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'email' => 'admin@admin.com',
                'password' => password_hash('123', PASSWORD_DEFAULT),
                'hak_akses' => 'Admin'
            ]
        ];

        // masukkan data ke dalam tabel users
        $this->db->table('tb_user')->insertBatch($data);
    }
}
