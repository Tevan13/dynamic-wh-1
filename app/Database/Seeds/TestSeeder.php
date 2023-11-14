<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TestSeeder extends Seeder
{
    public function run()
    {
        $this->call('RakSeeder');
        $this->call('UserSeeder');
        $this->call('PartSeeder');
    }
}
