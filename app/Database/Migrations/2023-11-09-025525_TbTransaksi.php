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
            'unique_scanid' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'lot' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'quantity' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['checkin', 'checkout', 'adjust_co', 'adjust_ci'],
            ],
            'pic' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'tgl_ci' => [
                'type' => 'datetime',
            ],
            'tgl_co' => [
                'type' => 'datetime',
                'null' => true,
            ],
            'tgl_adjust' => [
                'type' => 'datetime',
                'null' => true,
            ]
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
