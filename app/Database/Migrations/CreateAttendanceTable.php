<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAttendanceTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'attendance_id' => [
                'type'           => 'INT',
                'constraint'     => 30,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'class_id' => [
                'type'       => 'INT',
                'constraint' => 15,
                'unsigned'   => true,
                'null'       => false,
            ],
            'reg_no' => [
                'type'       => 'VARCHAR',
                'constraint' => 15,
                'null'       => false,
            ],
            'attended_at' => [
                'type' => 'DATETIME',
                'null' => false,
            ],
        ]);

        $this->forge->addKey('attendance_id', true); // Primary Key
        // Foreign Key: Links 'class_id' in this table to 'class_id' in 'class' table
        $this->forge->addForeignKey('class_id', 'class', 'class_id', 'CASCADE', 'CASCADE'); // Foreign Key
        

        $this->forge->createTable('attendance', true);
    }

    public function down()
    {
        $this->forge->dropTable('attendance', true);
    }
}
