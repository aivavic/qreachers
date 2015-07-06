<?php

use yii\db\Schema;
use yii\db\Migration;

class m150609_211010_page_head extends Migration
{
    public function up()
    {
        $this->addColumn('{{%page}}', 'head', Schema::TYPE_TEXT . ' NOT NULL');
    }

    public function down()
    {
        echo "m150609_211010_page_head cannot be reverted.\n";

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
