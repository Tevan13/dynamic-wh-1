<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TbTransaksi extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'idTransaksi' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true
            ],
            'idPartNo' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'idRak' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'status_delivery' => [
                'type' => 'ENUM',
                'constraint' => ['true', 'false'],
            ],
            'tgl_ci' => [
                'type' => 'datetime',
            ],
            'tgl_co' => [
                'type' => 'datetime',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('idTransaksi', true);
        $this->forge->addForeignKey('idPartNo', 'tb_partno', 'idPartNo', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('idRak', 'tb_rak', 'idRak', 'CASCADE', 'CASCADE');
        $this->forge->createTable('tb_transaksi');
    }

    public function down()
    {
        $this->forge->dropTable('tb_transaksi');
    }
}
