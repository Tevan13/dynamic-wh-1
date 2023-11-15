<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TbPic extends Migration
{
    public function up()
    {
        $this->forge->addField([
            "id" => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            "pic" => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            "departemen" => [
                'type' => 'ENUM',
                'constraint' => ['CS', 'QC', 'Delivery'],
            ]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('tb_pic');
    }

    public function down()
    {
        $this->forge->dropTable('tb_pic');
    }
}
