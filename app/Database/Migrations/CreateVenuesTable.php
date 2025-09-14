<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateVenuesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'venue_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'venue' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => false,
            ],
            'created_at' => [
                'type'    => 'TIMESTAMP',
                'default' => 'CURRENT_TIMESTAMP',
                'on_update' => 'CURRENT_TIMESTAMP',
            ],
        ]);

        $this->forge->addKey('venue_id', true); // Primary Key
        $this->forge->createTable('venues', true);
    }

    public function down()
    {
        $this->forge->dropTable('venues', true);
    }
}
