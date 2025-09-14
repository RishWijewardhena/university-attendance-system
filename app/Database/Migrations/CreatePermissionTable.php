<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePermissionTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'permission_id' => [
                'type'           => 'INT',
                'constraint'     => 15,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'permission_name' => [
                'type'       => 'TEXT',
                'null'       => false,
            ],
            'created_at' => [
                'type'    => 'TIMESTAMP',
                'default' => 'CURRENT_TIMESTAMP',
                'on_update' => 'CURRENT_TIMESTAMP',
            ],
        ]);

        $this->forge->addKey('permission_id', true); // Primary Key

        $this->forge->createTable('permission', true);
    }

    public function down()
    {
        $this->forge->dropTable('permission', true);
    }
}
