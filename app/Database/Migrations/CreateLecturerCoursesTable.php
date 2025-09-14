<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateLecturerCoursesTable extends Migration
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
            'lecturer_email' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => false,
            ],
            'course_code' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => false,
            ],
            'admin_user_id' => [
                'type'       => 'INT',
                'constraint' => 10,
                'null'       => false,
            ],
            'created_at' => [
                'type'    => 'TIMESTAMP',
                'null'    => false,
                'default' => '0000-00-00 00:00:00',
                'on_update' => 'CURRENT_TIMESTAMP',
            ],
        ]);

        $this->forge->addKey('id', true); // Primary Key

        $this->forge->createTable('lecturer_courses', true);
    }

    public function down()
    {
        $this->forge->dropTable('lecturer_courses', true);
    }
}
