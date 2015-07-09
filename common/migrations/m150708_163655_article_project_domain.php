<?php

use yii\db\Schema;
use yii\db\Migration;

class m150708_163655_article_project_domain extends Migration
{
    public function up()
    {
        $this->addColumn('{{%article}}', 'domain', Schema::TYPE_STRING);
        $this->addColumn('{{%project}}', 'domain', Schema::TYPE_STRING);
    }

    public function down()
    {
        echo "m150708_163655_article_project_domain cannot be reverted.\n";

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
