<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCsvTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'csv_id' => [
                'type'           => 'INT',
                'constraint'     => 10,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'user_id' => [
                'type'       => 'INT',
                'constraint' => 10,
                'unsigned'   => true,
                'null'       => false,
            ],
            'class_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => false,
            ],
            'file_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => false,
            ],
            'active' => [
                'type'       => "ENUM('active', 'inactive', '', ' ')",
                'null'       => false,
            ],
            'created_at' => [
                'type'    => 'TIMESTAMP',
                'default' => 'CURRENT_TIMESTAMP',
            ],
        ]);

        $this->forge->addKey('csv_id', true); // Primary Key
        $this->forge->addForeignKey('user_id', 'user', 'user_id', 'CASCADE', 'CASCADE'); // Foreign Key
        $this->forge->addForeignKey('class_id', 'classes', 'class_id', 'CASCADE', 'CASCADE'); // Foreign Key
        $this->forge->createTable('csv_table', true);
    }

    public function down()
    {
        $this->forge->dropTable('csv_table', true);
    }
}
