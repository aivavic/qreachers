<?php

use yii\db\Schema;
use yii\db\Migration;

class m150544_010724_article_category extends Migration
{

    public function up()
    {
        $this->addColumn('{{%article_category}}', 'locale', Schema::TYPE_STRING);
    }

    public function down()
    {
        echo "m150544_010724_article_category cannot be reverted.\n";

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