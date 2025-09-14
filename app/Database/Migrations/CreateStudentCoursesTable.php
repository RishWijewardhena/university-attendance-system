<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateStudentCoursesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'reg_no' => [
                'type'       => 'VARCHAR',
                'constraint' => 15,
                'null'       => false,
            ],
            'email' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => false,
            ],
            'course' => [
                'type'       => 'VARCHAR',
                'constraint' => 10,
                'null'       => false,
            ],
        ]);

        $this->forge->addKey('id', true); // Primary Key
        $this->forge->createTable('student_courses', true);
    }

    public function down()
    {
        $this->forge->dropTable('student_courses', true);
    }
}
