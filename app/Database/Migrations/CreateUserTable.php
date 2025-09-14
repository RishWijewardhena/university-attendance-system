<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUserTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'user_id' => [
                'type'           => 'INT',
                'constraint'     => 10,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'user_name' => [
                'type'       => 'TEXT',
                'null'       => false,
            ],
            'email' => [
                'type'       => 'VARCHAR',
                'constraint' => 30,
                'null'       => false,
            ],
            'password' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
            ],
            'role_id' => [
                'type'       => 'INT',
                'constraint' => 4,
                'unsigned'   => true,
                'null'       => false,
            ],
            'otp' => [
                'type'       => 'VARCHAR',
                'constraint' => 6,
                'null'       => true,
            ],
            'otp_expiry' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'auth_provider' => [
                'type'       => 'ENUM',
                'constraint' => ['local', 'google'],
                'default'    => 'local',
                'null'       => false,
            ],
            'auth_id' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'created_at' => [
                'type'    => 'TIMESTAMP',
                'default' => 'CURRENT_TIMESTAMP',
            ],

            'updated_at' => [
                'type'    => 'TIMESTAMP',
                'default' => 'CURRENT_TIMESTAMP',
                'on_update' => 'CURRENT_TIMESTAMP',
            ],

            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['active', 'inactive'],
                'default'    => 'active',
                'null'       => false,
            ],  

        ]);

        $this->forge->addKey('user_id', true); // Primary Key
        $this->forge->addForeignKey('role_id', 'roles', 'role_id', 'CASCADE', 'CASCADE'); // Foreign Key
        $this->forge->createTable('user', true);
    }

    public function down()
    {
        $this->forge->dropTable('user', true);
    }
}
