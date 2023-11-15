<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TransaksiMetadata extends Migration
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
            "checkin_metadata" => [
                'type' => 'JSON',
            ],
            "checkout_metadata" => [
                'type' => 'JSON',
            ]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('transaksi_history');
    }

    public function down()
    {
        $this->forge->dropTable('transaksi_history');
    }
}
