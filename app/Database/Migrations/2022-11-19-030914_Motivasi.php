<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Motivasi extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'auto_increment' => true,
            ],
            'isi_motivasi' => [
                'type' => 'TEXT',
            ],
            'iduser' => [
                'type' => 'INT',
            ],
            'tanggal_input' => [
                'type' => 'DATE',
            ],
            'tanggal_update' => [
                'type' => 'DATE',
            ],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('tb_motivasi');
    }

    public function down()
    {
        $this->forge->dropTable('tb_motivasi');
    }
}
