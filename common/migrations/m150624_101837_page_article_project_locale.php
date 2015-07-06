<?php

use yii\db\Schema;
use yii\db\Migration;

class m150624_101837_page_article_project_locale extends Migration
{
    public function up()
    {
        $this->addColumn('{{%page}}', 'locale', Schema::TYPE_STRING . '(512) NOT NULL DEFAULT "ru-RU"');
        $this->addColumn('{{%article}}', 'locale', Schema::TYPE_STRING . '(512) NOT NULL DEFAULT "ru-RU"');
        $this->addColumn('{{%project}}', 'locale', Schema::TYPE_STRING . '(512) NOT NULL DEFAULT "ru-RU"');

    }

    public function down()
    {
        echo "m150624_101837_page_article_project_locale cannot be reverted.\n";

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
