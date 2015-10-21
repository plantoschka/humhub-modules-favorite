<?php

/**
 * Created by PhpStorm.
 * User: anton
 * Date: 22.05.15
 * Time: 16:25
 *
 * Drop created tables on module uninstall
 */
class uninstall extends ZDbMigration
{
    public function up()
    {
        $this->dropTable('favorite');
    }

    public function down()
    {
        echo "uninstall does not support migration down.\n";
        return false;
    }
}