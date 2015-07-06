<?php

use yii\db\Schema;
use yii\db\Migration;

class m150527_205829_project_description extends Migration
{
    public function up()
    {
        $this->addColumn('{{%project}}', 'description', Schema::TYPE_STRING . '(512) NOT NULL');
    }

    public function down()
    {
        echo "m150527_205829_project_description cannot be reverted.\n";

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
