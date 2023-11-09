<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TbUser extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'idUser' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'username' => [
                'type' => 'VARCHAR',
                'constraint' => 25,
            ],
            'password' => [
                'type' => 'VARCHAR',
                'constraint' => '25',
            ],
            'hak_akses' => [
                'type' => 'ENUM',
                'constraint' => ['QC', 'Delivery', 'CS'],
                'default' => 'User',
            ],
        ]);
        $this->forge->addKey('idUser', true);
        $this->forge->createTable('tb_user');
    }

    public function down()
    {
        $this->forge->dropTable('tb_user');
    }
}
