<?php

/*
 * Database migration
 *
 * Create a favorite table similar to the like table
 */

class m150522_161803_initial extends EDbMigration
{
    public function up()
    {
        $this->createTable('favorite', array(
            'id' => 'pk',
            'target_user_id' => 'int(11) DEFAULT NULL',
            'object_model' => 'varchar(100) NOT NULL',
            'object_id' => 'int(11) NOT NULL',
            'created_at' => 'datetime DEFAULT NULL',
            'created_by' => 'int(11) DEFAULT NULL',
            'updated_at' => 'datetime DEFAULT NULL',
            'updated_by' => 'int(11) DEFAULT NULL',
        ), '');

        $this->createIndex('index_object', 'favorite', 'object_model, object_id', false);
    }

    public function down()
    {
        echo "m150522_161803_initial does not support migration down.\n";
        return false;
    }
}