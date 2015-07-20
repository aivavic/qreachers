<?php

use yii\db\Schema;
use yii\db\Migration;

class m150708_163672_client_domain extends Migration
{
    public function up()
    {
        $this->addColumn('{{%client}}', 'domain', Schema::TYPE_STRING);
    }

    public function down()
    {
        echo "m150708_163672_client_domain cannot be reverted.\n";

        return false;
    }
    
    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }
    
    public function safeDown()
    {
    }
    */
}
