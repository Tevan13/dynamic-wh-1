<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TbPartno extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'idPartNo' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true
            ],
            'part_number' => [
                'type' => 'VARCHAR',
                'constraint' => 255
            ],
            'max_kapasitas' => [
                'type' => 'INT',
                'constraint' => 10,
                'null' => true,
            ],
            'tipe_rak' => [
                'type' => 'ENUM',
                'constraint' => ['Besar', 'Kecil'],
                'null' => true,
            ],
            'created_at' => [
                'type' => 'datetime',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('idPartNo', true);
        $this->forge->createTable('tb_partno');
    }

    public function down()
    {
        $this->forge->dropTable('tb_partno');
    }
}
