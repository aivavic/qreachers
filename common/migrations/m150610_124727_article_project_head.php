<?php

use yii\db\Schema;
use yii\db\Migration;

class m150610_124727_article_project_head extends Migration
{
    public function up()
    {
        $this->addColumn('{{%article}}', 'head', Schema::TYPE_TEXT . ' NOT NULL');
        $this->addColumn('{{%project}}', 'head', Schema::TYPE_TEXT . ' NOT NULL');
    }

    public function down()
    {
        echo "m150610_124727_article_project_head cannot be reverted.\n";

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
