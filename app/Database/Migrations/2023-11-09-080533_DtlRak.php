<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class DtlRak extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'idDtl' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true
            ],
            'idTransaksi' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'kapasitas' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
        ]);
        $this->forge->addKey('idDtl', true);
        $this->forge->createTable('dtl_transaksi');
    }

    public function down()
    {
        $this->forge->dropTable('dtl_transaksi');
    }
}
