<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCommentTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'data_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'csv_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => false,
            ],
            'user_id' => [
                'type'       => 'INT',
                'constraint' => 10,
                'unsigned'   => true,
                'null'       => false,
            ],
            'reg_no' => [
                'type'       => 'VARCHAR',
                'constraint' => 11,
                'null'       => false,
            ],
            'name' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => false,
            ],
            'comment_1' => [
                'type' => 'TEXT',
                'null' => false,
            ],
            'comment_2' => [
                'type' => 'TEXT',
                'null' => false,
            ],
            'created_at' => [
                'type'    => 'TIMESTAMP',
                'default' => 'CURRENT_TIMESTAMP',
                'on_update' => 'CURRENT_TIMESTAMP',
            ],
        ]);

        $this->forge->addKey('data_id', true); // Primary Key
        $this->forge->addForeignKey('csv_id', 'csv_table', 'csv_id', 'CASCADE', 'CASCADE'); // Foreign Key
        $this->forge->addForeignKey('user_id', 'user', 'user_id', 'CASCADE', 'CASCADE'); // Foreign Key
        $this->forge->createTable('comment_table', true);
    }

    public function down()
    {
        $this->forge->dropTable('comment_table', true);
    }
}
