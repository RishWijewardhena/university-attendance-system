<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateClassesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'class_id' => [
                'type'           => 'INT',
                'constraint'     => 15,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'subject_code' => [
                'type'       => 'VARCHAR',
                'constraint' => 25,
                'null'       => false,
            ],
            'user_id' => [
                'type'       => 'INT',
                'constraint' => 10,
                'unsigned'   => true,
                'null'       => false,
            ],
            
            'scheduled_time' => [
                'type' => 'DATETIME',
                'null' => false,
            ],
            'venue' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => false,
            ],
            'random_code' => [
                'type'       => 'INT',
                'constraint' => 15,
                'null'       => false,
            ],
            'created_at' => [
                'type'    => 'TIMESTAMP',
                'default' => 'CURRENT_TIMESTAMP',
                'on_update' => 'CURRENT_TIMESTAMP',
            ],    
        ]);

        $this->forge->addKey('class_id', true); // Primary Key
        $this->forge->addForeignKey('user_id', 'user', 'user_id', 'CASCADE', 'CASCADE'); // Foreign Key
        
        $this->forge->createTable('classes', true);
    }

    public function down()
    {
        $this->forge->dropTable('classes', true);
    }
}
