<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TbRak extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'idRak' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true
            ],
            'kode_rak' => [
                'type' => 'VARCHAR',
                'constraint' => 255
            ],
            'tipe_rak' => [
                'type' => 'ENUM',
                'constraint' => ['Besar', 'Kecil', 'Over Area'],
                'null' => true,
            ],
            'status_rak' => [
                'type' => 'ENUM',
                'constraint' => ['Kosong', 'Terisi', 'Penuh'],
                'null' => true,
            ],
            'total_packing' => [
                'type' => 'INT',
                'constraint' => 12,
                'default' => 0,
            ],
            'created_at' => [
                'type' => 'datetime',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'datetime',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('idRak', true);
        $this->forge->createTable('tb_rak');
    }

    public function down()
    {
        $this->forge->dropTable('tb_rak');
    }
}
