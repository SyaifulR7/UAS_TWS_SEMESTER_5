<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Role extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'auto_increment' => true,
            ],
            'nama' => [
                'type' => 'VARCHAR',
                'constraint' => '128',
            ],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('tb_role');
    }

    public function down()
    {
        $this->forge->dropTable('tb_role');
    }
}
