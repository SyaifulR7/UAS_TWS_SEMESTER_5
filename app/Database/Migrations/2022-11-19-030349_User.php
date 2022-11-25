<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class User extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'iduser' => [
                'type' => 'INT',
                'auto_increment' => true,
            ],
            'nama' => [
                'type' => 'VARCHAR',
                'constraint' => '128',
            ],
            'profesi' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => '128',
            ],
            'password' => [
                'type' => 'VARCHAR',
                'constraint' => '256',
            ],
            'role_id' => [
                'type' => 'INT',
                'constraint' => '11',
            ],
            'is_active' => [
                'type' => 'INT',
                'constraint' => '1',
            ],
            'tanggal_input' => [
                'type' => 'DATE',
            ],
            'tanggal_update' => [
                'type' => 'DATE',
            ],
        ]);
        $this->forge->addPrimaryKey('iduser');
        $this->forge->createTable('tb_user');
    }

    public function down()
    {
        $this->forge->dropTable('tb_user');
    }
}
