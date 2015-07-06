<?php

use yii\db\Schema;
use yii\db\Migration;

class m150624_144434_page_article_project_locale_group_id extends Migration
{
    public function up()
    {
        $this->addColumn('{{%page}}', 'locale_group_id', Schema::TYPE_INTEGER);
        $this->addColumn('{{%article}}', 'locale_group_id', Schema::TYPE_INTEGER);
        $this->addColumn('{{%project}}', 'locale_group_id', Schema::TYPE_INTEGER);
    }

    public function down()
    {
        echo "m150624_144434_page_article_project_locale_group_id cannot be reverted.\n";

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
