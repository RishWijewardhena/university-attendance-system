<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateRolePermissionTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 15,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'role_id' => [
                'type'       => 'INT',
                'constraint' => 15,
                'unsigned'   => true,
                'null'       => false,
            ],
            'permission_id' => [
                'type'       => 'INT',
                'constraint' => 15,
                'unsigned'   => true,
                'null'       => false,
            ],
            'created_at' => [
                'type'    => 'TIMESTAMP',
                'default' => 'CURRENT_TIMESTAMP',
             
            ],
        ]);

        $this->forge->addKey('id', true); // Primary Key
        $this->forge->createTable('role_permission', true);
    }

    public function down()
    {
        $this->forge->dropTable('role_permission', true);
    }
}
